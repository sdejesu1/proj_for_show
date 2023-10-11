<?php

$recordId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

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
$crossFpk = '';

$userName = '';
$contentEpisodeOn = '';
$contentVolumeOn = '';
$contentChapterOn = '';
$contentPageOn = '';
$contentYourRating = '';
$contentType = '';
$contentName = '';



$displaySql = 'SELECT * FROM tblContent JOIN tblUserPage ON pmkContentId = fpkContentId WHERE pmkRecordId = ?';

$crossData = array($recordId);

$displayUserPages = $thisDatabaseReader->select($displaySql, $crossData);

print '<main>';
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Record ID</th>';
print '<th>User Name</th>';
print '<th>Foreign Content ID</th>';
print '<th>Episode On</th>';
print '<th>Volume On</th>';
print '<th>Chapter On</th>';
print '<th>Page On</th>';
print '<th>Rating</th>';
print '</tr>';

if (is_array($displayUserPages)) {
    foreach ($displayUserPages as $userPage) {
        print '<tr>';
        print '<td>' . $userPage['pmkRecordId'] . '</td>';
        print '<td>' . $userPage["fpkUserName"] . '</td>';
        print '<td>' . $userPage['fpkContentId'] . '</td>';
        print '<td>' . $userPage['fldEpisodeOn'] . '</td>';
        print '<td>' . $userPage['fldVolumeOn'] . '</td>';
        print '<td>' . $userPage['fldChapterOn'] . '</td>';
        print '<td>' . $userPage['fldPageOn'] . '</td>';
        print '<td>' . $userPage['fldYourRating'] . '</td>';
        print '</tr>';

        $userName =  $userPage['fpkUserName'];
        $contentEpisodeOn = $userPage['fldEpisodeOn'];
        $contentVolumeOn = $userPage['fldVolumeOn'];
        $contentChapterOn = $userPage['fldChapterOn'];
        $contentPageOn = $userPage['fldPageOn'];
        $contentYourRating = $userPage['fldYourRating'];
        $contentType = $userPage['pmkContentType'];
        $contentName = $userPage['fldName'];
    }
}

print '</table>';
// processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // save data bool
    $saveData = true;

    $sql = 'INSERT INTO tblUserPage SET pmkRecordId = ?, fpkUserName = ?, ';
    $sql .= 'fpkContentId = ?, ';
    $sql .= 'fldEpisodeOn = ?, ';
    $sql .= 'fldVolumeOn = ?, ';
    $sql .= 'fldChapterOn = ?, ';
    $sql .= 'fldPageOn = ?, ';
    $sql .= 'fldYourRating = ? ';

    $sql .= 'ON DUPLICATE KEY UPDATE fpkUserName = ?, ';
    $sql .= 'fpkContentId = ?, ';
    $sql .= 'fldEpisodeOn = ?, ';
    $sql .= 'fldVolumeOn = ?, ';
    $sql .= 'fldChapterOn = ?, ';
    $sql .= 'fldPageOn = ?, ';
    $sql .= 'fldYourRating = ? ';

    $data = array();
    $data[] = $userName;
    $data[] = $contentId;
    $data[] = $contentEpisodeOn;
    $data[] = $contentVolumeOn;
    $data[] = $contentChapterOn;
    $data[] = $contentPageOn;
    $data[] = $contentYourRating;

    $data[] = $userName;
    $data[] = $contentId;
    $data[] = $contentEpisodeOn;
    $data[] = $contentVolumeOn;
    $data[] = $contentChapterOn;
    $data[] = $contentPageOn;
    $data[] = $contentYourRating;


    if ($contentId == 0) {
        $saveData = false;
    }

    if ($saveData) {
        //Prepare a select statement
        if (DEBUG) {
            print $thisDatabaseWriter->displayQuery($sql, $data);
        }

        if ($thisDatabaseWriter->insert($sql, $data)) {
            print '<h2>Successfully edited! <h2>';
        } else {
            print '<h2>There was an issue, please try again later.</h2>';
        }
    }
}


if (isset($_POST["btnSubmit"])) {
    if (DEBUG) {
        print '<p>POST array:</p><pre>';
        print_r($_POST);
        print '</pre>';
    }
}


?>
<div class="form-style-8">
    <h2>Edit!</h2>
    <form action="<?php print PHP_SELF; ?>" method="post">
        <fieldset>
            <p>
                <label class="required" for="txtContentName">Content Name</label>
                <input type="text" id="txtContentName" name="txtContentName" value="<?php print $contentName; ?>" tabindex="200" required>
            </p>
        </fieldset>

        <?php
        if ($contentType == "TV Show") {
            // fieldset for tv show seasons
            print '<fieldset>';
            print '<p>';
            print '<label for="';
            print 'numContentVolume">What Season Are You On? </label>';
            print '<input type="num" id="numVolumeOn" name="numVolumeOn" value="';
            print $contentVolumeOn;
            print '"tabindex="200"></p>';
            print '</fieldset>';
            // fieldset for tv show episodes
            print '<fieldset>';
            print '<p>';
            print '<label for="';
            print 'numEpisodeOn">What Episode Are You On? </label>';
            print '<input type="num" id="numEpisodeOn" name="numEpisodeOn" value="';
            print $contentEpisodeOn;
            print '"tabindex="200"></p>';
            print '</fieldset>';
        } else if ($contentType == "Book") {
            // fieldset for book page
            print '<fieldset>';
            print '<p>';
            print '<label for="';
            print 'numPageOn">What Page Are You On? </label>';
            print '<input type="num" id="numPageOn" name="numPageOn" value="';
            print $contentPageOn;
            print '"tabindex="200"></p>';
            print '</fieldset>';
        } else if ($contentType == "Manga") {
            // fieldset for manga volumes
            print '<fieldset>';
            print '<p>';
            print '<label for="';
            print 'numContentVolume">What Volume Are You On? </label>';
            print '<input type="num" id="numVolumeOn" name="numVolumeOn" value="';
            print $contentVolumeOn;
            print '"tabindex="200"></p>';
            print '</fieldset>';
            // fieldset for manga chapters
            print '<fieldset>';
            print '<p>';
            print '<label for="';
            print 'numChapterOn">What Chapter Are You On? </label>';
            print '<input type="num" id="numChapterOn" name="numChapterOn" value="';
            print $contentChapterOn;
            print '"tabindex="200"></p>';
            print '</fieldset>';
        }

        ?>
        <fieldset>
            <label for="numYourRating">Rating</label>
            <input type="num" id="numYourRating" name="numYourRating" value="<?php print $contentYourRating; ?>" tabindex="200">
            </p>
        </fieldset>


        <fieldset>
            <p><input type="submit" value="Edit" tabindex="999" name="btnSubmit"></p>
        </fieldset>
    </form>
</div>

</main>

<?php
include 'footer.php';
?>