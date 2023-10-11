<?php
include 'top.php';

$contentId = (isset($_GET['cid'])) ? (int) htmlspecialchars($_GET['cid']) : 0;

$sqlContent = 'SELECT pmkContentId, pmkContentType, fldName, fldCreator, fldDateReleased, fldVolumeCount, fldChapLength, fldPageCount, fldEpisodeCount, fldGenre, fldRating, fldMainImage ';
$sqlContent .= 'FROM tblContent ';
$sqlContent .= 'WHERE pmkContentId = ?';


$data = array($contentId);
$contents = $thisDatabaseReader->select($sqlContent, $data);

print '<main>';

if(is_array($contents)){
    foreach($contents as $content){

        // add to my list link , make it an aside
        print '<h2><a href="addPage.php?cid=';
        print $content["pmkContentId"] . '">Add <em>' . $content["fldName"] . '</em> To Your List!</a></h2>';

        // content type
        print '<h2>' . $content['pmkContentType'] . '</h2>';

        // figure element for image, + figcaption
        print '<figure class = "contentPageImage"> <img src="./images/' . $content["fldMainImage"] . '"alt="' . $content["fldName"] . '">';
        //print '<figcaption>' . $content["fldName"] . '</figcaption></figure>';

        // name
        print '<h2>' . $content["fldName"] . '</h2>';

        // creator
        print '<h3>' . $content["fldCreator"] . '</h3>';

        // genre
        print '<h3>' . $content["fldGenre"] . '</h3>';

        // if tv
        if ($content['pmkContentType'] == 'TV Show'){
            // volume count (Seasons)
            print '<h3>Seasons: ' . $content["fldChapLength"] . '</h3>';
            // episode count
            print '<h3>Episodes Per Season: ' . $content["fldEpisodeCount"] . '</h3>';
        }

        
        // if manga
        if ($content['pmkContentType'] == 'Manga'){
            // volume count
            print '<h3>Volumes: ' . $content["fldVolumeCount"] . '</h3>';
             // chapter count
            print '<h3>Chapters: ' . $content["fldChapLength"] . '</h3>';
        }

        // if book
        if ($content['pmkContentType'] == 'Book'){
            // page count
            print '<h3>Pages: ' . $content["fldPageCount"] . '</h3>';
        }

       
        // rating
        print '<h3>Rating: ' . $content["fldRating"] . '/100</h3>';

        // date released
        print '<h3>Date Released: ' . $content["fldDateReleased"] . '</h3>';


    }
}

print '</main>';
include 'footer.php';
?>