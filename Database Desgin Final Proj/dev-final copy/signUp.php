<?php
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

// save data bool
$saveData = true;

// defining variables and initializing with empty variables
$userName = '';
$userNameError = '';
$userEmail = '';
$userEmailError = '';

print '<main>';

// sanitizing variables
$userEmail = getData('txtUserEmail');
$userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);
$userName = getData('txtUserName');


// processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate username
    if (empty($userName)) {
        $userNameError = "Please enter a username.";
        $saveData = false;
    } elseif (!verifyAlphaNum($userName)) {
        $userNameError = "Username can only contain letters, numbers, and underscores.";
        $saveData = false;
    }

    //validate email
    if (empty($userEmail)) {
        $userEmailError = "Please enter an email.";
        $saveData = false;
    } else if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $UserEmailError = "Invalid email format";
        $saveData = false;
    }

    $sql = "SELECT pmkUserName, pmkUserEmail FROM tblUser WHERE pmkUsername = ? AND pmkUserEmail = ?";

    $data = array();
    $data[] = $userName;
    $data[] = $userEmail;



    if ($saveData) {
        //Prepare a select statement

        if ($thisDatabaseReader->select($sql, $data)) {
            print '<h2>This username is already taken.</h2>';
        } else {

            $sql = 'INSERT INTO tblUser SET pmkUsername = ?, ';
            $sql .= 'pmkUserEmail = ? ';


            $data = array();
            $data[] = $userName;
            $data[] = $userEmail;

            if (DEBUG) {
                print $thisDatabaseWriter->displayQuery($sql, $data);
            }

            if ($thisDatabaseWriter->insert($sql, $data)) {
                print '<h2>Thank you for signing up. Check your email for confirmation! <h2>';

                // mail them with mail()
                $to = $userEmail;
                $subject = "Sign Up Confirmation - My Entertainment List";
                $txt = "Thank you for signing up to My Entertainment List! I hope you enjoy the website and its features. Here is your username:\n\n" . $userName . "\n\nOnce again, thanks!";
                $headers = "From: sdejesu1@uvm.edu";

                mail($to, $subject, $txt, $headers);
            } else {
                print '<h2>There was an issue, please try again later.</h2>';
            }
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
    <h2>Sign Up!</h2>
<form action="<?php print PHP_SELF; ?>" method="post">

    <fieldset>
        <p>
            <label class="required" for="txtUserEmail">Email Address</label>
            <input type="email" id="txtUserEmail" name="txtUserEmail" value="<?php if(empty($userEmailError)){print $userEmail;} else {print $userEmailError;} ?>" tabindex="200" required>
        </p>
    </fieldset>

    <fieldset>
        <p>
            <label class = "required" for="txtUserName">User Name</label>
            <input type="text" id="txtUserName" name="txtUserName" value="<?php if(empty($userNameError)){print $userName;} else {print $userNameError;}; ?>" tabindex="200">
        </p>
    </fieldset>


    <fieldset>
        <p><input type="submit" value="Sign Up" tabindex="999" name="btnSubmit"></p>
    </fieldset>
</form>
</div>

</main>

<?php
include 'footer.php';
?>