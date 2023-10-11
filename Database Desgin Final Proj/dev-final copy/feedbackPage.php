<?php
include 'top.php';

function getData($field)
{
    if (!isset($_POST[$field])) {
        $data = "";
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}

function verifyAlphaNum($text)
{
    //check for all characters that would normally come up in a string and through sanitization
    return (preg_match("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $text));
}

//list
$occupationList = array('Professor', 'TA', 'Student', 'Friend (Outside of school)');

$saveData = false;

$occupation = '';
$radio = '';
$like = '';
$dislike = '';
$design = false;
$content = false;
$quantity = false;
$code = false;
$specify = '';
$email = '';



?>

<main>
    <article class="formArticle">
        <h2 class="formH2">How Do You Like My Website?</h2>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $saveData = true;
            // server side sanitization
            $occupation = getData("lstOccupation");
            $radio = getData("radRating");
            $like = getData("txtLike");
            $dislike = getData("txtDislike");
            $design = (int) getData("chkDesign");
            $content = (int) getData("chkContent");
            $quantity = (int) getData("chkQuantity");
            $code = (int) getData("chkCode");
            $specify = getData("txtSpecify");
            $email = filter_var($_POST['txtEmail'], FILTER_SANITIZE_EMAIL);

            //validation
            if (!in_array($occupation, $occupationList)) {
                print '<h2 class="mistake">Please choose an occupation.</h2>';
                $saveData = false;
            }

            //text boxes
            if ($like == '') {
                print '<h2 class="mistake"> Please tell me what you like.</h2>';
                $saveData = false;
            } elseif (!verifyAlphaNum($like)) {
                print '<h2 class="mistake">Your explanation appears to have extra characters that are invalid. Use numbers and letters only.</h2>';
                $saveData = false;
            }

            if ($dislike == '') {
                print '<h2 class="mistake"> Please tell me what you dislike.</h2>';
                $saveData = false;
            } elseif (!verifyAlphaNum($dislike)) {
                print '<h2 class="mistake">Your explanation appears to have extra characters that are invalid. Use numbers and letters only.</h2>';
                $saveData = false;
            }

            if ($specify == '') {
                print '<h2 class="mistake"> Please tell us your environmental issues.</h2>';
                $saveData = false;
            } elseif (!verifyAlphaNum($specify)) {
                print '<h2 class="mistake">Your explanation appears to have extra characters that are invalid. Use numbers and letters only.</h2>';
                $saveData = false;
            }

            if ($email == '') {
                print '<p class="mistake"> Please tell us your email.</p>';
                $saveData = false;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                print '<h2 class="mistake">Your email is incorrect.</h2>';
                $saveData = false;
            }

            //radio 
            if ($radio != 'Excellent' and $radio != 'Good' and $radio != 'Subpar') {
                print '<h2 class="mistake"> Please choose a rating.</h2>';
                $saveData = false;
            }

            //checkbox
            $totalCheck = $design + $content + $quantity + $code;
            if ($totalCheck < 1) {
                print '<h2 class="mistake"> Please choose an option.</h2>';
                $saveData = false;
            }

            if ($saveData) {
                $sql = 'INSERT INTO tblFeedback (fldOccupation, fldRadio, fldLike, fldDislike, fldDesign, fldContent, fldQuantity, fldCode, fldSpecify, fldEmail) VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

                $data = array($occupation, $radio, $like, $dislike, $design, $content, $quantity, $code, $specify, $email);

                if ($thisDatabaseWriter->insert($sql, $data)) {
                    print '<h2>Thank you for providing feedback. Check your email for confirmation! </h2>';

                    // mail them with mail()
                    $to = $email;
                    $subject = "Feedback Confirmation - My Entertainment List";
                    $txt = "Thank you for providing feedback! I will take this into consideration.";
                    $headers = "From: sdejesu1@uvm.edu";

                    mail($to, $subject, $txt, $headers);
                } else {
                    print '<h2>There was an issue, please try again later.</h2>';
                }
            }
        }

        ?>


</div>
        <div class="form-style-8">     
        <h2>Provide Feedback</h2> 
        <form class="actualForm" action="#" method="POST">
            <fieldset class="listbox">
                <legend>What's Your Occupation? (How are you seeing this?)</legend>
                <p>
                    <select id="lstOccupation" name="lstOccupation" tabindex="120">
                        <option value="Professor" <?php if ($occupation == 'Professor') print 'selected'; ?>>Professor</option>
                        <option value="TA" <?php if ($occupation == 'TA') print 'selected'; ?>>TA</option>
                        <option value="Student" <?php if ($occupation == 'Student') print 'selected'; ?>>Student</option>
                        <option value="Friend (Outside of school)" <?php if ($occupation == 'Friend (Outside of school)') print 'selected'; ?>>Friend (Outside of school)</option>
                    </select>
                </p>
            </fieldset>

            <fieldset class="radio">
                <legend>Excellent, Good, or Subpar? </legend>
                <p>
                    <input type="radio" name="radRating" id="radExcellent" value="Excellent" <?php if ($radio == "Excellent") print 'checked'; ?> required>
                    <label for="radExcellent">Excellent</label>
                </p>
                <p>
                    <input type="radio" name="radRating" id="radGood" value="Good" <?php if ($radio == "Good") print 'checked'; ?> required>
                    <label for="radGood">Good</label>
                </p>
                <p>
                    <input type="radio" name="radRating" id="radSubpar" value="Subpar" <?php if ($radio == "Subpar") print 'checked'; ?> required>
                    <label for="radSubpar">Subpar</label>
                </p>
            </fieldset>

            <fieldset>
                <legend>What did you like most about my sites?</legend>
                <p>
                    <input type="text" name="txtLike" id="txtLike" placeholder="You like..." value="<?php print $like; ?>">
                </p>
            </fieldset>

            <fieldset>
                <legend>What did you dislike most about my sites?</legend>
                <p>
                    <input type="text" name="txtDislike" id="txtDislike" placeholder="You dislike..." value="<?php print $dislike; ?>">
                </p>
            </fieldset>

            <fieldset class="checkbox">
                <legend>What do you think can be improved on? (choose all that apply):</legend>
                <p>
                    <input type="checkbox" name="chkDesign" id="chkDesign" value="1" <?php if ($design) print 'checked'; ?>>
                    <label for="chkDesign">Design (CSS)</label>
                </p>
                <p>
                    <input type="checkbox" name="chkContent" id="chkContent" value="1" <?php if ($content) print 'checked'; ?>>
                    <label for="chkContent">Content (what I actually wrote)</label>
                </p>
                <p>
                    <input type="checkbox" name="chkQuantity" id="chkQuantity" value="1" <?php if ($quantity) print 'checked'; ?>>
                    <label for="chkQuantity">Quantity of Sites (Explain of what in the text below)</label>
                </p>
                <p>
                    <input type="checkbox" name="chkCode" id="chkCode" value="1" <?php if ($code) print 'checked'; ?>>
                    <label for="chkCode">(For TAs and Professors) Quality of Code</label>
                </p>
            </fieldset>
            <fieldset>
                <legend>Specify and explain further (optional):</legend>
                <p>
                    <textarea id="txtSpecify" name="txtSpecify" placeholder="Specify..." rows="7" cols="50" onkeyup="adjust_textarea(this)"></textarea><?php print $specify; ?></textarea>
                </p>

                <p>
                    <label class="required" for="txtEmail">What is your email?</label>
                    <input type="email" name="txtEmail" id="txtEmail" placeholder="Your email..." value="<?php print $email; ?>" required>
                </p>

                <p class="submit">
                    <input type="submit" value="Submit">
                </p>
            </fieldset>
        </form>
    </article>
</main>
<?php
include 'footer.php';
?>
</body>

</html>