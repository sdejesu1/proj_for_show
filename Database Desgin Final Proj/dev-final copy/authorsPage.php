<?php
include 'top.php';
print '<main>';
?>

<h2>Author's Page</h2>

<h3>Author's Movies:</h3>

<!-- display movies from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$displaySqlMovie = "SELECT pmkContentId, fldName, fldGenre, fldRating, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Movie\";";

// establish data variable for display function call

// once user info and table stuff is set, this data variable will be used to call the function to display info WHERE the user 
$data = '';

$displayMovies = $thisDatabaseReader->select($displaySqlMovie, $data);

// for loop to display each movie thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print '<th>Rating</th>';
print '</tr>';

if (is_array($displayMovies)) {
    foreach ($displayMovies as $movie) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $movie["pmkContentId"] . '">';
        print '<img alt="' . $movie['fldName'] . '" src="images/' . $movie['fldMainImage'] . '"></a>';
        print '<figcaption>' . $movie['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $movie['fldGenre'] . '</td>';
        print '<td>' . $movie['fldRating'] . '</td>';
        print '</tr>';
    }
}
print '</table>';
?>

<h3>Author's TV Shows:</h3>

<!-- display shows from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$displaySqlTV = "SELECT pmkContentId, fldName, fldChapLength, fldEpisodeCount, fldGenre, fldRating, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"TV Show\";";

$displayShows = $thisDatabaseReader->select($displaySqlTV, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print '<th>Seasons</th>';
print '<th>Episodes Per Season</th>';
print '<th>Rating</th>';
print '</tr>';

if (is_array($displayShows)) {
    foreach ($displayShows as $show) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $show["pmkContentId"] . '">';
        print '<img alt="' . $show['fldName'] . '" src="images/' . $show['fldMainImage'] . '"></a>';
        print '<figcaption>' . $show['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $show['fldGenre'] . '</td>';
        print '<td>' . $show['fldChapLength'] . '</td>';
        print '<td>' . $show['fldEpisodeCount'] . '</td>';
        print '<td>' . $show['fldRating'] . '</td>';
        print '</tr>';
    }
}
print '</table>';
?>


<h3>Author's Books:</h3>

<!-- display books from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$displaySqlBooks = 'SELECT pmkContentId, fldName, fldPageCount, fldGenre, fldRating, fldMainImage';
$displaySqlBooks .= 'FROM tblContent ';
$displaySqlBooks .= 'WHERE pmkContentType = "Book"';

$displaySqlBooks = "SELECT pmkContentId, fldName, fldPageCount, fldGenre, fldRating, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Book\";";

$displayBooks = $thisDatabaseReader->select($displaySqlBooks, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print '<th>Pages</th>';
print '<th>Rating</th>';
print '</tr>';

if (is_array($displayBooks)) {
    foreach ($displayBooks as $book) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $book["pmkContentId"] . '">';
        print '<img alt="' . $book['fldName'] . '" src="images/' . $book['fldMainImage'] . '"></a>';
        print '<figcaption>' . $book['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $book['fldGenre'] . '</td>';
        print '<td>' . $book['fldPageCount'] . '</td>';
        print '<td>' . $book['fldRating'] . '</td>';
        print '</tr>';
    }
}
print '</table>';
?>
<h3>Author's Manga:</h3>

<!-- display manga from sql statement by title, image, and link to its content page -->
<?php

// establish sql variable for display statement
$displaySqlManga = "SELECT pmkContentId, fldName, fldVolumeCount, fldChapLength, fldGenre, fldRating, fldMainImage\n"

    . "FROM tblContent\n"

    . "WHERE pmkContentType = \"Manga\";";

$displayManga = $thisDatabaseReader->select($displaySqlManga, $data);

// for loop to display each show thru its image, along with a link to its content page, then list off some features
print '<table class = "sqlDisplay">';
// column headers
print '<tr>';
print '<th>Name</th>';
print '<th>Genre</th>';
print '<th>Volumes</th>';
print '<th>Chapters</th>';
print '<th>Rating</th>';
print '</tr>';

if (is_array($displayManga)) {
    foreach ($displayManga as $manga) {
        print '<tr>';
        print '<td><figure class = "listContent">';
        print '<a href="//sdejesu1.w3.uvm.edu/cs148/live-final/contentPage.php?cid=' .  $manga["pmkContentId"] . '">';
        print '<img alt="' . $manga['fldName'] . '" src="images/' . $manga['fldMainImage'] . '"></a>';
        print '<figcaption>' . $manga['fldName'] . '</figcaption></figure></td>';
        print '<td>' . $manga['fldGenre'] . '</td>';
        print '<td>' . $manga['fldVolumeCount'] . '</td>';
        print '<td>' . $manga['fldChapLength'] . '</td>';
        print '<td>' . $manga['fldRating'] . '</td>';
        print '</tr>';
    }
}
print '</table>';

print '</main>';
include 'footer.php';
?>