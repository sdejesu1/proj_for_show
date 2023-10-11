<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Steven De Jesus">
    <meta name="My Entertainment List">

    <!-- special css for form -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/custom.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:850px)" href="css/tablet.css?version=<?php print time(); ?>" type="text/css">
    <link rel="stylesheet" media="(max-width:600px)" href="css/phone.css?version=<?php print time(); ?>" type="text/css">

    <title>My Entertainment List</title>

    <!-- include libraries -->
    <?php
    include 'lib/constants.php';

    print '<!-- make database connections -->';
    require_once(LIB_PATH . '/Database.php');


    $thisDatabaseReader = new Database('sdejesu1_reader', 'r', DATABASE_NAME);

    $thisDatabaseWriter = new Database('sdejesu1_writer', 'w', DATABASE_NAME);
    print '</head>';
    

    print '<body id="' . PATH_PARTS['filename'] . '">';
    print '<!-- ***** START OF BODY ***** -->';

    print PHP_EOL;

    include 'header.php';
    print PHP_EOL;

    include 'nav.php';
    print PHP_EOL;
    ?>