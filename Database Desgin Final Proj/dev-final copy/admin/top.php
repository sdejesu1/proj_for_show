<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Steven De Jesus">
    <meta name="My Entertainment List">


    <title>My Entertainment List: Admin Page</title>

    <!-- special css for form -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/custom.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:800px)" href="../css/tablet.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:600px)" href="../css/phone.css?version=<?php print time(); ?>" type="text/css">

    <!-- include libraries -->
    <?php
    include '../lib/constants.php';

    print '<!-- make database connections -->';
    require_once('../' . LIB_PATH . 'Database.php');


    $thisDatabaseReader = new Database('sdejesu1_reader', 'r', DATABASE_NAME);

    $thisDatabaseWriter = new Database('sdejesu1_writer', 'w', DATABASE_NAME);

    // users net id variable
    $netID = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");

    $sql  = 'SELECT pmkNetId FROM tblAdminNetId WHERE pmkNetId = ?';
    $data = array($netID);

    $netIdCheck = '';
    $adminCheck = $thisDatabaseReader->select($sql, $data);

    if(is_array($adminCheck)){
        foreach ($adminCheck as $check) {
            $netIdCheck = $check['pmkNetId'];
            
            if($netID != $netIdCheck){
                die("<h2>You are not an admin (Your net id isn't in my database)</h2>");
        }
    }
}

?>
<script type="text/javascript">
function checkbox(recordId) {
  
  var confirmmessage = "Are you sure you want to continue?";
  var go = "<?php print PATH_PARTS['filename'] . 'DeletePage.php?cid='?>" + recordId;
  var message = "Action Was Cancelled By User";
  
  if (confirm(confirmmessage)) {
  
      window.location = go;
  
  } else {
  
       alert(message);
  
  }
  
}
</script>

<?php
                
    print '</head>';

    print '<body id="' . PATH_PARTS['filename'] . '">';
    print '<!-- ***** START OF BODY ***** -->';

    print PHP_EOL;

    include 'header.php';
    print PHP_EOL;

    include 'nav.php';
    print PHP_EOL;
    ?>