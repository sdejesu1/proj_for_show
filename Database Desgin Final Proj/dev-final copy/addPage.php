<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    header("location: login.php");
    exit;
}

$contentId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

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
$contentEpisodeOn = '';
$contentVolumeOn = '';
$contentChapterOn = '';
$contentPageOn = '';
$contentYourRating = '';


$sqlContent = 'SELECT pmkContentId, pmkContentType, fldName, fldCreator, fldDateReleased, fldVolumeCount, fldChapLength, fldPageCount, fldEpisodeCount, fldGenre, fldRating, fldMainImage ';
$sqlContent .= 'FROM tblContent ';
$sqlContent .= 'WHERE pmkContentId = ?';


$data = array($contentId);
$contents = $thisDatabaseReader->select($sqlContent, $data);


if (is_array($contents)) {
    foreach ($contents as $content) {
        $contentId = $content['pmkContentId'];
        $contentType = $content['pmkContentType'];
        $contentName = $content['fldName'];
        $contentVolumeOn = $content['fldVolumeCount'];
        $contentChapterOn = $content['fldChapLength'];
        $contentPageOn = $content['fldPageCount'];
        $contentEpisodeOn = $content['fldEpisodeCount'];
        $contentYourRating = $content['fldRating'];

        // processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // save data bool
            $saveData = true;

            // sanitizing variables
            $contentEpisodeOn = (int) getData('numEpisodeOn');
            $contentVolumeOn = (int) getData('numVolumeOn');
            $contentChapterOn = (int) getData('numChapterOn');
            $contentPageOn = (int) getData('numPageOn');
            $contentYourRating = (int) getData('numYourRating');

            // processing form data when form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                /*//validate 
                if (empty($contentEpisodeOn)) {
                    $contentEpisodeOn = null;
                }

                if (empty($contentVolumeOn)) {
                    $contentVolumeOn = null;
                }

                if (empty($contentChapterOn)) {
                    $contentChapterOn = null;
                }

                if (empty($contentPageOn)) {
                    $contentPageOn = null;
                }

                if (empty($contentYourRating)) {
                    $contentYourRating = null;
                }*/

                $sql = 'INSERT INTO tblUserPage SET fpkUserName = ?, ';
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
                        print '<h2>Successfully added to your list! <h2>';
                        header("location: yourPage.php");
                        $_SESSION['passMessage'] = 'Successfully Added <em>' . $contentName . '</em> to Your list!';
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
        }
    }
}
?>
<main>
<div class="form-style-8">
    <h2>Add To Your List!</h2>
    <form action="<?php print PHP_SELF . '?cid=' . $contentId; ?>" method="post">


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
            <label for="numYourRating">What Is Your Rating? </label>
            <input type="num" id="numYourRating" name="numYourRating" value="<?php print $contentYourRating; ?>" tabindex="200">
            </p>
        </fieldset>


        <fieldset>
            <p><input type="submit" value="Add To Your List" tabindex="999" name="btnSubmit"></p>
        </fieldset>
    </form>
</div>

</main>

<?php
include 'footer.php';
?>