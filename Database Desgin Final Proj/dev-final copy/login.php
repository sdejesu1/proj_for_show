<?php
session_start();
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


// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    header("location: index.php");
    exit;
}

print '<main>';

// sanitizing variables
$userName = getData('txtUserName');

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validate username
    if (empty($userName)) {
        $userNameError = "Please enter a username.";
        $saveData = false;
    } elseif (!verifyAlphaNum($userName)) {
        $userNameError = "Username can only contain letters, numbers, and underscores.";
        $saveData = false;
    }


    $sql = "SELECT pmkUserName FROM tblUser WHERE pmkUsername = ?";

    $data = array();
    $data[] = $userName;


    if ($saveData) {
        if ($thisDatabaseReader->select($sql, $data)) {

            if (DEBUG) {
                print $thisDatabaseWriter->displayQuery($sql, $data);
            }

            // start new session
            session_start();

            // Store data in session variables
            $_SESSION["loggedIn"] = true;
            $_SESSION["userName"] = $userName;

            // Redirect user to welcome page
            header("location: index.php");
        } else {

            // Username doesn't exist, display a generic error message
            $loginError = "Invalid username.";
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

<h2>Log in!</h2>

<?php
if (!empty($loginError)) {
    print '<h2 class="alert alert-danger">' . $loginError . '</h2>';
}
?>


<div class="form-style-8">
    <h2>Log In</h2>
<form action="<?php print PHP_SELF; ?>" method="post">

    <fieldset>
        <p>
            <label class="required" for="txtUserName">User Name</label>
            <input type="text" id="txtUserName" name="txtUserName" value="<?php if (empty($userNameError)) {
                                                                                print $userName;
                                                                            } else {
                                                                                print $userNameError;
                                                                            }; ?>" tabindex="200">
        </p>
    </fieldset>


    <fieldset>
        <p><input type="submit" value="Log In" tabindex="999" name="btnSubmit"></p>
    </fieldset>
    <p>Don't have an account? <a href="signUp.php">Sign up now</a></p>
</form>
</div>

</main>

<?php
include 'footer.php';
?>