<?php
include 'top.php';
?>

<main>
    <h2>Admin tblUser Records</h2>
    <h2>This is also where you can add, update these records, or delete these records, by clicking edit on the far right side of the record</h2>

    <?php
    // establish sql variable for display statement
    $displaySql = "SELECT * "

        . "FROM tblUser\n";
    // establish data variable for display function call

    // once user info and table stuff is set, this data variable will be used to call the function to display info WHERE the user 
    $data = '';

    $displayUsers = $thisDatabaseReader->select($displaySql, $data);

    // for loop to display each movie thru its image, along with a link to its content page, then list off some features
    print '<table class = "sqlDisplay">';
    // column headers
    print '<tr>';
    print '<th>User ID</th>';
    print '<th>User Name</th>';
    print '<th>User Email</th>';
    print '<th>Date Created</th>';
    print '<th>Insert</th>';
    print '<th>Edit (Update)</th>';
    print '<th>Delete</th>';
    print '</tr>';

    if (is_array($displayUsers)) {
        foreach ($displayUsers as $user) {
            print '<tr>';
            print '<td>' . $user["pmkUserId"] . '</td>';
            print '<td>' . $user['pmkUserName'] . '</td>';
            print '<td>' . $user['pmkUserEmail'] . '</td>';
            print '<td>' . $user['fldCreatedAt'] . '</td>';
            print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/admin/adminUserAddPage.php?cid=' .  $user["pmkUserId"] . '">Add</a></td>';
            print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/admin/adminUserEditPage.php?cid=' .  $user["pmkUserId"] . '">Edit</a></td>';
            print '<td>' . '<a href="#" onclick="checkbox(' . $user["pmkUserId"] . ')">Delete</a></td>';
        }
    }
    print '</table>';

    print '</main>';

    include 'footer.php';
    ?>