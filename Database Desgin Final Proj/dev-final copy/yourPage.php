<?php
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true){
    header("location: login.php");
    exit;
}


include 'top.php';
print '<main>';

if(!empty($_SESSION['passMessage'])){
    print '<h2>' . $_SESSION['passMessage'] . '</h2>';
    $_SESSION['passMessage'] = '';
};

print '<h2>Your List, ' . $_SESSION['userName'] . '</h2>';

?>



<h3>Your Movies:</h3>

<!-- display movies from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$displayYourMovie = 'SELECT pmkContentId, fpkContentId, fpkUserName, pmkContentType, fldName, fldGenre, fldYourRating, fldMainImage ';
$displayYourMovie .= ' FROM tblContent ';
$displayYourMovie .= ' JOIN tblUserPage ON pmkContentId = fpkContentId ';
$displayYourMovie .= ' WHERE pmkContentType = "Movie" AND fpkUserName ="' . $_SESSION['userName'] . '";';
// establish data variable for display function call
// once user info and table stuff is set, this data variable will be used to call the function to display info WHERE the user 
$data = $_SESSION['userName'];

$displayMovies = $thisDatabaseReader->select($displayYourMovie, $data);

// for loop to display each movie thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print '<th>Your Rating</th>';
print '<th>Edit</th>';
print '</tr>';

if (is_array($displayMovies)) {
    foreach ($displayMovies as $movie) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $movie["pmkContentId"] . '">';
        print '<img alt="' . $movie['fldName'] . '" src="images/' . $movie['fldMainImage'] . '"></a>';
        print '<figcaption>' . $movie['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $movie['fldGenre'] . '</td>';
        print '<td>' . $movie['fldYourRating'] . '</td>';
        print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/editPage.php?cid=' .  $movie["pmkContentId"] . '">Edit</a></td>';
        print '</tr>';
    }
}
print '</table>';
?>

<h3>Your TV Shows:</h3>

<!-- display shows from sql statement by title, image, and link to its content page -->
<?php

$displayYourTV = 'SELECT pmkContentId, fpkContentId, fpkUserName, pmkContentType, fldName, fldGenre, fldYourRating, fldVolumeOn, fldEpisodeOn, fldMainImage ';
$displayYourTV .= 'FROM tblContent ';
$displayYourTV .= 'JOIN tblUserPage ON pmkContentId = fpkContentId ';
$displayYourTV .= 'WHERE pmkContentType = "TV Show" AND fpkUserName = "' . $_SESSION['userName'] . '";';

$displayShows = $thisDatabaseReader->select($displayYourTV, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print "<th>Season You're On</th>";
print "<th>Episode You're On</th>";
print "<th>Your Rating</th>";
print '<th>Edit</th>';
print '</tr>';

if (is_array($displayShows)) {
    foreach ($displayShows as $show) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $show["pmkContentId"] . '">';
        print '<img alt="' . $show['fldName'] . '" src="images/' . $show['fldMainImage'] . '"></a>';
        print '<figcaption>' . $show['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $show['fldGenre'] . '</td>';
        print '<td>' . $show['fldVolumeOn'] . '</td>';
        print '<td>' . $show['fldEpisodeOn'] . '</td>';
        print '<td>' . $show['fldYourRating'] . '</td>';
        print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/editPage.php?cid=' .  $show["pmkContentId"] . '">Edit</a></td>';
        print '</tr>';
    }
}
print '</table>';
?>

<h3>Your Books:</h3>


<!-- display books from sql statement by title, image, and link to its content page -->
<?php

$displayYourBook = 'SELECT pmkContentId, fpkContentId, fpkUserName, pmkContentType, fldName, fldGenre, fldYourRating, fldPageOn, fldMainImage ';
$displayYourBook .= 'FROM tblContent ';
$displayYourBook .= 'JOIN tblUserPage ON pmkContentId = fpkContentId ';
$displayYourBook .= 'WHERE pmkContentType = "Book" AND fpkUserName = "' . $_SESSION['userName'] . '";';

$displayBooks = $thisDatabaseReader->select($displayYourBook, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print "<th>Page You're On</th>";
print '<th>Your Rating</th>';
print '<th>Edit</th>';
print '</tr>';

if (is_array($displayBooks)) {
    foreach ($displayBooks as $book) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $book["pmkContentId"] . '">';
        print '<img alt="' . $book['fldName'] . '" src="images/' . $book['fldMainImage'] . '"></a>';
        print '<figcaption>' . $book['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $book['fldGenre'] . '</td>';
        print '<td>' . $book['fldPageOn'] . '</td>';
        print '<td>' . $book['fldYourRating'] . '</td>';
        print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/editPage.php?cid=' .  $book["pmkContentId"] . '">Edit</a></td>';
        print '</tr>';
    }
}
print '</table>';
?>

<h3>Your Manga:</h3>

<!-- display manga from sql statement by title, image, and link to its content page -->
<?php

$displayYourManga = 'SELECT pmkContentId, fpkContentId, fpkUserName, pmkContentType, fldName, fldGenre, fldYourRating, fldVolumeOn, fldChapterOn, fldMainImage ';
$displayYourManga .= 'FROM tblContent ';
$displayYourManga .= 'JOIN tblUserPage ON pmkContentId = fpkContentId ';
$displayYourManga .= 'WHERE pmkContentType = "Manga" AND fpkUserName = "' . $_SESSION['userName'] . '";';

$displayManga = $thisDatabaseReader->select($displayYourManga, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print "<th>Volume You're On</th>";
print "<th>Chapter You're On</th>";
print '<th>Your Rating</th>';
print '<th>Edit</th>';
print '</tr>';

if (is_array($displayManga)) {
    foreach ($displayManga as $manga) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $manga["pmkContentId"] . '">';
        print '<img alt="' . $manga['fldName'] . '" src="images/' . $manga['fldMainImage'] . '"></a>';
        print '<figcaption>' . $manga['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $manga['fldGenre'] . '</td>';
        print '<td>' . $manga['fldVolumeOn'] . '</td>';
        print '<td>' . $manga['fldChapterOn'] . '</td>';
        print '<td>' . $manga['fldYourRating'] . '</td>';
        print '<td>' . '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/editPage.php?cid=' .  $manga["pmkContentId"] . '">Edit</a></td>';
        print '</tr>';
    }
}
print '</table>';

print '</main>';
include 'footer.php';
?>