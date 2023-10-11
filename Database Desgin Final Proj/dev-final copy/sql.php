<?php
include 'top.php';
?>
<main>
    
<p>Creating the tables for the database : the user, user page, content, feedback, and contact table</p>
<code>
CREATE TABLE `tblUser` (
  `pmkUsername` varchar(50) NOT NULL,
  `pmkUserEmail` varchar(50) NOT NULL,
  `fldDateJoined` DATE
);

CREATE TABLE `tblUserPage` (
  `fpkUserName` varchar(50) NOT NULL,
  `fpkContentId` int(11) NOT NULL,
  `fldEpisodeOn` int(11) DEFAULT NULL,
  `fldVolumeOn` varchar(50) DEFAULT NULL,
  `fldChapterOn` int(11) DEFAULT NULL
  `fldPageOn` varchar(50) DEFAULT NULL,
  `fldRating` varchar(50) DEFAULT NULL,
  CONSTRAINT UsernameContentIdConstraint UNIQUE (fpkUserName, fpkContentId);
);



CREATE TABLE `tblContent` (
  `pmkContentId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pmkContentType` varchar(50) NOT NULL,
  `fldName` varchar(50) NOT NULL,
  `fldCreator` varchar(50) NOT NULL,
  `fldDateReleased` date,
  `fldVolumeCount` int(11) NOT NULL,
  `fldChapLength` int(11) NOT NULL,
  `fldPageCount` int(11) NOT NULL,
  `fldEpisodeCount` int(11) NOT NULL,
  `fldGenre` varchar(50) NOT NULL,
  `fldRating` int(11) NOT NULL,
  `fldMainImage` varchar(50) NOT NULL
);

CREATE TABLE `tblFeedback` (
  `pmkFeedbackId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fldEmail` varchar(50) DEFAULT NULL,
  `fldOccupation` varchar(50) DEFAULT NULL,
  `fldRadio` varchar(20) DEFAULT NULL,
  `fldLike` varchar(200) DEFAULT NULL,
  `fldDislike` varchar(200) DEFAULT NULL,
  `fldDesign` tinyint(1) DEFAULT NULL,
  `fldContent` tinyint(1) DEFAULT NULL,
  `fldQuantity` tinyint(1) DEFAULT NULL,
  `fldCode` tinyint(1) DEFAULT NULL,
  `fldSpecify` varchar(50) DEFAULT NULL
);

CREATE TABLE `tblAdminNetId` (
  `pmkNetId` varchar(50) NOT NULL,
  `fpkUserEmail` varchar(50) NOT NULL
);
</code>

<p>insert statements for content</p>

<p>movies</p>
<code>
  INSERT INTO 
  tblContent 
  (
    pmkContentType, fldName, fldCreator, fldDateReleased, fldGenre, fldRating, fldMainImage
  )
  VALUES
  ('Movie', 'It Happened One Night', 'Frank Capra', '1932-02-22', 'Romance', 99, 'it_happened_one_night.jpg'),

  ('Movie', 'Citizen Kane', 'Orson Welles', '1941-05-01', 'Drama', 99, 'citizenKane.jpg'),

  ('Movie', 'The Wizard of Oz', 'Victor Fleming', '1939-08-25', 'Fantasy, Musical', 98, 'wizardOfOz.jpg'),

  ('Movie', 'Modern Times', 'Charlie Chaplin', '1936-02-25', 'Comedy', 98, 'modernTimes.jpg'),


<p>TV Shows</p>
<code>
  INSERT INTO 
  tblContent 
  (
    pmkContentType, fldName, fldCreator, fldDateReleased, fldChapLength, fldEpisodeCount, fldGenre, fldRating, fldMainImage
  )
  VALUES
  ('TV Show', 'Peacemaker', 'James Gunn', '2022-01-13', 1, 8, 'Action, Comedy', 94, 'peacemaker.jpg'),

  ('TV Show', 'Archive 81', 'Rebecca Thomas', '2022-01-14', 1, 8, 'Horror, Thriller', 86, 'archive81.jpg'),

  ('TV Show', 'The Book of Boba Fett', 'Jon Favreau', '2021-12-29', 1, 7, 'Action, Adventure', 68, 'bobaFett.jpg'),

  ('TV Show', 'Yellowjackets', 'Ashley Lyle', '2021-11-14', 1, 10, 'Drama', 100, 'yellowjackets.jpg'),

  ('TV Show', 'Euphoria', 'Sam Levinson', '2022-01-09', 2, 8, 'Drama', 81, 'euphoria.jpg');

  
