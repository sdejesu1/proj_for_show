<?php

$contentId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

include 'top.php';

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


print '<main>';
$contentName = '';

$sqlContent = "SELECT pmkContentId, fldName FROM tblContent WHERE pmkContentId = ?;";

$data = array($contentId);
$contents = $thisDatabaseReader->select($sqlContent, $data);


if (is_array($contents)) {
    foreach ($contents as $content) {
        $contentName = $content['fldName'];
    }
    $saveData = true;

    if ($saveData) {
        $sql = 'DELETE FROM tblContent WHERE pmkContentId = ?';
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
print '<h2>Deleted ' . $contentName . '</h2>'; ?>
</div>
</main>

<?php
include 'footer.php';
?>