<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: login.php");
    exit;
}

include 'top.php';

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

// defining variables and initializing with empty variables
$userName = $_SESSION['userName'];
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
$contentImage = '';


//future contentId to insert to tblUserPage to match
$contentId = '';
$maxSqlId = 'SELECT MAX(pmkContentId) FROM tblContent ';
$maxSqlIdData = '';
$futureContentId = $thisDatabaseReader->select($maxSqlId, $maxSqlIdData);
if (is_array($futureContentId)) {
    foreach ($futureContentId as $Id) {
        $contentId = $Id['MAX(pmkContentId)'];
        $contentId += 1;
    }
}
// save data bool
$saveData = true;

// sanitizing variables
$contentType = getData('txtContentType');
$contentName = getData('txtContentName');
$contentCreator = getData('txtContentCreator');
$contentGenre = getData('txtContentGenre');
$contentDateReleased = getData("dateReleased");
$contentEpisodes = (int) getData('numEpisodes');
$contentVolumes = (int) getData('numVolumes');
$contentChapters = (int) getData('numChapters');
$contentPages = (int) getData('numPages');
$contentRating = (int) getData('numRating');

// processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = 'INSERT INTO tblContent SET ';
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
    //$data[] = $contentImage;

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
    //$data[] = $contentImage;

    // second sql, table adopters
    $sql2 = 'INSERT INTO tblUserPage SET fpkUserName = ?, ';
    $sql2 .= 'fpkContentId = ?,';
    $sql2 .= 'fldEpisodeOn = ?, ';
    $sql2 .= 'fldVolumeOn = ?, ';
    $sql2 .= 'fldChapterOn = ?, ';
    $sql2 .= 'fldPageOn = ?, ';
    $sql2 .= 'fldYourRating = ? ';

    $sql2 .= 'ON DUPLICATE KEY UPDATE fpkUserName = ?, ';
    $sql2 .= 'fpkContentId = ?, ';
    $sql2 .= 'fldEpisodeOn = ?, ';
    $sql2 .= 'fldVolumeOn = ?, ';
    $sql2 .= 'fldChapterOn = ?, ';
    $sql2 .= 'fldPageOn = ?, ';
    $sql2 .= 'fldYourRating = ? ';

    $data2 = array();
    $data2[] = $userName;
    $data2[] = $contentId;
    $data2[] = $contentEpisodes;
    $data2[] = $contentVolumes;
    $data2[] = $contentChapters;
    $data2[] = $contentPages;
    $data2[] = $contentRating;

    $data2[] = $userName;
    $data2[] = $contentId;
    $data2[] = $contentEpisodes;
    $data2[] = $contentVolumes;
    $data2[] = $contentChapters;
    $data2[] = $contentPages;
    $data2[] = $contentRating;

    if ($saveData) {
        //Prepare a select statement
        if (DEBUG) {
            print $thisDatabaseWriter->displayQuery($sql, $data);
        }

        if (DEBUG) {
            print $thisDatabaseWriter->displayQuery($sql2, $data2);
        }

        if ($thisDatabaseWriter->insert($sql, $data) && $thisDatabaseWriter->insert($sql2, $data2)) {
            print '<h2>Successfully submitted! <h2>';
            header('location: index.php');
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
?>
<main>
    <div class="form-style-8">
        <h2>Submit Some Entertainment!</h2>
        <form action="<?php print PHP_SELF ?>" method="post">

            <fieldset>
                <p>
                    <label class="required" for="txtContentType">Content Type</label>
                    <input type="text" id="txtContentType" name="txtContentType" value="<?php print $contentType;?>" tabindex="200" required>
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
                <p><input type="submit" value="Submit" tabindex="999" name="btnSubmit"></p>
            </fieldset>
        </form>
    </div>

</main>

<?php
include 'footer.php';
?>