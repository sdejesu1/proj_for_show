<?php

$userId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

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
$userName = '';
$userEmail = '';

$userName = getData('txtUserName');
$userEmail = getData('txtUserEmail');


$sqlUser = 'SELECT pmkUserId, pmkUserName, pmkUserEmail FROM tblUser WHERE pmkUserId = ?';


$data = array($userId);
$users = $thisDatabaseReader->select($sqlUser, $data);


if (is_array($users)) {
    foreach ($users as $user) {
        $userName = $user['pmkUserName'];
        $userEmail = $user['pmkUserEmail'];

        // sanitizing variables

        // save data bool
        $saveData = true;

        // processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $sql = 'INSERT INTO tblUser SET pmkUserName = ?,';
            $sql .= 'pmkUserEmail = ? ';

            $sql .= 'ON DUPLICATE KEY UPDATE ';
            $sql .= 'pmkUserName = ?,';
            $sql .= 'pmkUserEmail = ? ';


            $data = array();
            $data[] = $userName;
            $data[] = $userEmail;
    

            $data[] = $userName;
            $data[] = $userEmail;
       


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
    <h2>Update a user (as an admin)!</h2>
<form action="<?php print PHP_SELF; ?>" method="post">

    <fieldset>
        <p>
            <label class="required" for="txtUserEmail">Email Address</label>
            <input type="email" id="txtUserEmail" name="txtUserEmail" value="<?php print $userEmail ?>" tabindex="200" required>
        </p>
    </fieldset>

    <fieldset>
        <p>
            <label class = "required" for="txtUserName">User Name</label>
            <input type="text" id="txtUserName" name="txtUserName" value="<?php print $userName; ?>" tabindex="200">
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