</code>

<p>Books</p>
<code>
  INSERT INTO 
  tblContent 
  (
    pmkContentType, fldName, fldCreator, fldDateReleased, fldPageCount, fldGenre, fldRating, fldMainImage
  )
  VALUES
  ('Book', 'The Last Days of Roger Federer', 'Geoff Dyer', '2022-05-03', 304, 'Biography', 86, 'lastDaysRoger.jpg'),

  ('Book', 'Sea of Tranquility', 'Emily St. John Mandel', '2022-04-05', 448, 'Science Fiction', 86, 'seaTranquility.jpg'),

  ('Book', 'The Trayvon Generation', 'Elizabeth Alexander', '2022-04-05', 304, 'Nonfiction', 84, 'trayvonGen.jpg');


  ('Book', 'No Longer Human', 'Osamu Dazai', '1973-01-17', 177, 'Classic Literature and Fiction', 90, 'noHuman.jpg');
  ('Book', 'The Art of War', 'Sun Tzu', '2019-04-17', 96, 'Philosophy', 95, 'artWar.jpg');
  ('Book', 'The 48 Laws of Power', 'Robert Greene', '2000-09-01', 452, 'Sociology', 85, '48Pow.jpg');
  ('Book', 'The Paper Palace', 'Miranda Cowley Heller', '2021-07-06', 397, 'Fiction', 80, 'paperPalace.jpg');

</code>

<p>Manga</p>
<code>
  INSERT INTO 
  tblContent 
  (
    pmkContentType, fldName, fldCreator, fldDateReleased, fldVolumeCount, fldChapLength, fldGenre, fldRating, fldMainImage
  )
  VALUES
  ('Manga', 'Berserk', 'Kentaro Miura', '1989-08-01', 41, 364, 'Seinen, Dark Fantasy', 100, 'berserk.jpg'),

  ('Manga', 'Vagabond', 'Takehiko Inoue', '1998-09-17', 37, 328, 'Seinen', 100, 'vagabond.jpg'),

  ('Manga', 'One Piece', 'Eiichiro Oda', '1997-12-24', 102, 1048, 'Shonen, Adventure', 100, 'onePiece.jpg');
  
  ('Manga', 'BLAME!', 'Tsutomu Nihei', '1998-06-24', 10, 67, 'Shonen, Adventure', 100, 'onePiece.jpg');
  ('Manga', 'Demon Slayer', 'Koyoharu Gotouge', '1997-12-24', 23, 200, 'Seinen, Action', 100, 'demonSlayer.jpg');
  ('Manga', 'Death Note', 'Takeshi Obata', '2003-12-01', 12, 108, 'Seinen, Psychological', 100, 'deathNote.jpg');
  ('Manga', 'Naruto', 'Masashi Kishimoto', '1999-09-21', 72, 700, 'Shonen, Adventure', 100, 'naruto.jpg');

</code>

<p>SELECT WHERE statements, to display movies, tv shows, books, and manga</p>
<code>
SELECT pmkContentId, fldName, fldGenre, fldRating, fldMainImage\n"

. "FROM tblContent\n"

. "WHERE pmkContentType = \"Movie\";
</code>

<p>Adding constraint to tblUserPage for combo of username and content id</p>
<code>
ALTER TABLE tblUserPage
ADD CONSTRAINT UsernameContentIdConstraint UNIQUE (fpkUserName, fpkContentId);
</code>


</main>

<?php include 'footer.php'; ?>
