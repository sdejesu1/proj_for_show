<?php

$contentId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

include 'top.php';


print '<main>';
$userName = '';

$sqlUser = 'SELECT pmkUserId, pmkUserName FROM tblUser WHERE pmkUserId = ?';


$data = array($userId);
$users = $thisDatabaseReader->select($sqlUser, $data);


if (is_array($users)) {
    foreach ($user as $user) {
        $userName = $user['pmkUserName'];
    }
    $saveData = true;

    if ($saveData) {
        $sql = 'DELETE FROM tblUser WHERE pmkUserId = ?';
    }


    if (DEBUG) {
        print $thisDatabaseWriter->displayQuery($sql, $data);
    }


    if ($thisDatabaseWriter->delete($sql, $data)) {
        print '<p>Deletion was successful.</p>';
    } else {
        print '<p>There was an issue, please try again later.</p>';
    }
}

print '<div class="form-style-8">';
print '<h2>Deleted ' . $userName . '</h2>'; ?>
</div>
</main>

<?php
include 'footer.php';
?>