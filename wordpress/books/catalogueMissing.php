<?php

require_once("catalogueFunctions.php");
$db=dbopen() or die ("Nem sikerült az adatbázis megnyitása.");

# -----------
# HIBAJEGYZÉK
# -----------

$i=0;
$body="<h2>Katalógusnév (catalogueurl) nélküli, katalógusban megjelenő nyomtatott könyvek</h2>";
$sql="select * from books where (status=3 or status=5) and onlineshop=2 and sponsor<6 and (catalogueurl='' or catalogueurl is null)";
foreach ($db->query($sql) as $r) {extract($r);$body.="<p>$idbook $author: $title $coverfile</p>";$i++;}
$body.= "<p>$i címnél hiányzik a katalóguslap (lekérés: <em>$sql</em>)</p>";

$i=0;
$body.="<h2>Megjelenési határozás nélküli (onlineshop is null) nyomtatott könyvek</h2>";
$sql="select * from books where (status=3 or status=5) and sponsor<6 and (onlineshop  is null)";
foreach ($db->query($sql) as $r) {extract($r);$body.="<p>$idbook $author: $title $coverfile</p>";$i++;}
$body.= "<p>$i címnél hiányzik a döntés a nyilvános megjelenítésről (lekérés: <em>$sql</em>)</p>";

$i=0;
$body.="<h2>A katalógusban nem megjelenő nyomtatott könyvek</h2>";
$sql="select * from books where (status=3 or status=5) and sponsor<6 and onlineshop=1";
foreach ($db->query($sql) as $r) {extract($r);$body.="<p>$idbook $author: $title $coverfile</p>";$i++;}
$body.= "<p>$i cím nem jelenik meg a katalógusban (lekérés: <em>$sql</em>)</p>";

$i=0;
$body.="<h2>A katalógusban kétszer megjelenő nyomtatott könyvek</h2>";
$sql="SELECT title FROM books where (status=3 or status=5) and sponsor<6 and onlineshop=2 GROUP BY title HAVING count(*) > 1;";
foreach ($db->query($sql) as $r) {extract($r);$body.="<p>$idbook $author: $title $coverfile</p>";$i++;}
$body.= "<p>$i cím jelenik meg többször a katalógusban (lekérés: <em>$sql</em>)</p>";

$i=0;
$body.="<h2>Borítókép (coverfile) nélküli nyomtatott könyvek</h2>";
$sql="select * from books where status=3 and sponsor<6 and onlineshop=2 and coverfile=''";
foreach ($db->query($sql) as $r) {extract($r);$body.="<p>$idbook $author: $title $coverfile</p>";$i++;}
$body.= "<p>$i címnél hiányzik a borítófájl neve (lekérés: <em>$sql</em>)</p>";

print adminPage($body);


?>
