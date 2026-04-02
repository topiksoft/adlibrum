<?php

require_once("catalogueFunctions.php");
$db=dbopen() or die ("Nem sikerült az adatbázis megnyitása.");

# ------------------------
# AZ INDEX.HTML GENERÁLÁSA
# ------------------------

# FEJLÉC & BEVEZETŐ STATISZTIKA

# statisztika lekérése
$sql="select count(distinct title) as titles,count(distinct author) as authors from books where ((status=3 or status=5) and sponsor<6)"; //kiadott nyomtatott könyvek és különböző nevű szerzőik száma (forgalmazott és lezárt kiadások is)
$r = $db->query($sql)->fetch();

# Facebook metaadatok
$og = "<meta property='og:type' content='website' />";
$og .= "<meta property='og:title' content='Ad Librum könyvek' />";
$og .= "<meta property='og:url' content='https://adlibrum.hu/katalogus/kereso.html' />";
$og .= "<meta property='og:description' content='Az Ad Librum, Személyes Történelem, Expert Books és Storming Brain kiadók 2008 óta megjelent ".$r['titles']." könyvének katalógusa.' />";
$og .= "<meta property='og:image' content='https://adlibrum.hu/katalogus/I_am_writer__Fotolia_96517918_M.jpg' />";
$og .= "<meta property='og:locale' content='hu_HU' />";

# fejléc
$indexpage = catalogueHeader("Ad Librum kiadók könyveinek katalógusa",$og);
$indexpage .= callout();
//$indexpage .= "<h1>Az Ad Librum, Személyes Történelem, Expert Books és Storming Brain kiadók könyvei kereshető listában</h1>";

# bevezető mondat
$indexpage .= "
	<div class='grid'>
		<div class='col_9 visible'>
			<p>Ez az <strong>Ad Librum</strong> Kiadó, <strong>Személyes Történelem</strong> Kiadó, <strong>Expert Books</strong> Kiadó, <strong>Storming Brain</strong> Kiadó és a <strong>Könyv Guru</strong> által kiadott könyvek katalógusa. 
			Az Ad Librum Kft. kiadói 2008 óta összesen <strong>".$r['titles']." könyvet</strong> adtak ki <strong>".$r['authors']." szerzőtől</strong>.</p>
		</div>
		<div class='col_3 center'>
			<a class='button large pill orange' href='kereso.html' title='Keresés az összes megjelent könyv között szerző, cím vagy egyéb adat alapján'>KÖNYVKERESŐ</a>
		</div>
	</div>
	";

# KIEMELT KÖNYVEK

$sql="select author,title,coverfile,publisher,bookPublishers.name as publishername,publishing,pubyear,pubdate,bookCategories.name as category,catalogueurl
	from books,bookPublishers,bookCategories
	where (books.publisher=bookPublishers.id and books.category1=bookCategories.id and status=3 and sponsor<6 and onlineshopwindow=2) 
	order by pubdate desc 
	limit 4";
$featured = "
		<div class='grid'>
		<div class='col_12'>
		"; //nincs címsor
foreach ($db->query($sql) as $r)
{
	extract($r);
	$title=str_replace('`',"'",$title);
	if ($publisher==3) {$publishername=$publishing;} //egyéb kiadó
	$publisher= "$publishername, $pubyear.";
	//$htmlname = catalogueHtmlname($coverfile);
	if ($coverfile) {$coverfile=str_replace("FD.jpg","FE.jpg",$coverfile); $cover="https://adlibrum.hu/docs/webcovers/$coverfile";}
		else {$cover="no_picture.png";}
	$featured .= "
		<div class='col_3'>
			<a href='$catalogueurl.html'><img title='$author: $title' src='$cover' /><br/>
				$author: $title.</a> $publisher
		</div>"; //korábban megjelent a [$category] is
}
$featured .= "</div></div>";

$indexpage .= $featured;

# LEGFRISSEBBEK

$sql="select author,title,coverfile,publisher,bookPublishers.name as publishername,publishing,pubyear,pubdate,bookCategories.name as category,catalogueurl,abstractshort
	from books,bookPublishers,bookCategories
	where (books.publisher=bookPublishers.id and books.category1=bookCategories.id and status=3 and sponsor<6 and onlineshop=2) 
	order by pubdate desc 
	limit 24";
$latest = ""; $col=1;
foreach ($db->query($sql) as $r)
	{
	extract($r);
	$title=str_replace('`',"'",$title);
	if ($publisher==3) {$publishername=$publishing;} //egyéb kiadó
	$publisher= "$publishername, $pubyear.";
	if ($coverfile) {$coverfile=str_replace("FD.jpg","FF.jpg",$coverfile); $cover="https://adlibrum.hu/docs/webcovers/$coverfile";}
		else {$cover="no_picture.png";}
	//~ $latest .= "<div  class='col_9'><p><img class='align-left' title='$author: $title' src='$cover' /><a href='$htmlname.html'>$author: $title. $publisher [$category]</p></div>";
	$latest .= "<td width='50%'>
					<img class='align-left' title='$author: $title' src='$cover' />
					<a href='$catalogueurl.html'>$author: $title. $publisher</a>
					<br /> $abstractshort
					</td>";
	if ($col==1) {$latest = "<tr>$latest"; $col=2;} else {$latest .= "</tr>"; $col=1;} // 2 oszlop létrehozása táblázatban
	}
$latest .= "</div>";

$indexpage .= "
	<div class='grid'>
		<div class='col_9'>
			<h2>Legújabb megjelenések</h2>
			<table>
				$latest
			</table>
		</div>"
		.sidemenu().
	"</div>";

$indexpage .= catalogueFooter();

file_put_contents("../katalogus/index.html",$indexpage);

print adminPage("<p><a href='../katalogus/index.html'>Az index.html elkészült.</a></p>");

?>
