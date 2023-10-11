<?php
include 'top.php';
?>

<main>
    <h2>Admin tblUserPage Records</h2>
    <h2>This is also where you can add, update these records, or delete these records, by clicking edit on the far right side of the record</h2>

    <?php

    // establish sql variable for display statement
    $displaySql = "SELECT * "

        . "FROM tblUserPage\n";
    // establish data variable for display function call
    // once user info and table stuff is set, this data variable will be used to call the function to display info WHERE the user 
    $data = '';

    $displayUserPages = $thisDatabaseReader->select($displaySql, $data);

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
    print '<th>Insert</th>';
    print '<th>Edit (Update)</th>';
    print '<th>Delete</th>';
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
            print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/admin/adminUserPageAddPage.php?cid=' .  $userPage["pmkRecordId"] . '">Add</a></td>';
            print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/admin/adminUserPageEditPage.php?cid=' .  $userPage['pmkRecordId'] . '">Edit</a></td>';
            print '<td>' . '<a href="#" onclick="checkbox(' . $userPage["pmkRecordId"] . ')">Delete</a></td>';
            print '</tr>';
        }
    }
    print '</table>';

    print '</main>';

    include 'footer.php';
    ?>