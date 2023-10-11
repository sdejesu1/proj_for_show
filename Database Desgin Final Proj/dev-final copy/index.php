<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true){
    header("location: login.php");
    exit;
}


include 'top.php';
print '<main>';
?>
<h2>Your Home, <?php print $_SESSION['userName'] ?></h2>


<h3>Recommended Movies:</h3>

<!-- display movies from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$sqlMovie = "SELECT pmkContentId, pmkContentType, fldName, fldGenre, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Movie\";";

// establish data variable for display function call
$data = '';

$movies = $thisDatabaseReader->select($sqlMovie, $data);

print '<div class = "row-content">';
// for loop to display each movie thru its image, along with a link to its content page, then list off some features
if (is_array($movies)){
    foreach($movies as $movie){
        
        print '<figure class = "indexContent">';
        print '<figcaption>' . $movie['fldName'] . '</figcaption>';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $movie["pmkContentId"] . '">';
        print '<img alt="' . $movie['fldName'] . '" src="images/' . $movie['fldMainImage'] . '"></a>';
        print '<figcaption>' . $movie['fldGenre'] . '</figcaption>';
        print '</figure>';
    }
}
print '</div>';
?>


<h3>Recommended TV Shows:</h3>

<!-- display shows from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$sqlTV = "SELECT pmkContentId, pmkContentType, fldName, fldGenre, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"TV Show\";";


$shows = $thisDatabaseReader->select($sqlTV, $data);

print '<div class = "row-content">';
// for loop to display each show thru its image, along with a link to its content page, then list off some features
if (is_array($shows)){
    foreach($shows as $show){
        
        print '<figure class = "indexContent">';
        print '<figcaption>' . $show['fldName'] . '</figcaption>';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $show["pmkContentId"] . '">';
        print '<img alt="' . $show['fldName'] . '" src="images/' . $show['fldMainImage'] . '"></a>';
        print '<figcaption>' . $show['fldGenre'] . '</figcaption>';
        print '</figure>';
    }
}
print '</div>';
?>

<h3>Recommended Books:</h3>

<!-- display books from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$sqlBook = "SELECT pmkContentId, pmkContentType, fldName, fldGenre, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Book\";";


$books = $thisDatabaseReader->select($sqlBook, $data);

print '<div class = "row-content">';
// for loop to display each book thru its image, along with a link to its content page, then list off some features
if (is_array($books)){
    foreach($books as $book){
        print '<figure class = "indexContent">';
        print '<figcaption>' . $book['fldName'] . '</figcaption>';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $book["pmkContentId"] . '">';
        print '<img alt="' . $book['fldName'] . '" src="images/' . $book['fldMainImage'] . '"></a>';
        print '<figcaption>' . $book['fldGenre'] . '</figcaption>';
        print '</figure>';
    }
}
print '</div>';
?>

<h3>Recommended Manga:</h3>

<!-- display manga from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$sqlManga = "SELECT pmkContentId, pmkContentType, fldName, fldGenre, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Manga\";";


$mangas = $thisDatabaseReader->select($sqlManga, $data);

print '<div class = "row-content">';
// for loop to display each book thru its image, along with a link to its content page, then list off some features
if (is_array($mangas)){
    foreach($mangas as $manga){
        print '<figure class = "indexContent">';
        print '<figcaption>' . $manga['fldName'] . '</figcaption>';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $manga["pmkContentId"] . '">';
        print '<img alt="' . $manga['fldName'] . '" src="images/' . $manga['fldMainImage'] . '"></a>';
        print '<figcaption>' . $manga['fldGenre'] . '</figcaption>';
        print '</figure>';
    }
}
print '</div>';



print '</main>';

include 'footer.php';
?>