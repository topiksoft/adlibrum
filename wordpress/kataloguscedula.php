<?php


try{
$db= new PDO('sqlite:books/books.db');
	}catch( PDOException $exception ){
		die($exception->getMessage());
	}

if (isset($_GET['id'])) {$id=$_GET['id'];} else {print "Nincs ilyen katalóguscédula.";}

$res=$db->query("select * from books where (idbook=$id and (status==2 or status==3 or status==5))")
	or die ("Nem sikerült a lekérdezés! Az sql a következő volt: <i>$sql</i>");
$r=$res->fetch();


#változók
if ($r['coverfile']) {$cover="http://adlibrum.hu/docs/webcovers/".$r['coverfile'];}
else {$cover="../pics/no_picture.png";}
$id=$r['idbook'];
$title=$r['title'];
$title=str_replace('`',"'",$title);
$author=$r['author'];
$pages=$r['pages'];
$format=$r['format'];
$isbn=$r['isbn'];
$blurb=$r['blurb'];
$extrainfo=str_replace('\\"',"'",$r['extrainfo']);
$fulltitle="$author: $title";
$blurb=str_replace("\n","<br />",$blurb);
$pubyear=($r['pubyear']+2007);
switch ($r['publisher']) {
case 1: $publisher="Budapest, $pubyear."; break;
case 2: $publisher="Ad Librum, $pubyear."; break;
case 4: $publisher="StormingBrain, $pubyear."; break;
case 3: $publisher=$r['publishing'].", $pubyear."; break;
}
$price=$r['price']." Ft";
#súly és rövid leírás
if ($r['weight']) {$weight=$r['weight']; $weighttext="$weight gr.";} else {$weight="";}#ha nincs megadva a súly, számol egy egységértéket
if ($r['abstractshort']) {$abstractshort="[".$r['abstractshort']."]";} else {$abstractshort="";}
#újdonság és megjelenés előtt
//if ($r['status']==2) {$beforepublication="<em>Hamarosan megjelenik: ".$r['datepuby'].".".$r['datepubm'].".".$r['datepubd']."</em>";}
if ($r['status']==3 and (($r['datepuby']=="2016" and $r['datepubm']>=1))) {$beforepublication="<em>ÚJDONSÁG</em>";}


if ($r['status']==2) {
	$shop="<em>Hamarosan megjelenik!</em>";
	if ($r['link_webshop']) {$shop.=" Előrendelés: <a class='btn btn-success' target='_blank' href='".$r['link_webshop']."' title='Megvásárolható a Könyvesbolt.Online webboltban'>Könyvesbolt.Online</a>";}
}
if ($r['status']==3) {
	if ($r['link_webshop']) {$shop="Megvásárolható: <a class='btn btn-success' target='_blank' href='".$r['link_webshop']."' title='Megvásárolható a Könyvesbolt.Online webboltban'>Könyvesbolt.Online</a>";}
	else {$shop="<em>Jelenleg nem kapható</em>";}
}
if ($r['status']==5) {
	$shop="<em>Már nem kapható</em>";
}


#könyvadatok megjelenítése
//$beforepublication

print "
<p style='text-align:center'><img title='$author: $title' src='$cover' />
<strong>$publisher</strong></p>

<p>$shop</p>

<h1>$fulltitle</h1>

<em>$blurb</em>

$extrainfo

<p>$pages oldal $format $weighttext $price<br />
ISBN $isbn</p>
";

unset($db);#sqlite3

?>
