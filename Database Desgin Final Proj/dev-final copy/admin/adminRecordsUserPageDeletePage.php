<?php

$recordId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

include 'top.php';


print '<main>';
$userName = '';

$sqlUserPage = 'SELECT pmkRecordId, fpkUserName FROM tblUserPage WHERE pmkRecordId = ?';


$data = array($recordId);
$userPage = $thisDatabaseReader->select($sqlUserPage, $data);


if (is_array($userPage)) {
    foreach ($userPage as $user) {
        $userName = $user['fpkUserName'];
    }
    $saveData = true;

    if ($saveData) {
        $sql = 'DELETE FROM tblUserPage WHERE pmkRecordId = ?';
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
print '<h2>Deleted record #' . $recordId . '</h2>'; ?>
</div>
</main>

<?php
include 'footer.php';
?>