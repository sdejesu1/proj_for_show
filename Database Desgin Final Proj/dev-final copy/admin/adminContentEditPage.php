<?php

$contentId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

include 'top.php';

// getData function
// Sanatize function from the text
function getData($field)
{
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data, ENT_QUOTES);
    }
    return $data;
}

// verify alpha nums function
function verifyAlphaNum($text)
{
    //check for all characters that would normally come up in a string and through sanitization
    return (preg_match("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $text));
}

print '<main>';

// defining variables and initializing with empty variables
$contentType = '';
$contentName = '';
$contentCreator = '';
$contentGenre = '';
$contentDateReleased = '';
$contentEpisodes = '';
$contentVolumes = '';
$contentChapters = '';
$contentPages = '';
$contentRating = '';


$sqlContent = 'SELECT pmkContentId, pmkContentType, fldName, fldCreator, fldDateReleased, fldVolumeCount, fldChapLength, fldPageCount, fldEpisodeCount, fldGenre, fldRating ';
$sqlContent .= 'FROM tblContent ';
$sqlContent .= 'WHERE pmkContentId = ?';


$data = array($contentId);
$contents = $thisDatabaseReader->select($sqlContent, $data);


if (is_array($contents)) {
    foreach ($contents as $content) {
        $contentType = $content['pmkContentType'];
        $contentName = $content['fldName'];
        $contentCreator = $content['fldCreator'];
        $contentGenre = $content['fldGenre'];
        $contentDateReleased = $content['fldDateReleased'];
        $contentVolumes = $content['fldVolumeCount'];
        $contentChapters = $content['fldChapLength'];
        $contentPages = $content['fldPageCount'];
        $contentEpisodes = $content['fldEpisodeCount'];
        $contentRating = $content['fldRating'];

        // sanitizing variables
        $contentCreator = getData('txtContentCreator');
        $contentGenre = getData('txtContentGenre');
        $contentDateReleased = getData("dateReleased");
        $contentEpisodes = (int) getData('numEpisodes');
        $contentVolumes = (int) getData('numVolumes');
        $contentChapters = (int) getData('numChapters');
        $contentPages = (int) getData('numPages');
        $contentRating = (int) getData('numRating');


        // save data bool
        $saveData = true;

        // processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $sql = 'INSERT INTO tblContent SET pmkContentId = ?,';
            $sql .= 'pmkContentType = ?, ';
            $sql .= 'fldName = ?, ';
            $sql .= 'fldCreator = ?, ';
            $sql .= 'fldDateReleased = ?, ';
            $sql .= 'fldVolumeCount = ?, ';
            $sql .= 'fldChapLength = ?, ';
            $sql .= 'fldPageCount= ?, ';
            $sql .= 'fldEpisodeCount= ?, ';
            $sql .= 'fldGenre = ?, ';
            $sql .= 'fldRating = ?';

            $sql .= 'ON DUPLICATE KEY UPDATE ';
            $sql .= 'pmkContentType = ?, ';
            $sql .= 'fldName = ?, ';
            $sql .= 'fldCreator = ?, ';
            $sql .= 'fldDateReleased = ?, ';
            $sql .= 'fldVolumeCount = ?, ';
            $sql .= 'fldChapLength = ?, ';
            $sql .= 'fldPageCount= ?, ';
            $sql .= 'fldEpisodeCount= ?, ';
            $sql .= 'fldGenre = ?, ';
            $sql .= 'fldRating = ?';

            $data = array();
            $data[] = $contentId;
            $data[] = $contentType;
            $data[] = $contentName;
            $data[] = $contentCreator;
            $data[] = $contentDateReleased;
            $data[] = $contentVolumes;
            $data[] = $contentChapters;
            $data[] = $contentPages;
            $data[] = $contentEpisodes;
            $data[] = $contentGenre;
            $data[] = $contentRating;

            $data[] = $contentType;
            $data[] = $contentName;
            $data[] = $contentCreator;
            $data[] = $contentDateReleased;
            $data[] = $contentVolumes;
            $data[] = $contentChapters;
            $data[] = $contentPages;
            $data[] = $contentEpisodes;
            $data[] = $contentGenre;
            $data[] = $contentRating;


            if ($saveData) {
                //Prepare a select statement
                if (DEBUG) {
                    print $thisDatabaseWriter->displayQuery($sql, $data);
                }



                if ($thisDatabaseWriter->insert($sql, $data)) {
                    print '<h2>Successfully updated! <h2>';
                } else {
                    print '<h2>There was an issue, please try again later.</h2>';
                }
            }

            if (isset($_POST["btnSubmit"])) {
                if (DEBUG) {
                    print '<p>POST array:</p><pre>';
                    print_r($_POST);
                    print '</pre>';
                }
            }
        }
    }
}
?>
<div class="form-style-8">
    <h2>Edit (update)</h2>
    <form action="<?php print PHP_SELF ?>" method="post">

        <fieldset>
            <p>
                <label class="required" for="txtContentType">Content Type</label>
                <input type="text" id="txtContentType" name="txtContentType" value="<?php print $contentType; ?>" tabindex="200" required>
            </p>
        </fieldset>


        <fieldset>
            <p>
                <label class="required" for="txtContentName">Content Name</label>
                <input type="text" id="txtContentName" name="txtContentName" value="<?php print $contentName; ?>" tabindex="200" required>
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label class="required" for="txtContentCreator">Content Creator</label>
                <input type="text" id="txtContentCreator" name="txtContentCreator" value="<?php print $contentCreator; ?>" tabindex="200" required>
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="txtContentGenre">Content Genre (Optional)</label>
                <input type="text" id="txtContentGenre" name="txtContentGenre" value="<?php print $contentGenre; ?>" tabindex="200">
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="dateReleased">Date Released</label>
                <input type="date" id="dateReleased" name="dateReleased" value="<?php print $contentDateReleased; ?>" tabindex="200">
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="numVolumes">Volumes (Optional, For Manga, or "Seasons" For TV)</label>
                <input type="num" id="numVolumes" name="numVolumes" value="<?php print $contentVolumes; ?>" tabindex="200">
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="numEpisodes">Episodes (Optional, For TV)</label>
                <input type="num" id="numEpisodes" name="numEpisodes" value="<?php print $contentEpisodes; ?>" tabindex="200">
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="numChapters">Chapters (Optional, For Manga)</label>
                <input type="num" id="numChapters" name="numChapters" value="<?php print $contentChapters; ?>" tabindex="200">
            </p>
        </fieldset>

        <fieldset>
            <p>
                <label for="numPages">Pages (Optional, For Books)</label>
                <input type="num" id="numPages" name="numPages" value="<?php print $contentPages; ?>" tabindex="200">
            </p>
        </fieldset>


        <fieldset>
            <p>
                <label for="numRating">Rating </label>
                <input type="num" id="numRating" name="numRating" value="<?php print $contentRating; ?>" tabindex="200">
            </p>
        </fieldset>


        <fieldset>
            <p><input type="submit" value="Update" tabindex="999" name="btnSubmit"></p>
        </fieldset>
    </form>
</div>

</main>

<?php
include 'footer.php';
?>