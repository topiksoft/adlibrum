<?php

require_once("catalogueFunctions.php");
print "<h1>Adatbázis megnyitása</h1>";
// $conn = mysql_connect("93.104.209.180", root, truzliop) or die('Error connecting to mysql: '.mysql_error());
$db=dbopen() or die ("Nem sikerült az adatbázis megnyitása.");

# -------------------------
# AZ EGYES LAPOK GENERÁLÁSA
# -------------------------

$body=""; //az admin lapra kiírandók

$updated="cron"; //alapesetben automatikusan futó frissítés

if (isset($_GET['updated'])) {$updated=$_GET['updated'];} else {$updated="cron";}

if (isset($_GET['idbook'])) {$where="and idbook='".$_GET['idbook']."'";$updated="";} //meghatározott katalóguslap frissítése
	else {$where="and (status=2 or status=3 or status=5) and onlineshop=2 and sponsor<6 and updated=1";}

if ($updated=="all") {$db->exec("update books set updated=1");} //minden katalóguslap frissítése, különben csak azok, amelyeknél az updated 1-re van állítva


//$sql="select * from books,bookPublishers where books.publisher=bookPublishers.id and status=3 and sponsor<6 and onlineshopwindow=2";
//~ $sql="select * from books,bookPublishers where books.publisher=bookPublishers.id and status=3 and sponsor<6 and pubyear=2017";
//~ $sql="select * from books,bookPublishers where books.publisher=bookPublishers.id";
$sql="select * from books,bookPublishers 
	where (books.publisher=bookPublishers.id and onlineshop=2 $where) ";

$i=0; //számláló a változásokra

foreach ($db->query($sql) as $r) {
	extract($r);
	
	if ($coverfile) {$cover="https://adlibrum.hu/docs/webcovers/$coverfile";}
		else {$cover="includes/no_picture.png";}
	$title=str_replace('`',"'",$title);
	$extrainfo=str_replace('\\"',"'",$extrainfo);
	$fulltitle="$author: $title";
	$blurb=str_replace("\n","<br />",$blurb);
	$extrainfo=str_replace('\\"',"'",$extrainfo);
	if ($publisher==3) {$name=$publishing;} //egyéb kiadó
	$publisher= "$name, $pubyear.";
	if ($price>0) {$price="$price Ft";} else {$price="";}
	if ($weight) {$weighttext="$weight gr.";} else {$weighttext="";}
	if ($abstractshort) {$abstractshort=$abstractshort;} else {$abstractshort="";}

	
	//$htmlname = catalogueHtmlname($coverfile);
	//$htmlname = $catalogueurl;
	
	# Facebook metaadatok
	$og = "<meta property='og:type' content='article' />";
	$og .= "<meta property='og:title' content='$author: $title' />";
	$og .= "<meta property='og:url' content='https://adlibrum.hu/katalogus/$catalogueurl.html' />";
	$og .= "<meta property='og:description' content='$blurb' />";
	$og .= "<meta property='og:image' content='$cover' />";
	$og .= "<meta property='og:locale' content='hu_HU' />";

	# stíluslap (nem kell külső css)
	$head = $og.
		"<style>
			.button_square {background:IndianRed; padding:10px; color:white; font-size:14px; text-decoration:none; vertical-align:middle;}
			.button_square:hover {border-top-color: #28597a;background: #28597a;color: #ccc;}
			.button_square:active {border-top-color: #1b435e;background: #1b435e;}
			.evenrow{background:#EEDCF5;color:black;padding: 10px}
			.oddrow{background:#F5E2DC;color:black;padding: 10px}
		</style>
		";
	
	# lap generálása
	$htmlpage = catalogueHeader($title,$head);
	$htmlpage .= callout();

	// Beleolvasási linkek
	$read="";
	if ($link_googlebooks) {$read.="<a target='_blank' class='button_square' style='background:IndianRed' href='$link_googlebooks'>Google Books</a>";}
	if ($link_izelito) {$read.="<a target='_blank' class='button_square' style='background:LimeGreen' href='$link_izelito'>Könyv Guru Ízelítő</a>";}
	if (strlen($read)>0) {$read="Olvasson bele! ".$read;}
	if ($link_moly) {$read.=" Vélemények: <a target='_blank' class='button_square' style='background:DarkViolet' href='$link_moly'>Moly</a>";}

	// Vásárlási linkek a kiadása státusza szerint
	if ($status==2) { //megjelenés alatt
		$shop="<span style='color:orange; font-weight:bold; font-style:italic;'>Hamarosan megjelenik!</span>";
		if ($link_webshop) {$shop.=" Előrendelés: <a class='button_square' style='background:Orange' href='$link_webshop' title='Megvásárolható a Könyvesbolt.Online webboltban'>Könyvesbolt.Online</a>";}
	}
	if ($status==3) { //megjelent
		$shop=""; // nyomtatott kiadás terjesztése
		if ($link_webshop) {$shop.="<a class='button_square' style='background:Orange' href='$link_webshop' title='Megvásárolható a Könyvesbolt.Online webboltban'>Könyvesbolt.Online</a>";}
		if ($link_bookline) {$shop.="<a class='button_square' style='background:Blue' href='$link_bookline'>Bookline</a>";}
		if ($link_libri) {$shop.="<a class='button_square' style='background:Green' href='$link_libri'>Libri</a>";}
		if ($link_lira) {$shop.="<a class='button_square' style='background:Red' href='$link_lira'>Líra</a>";}
		if ($link_alexandra) {$shop.="<a class='button_square' style='background:Pink' href='$link_alexandra'>Alexandra</a>";}
		if ($link_book24) {$shop.="<a class='button_square' style='background:Peru' href='$link_book24'>Book24</a>";}
		if ($link_emag) {$shop.="<a class='button_square' style='background:Khaki' href='$link_emag'>eMAG</a>";}
		if (strlen($shop)>0) {$shop="Megvásárolható: ".$shop;} else {$shop="<em>Jelenleg nem kapható</em>";}
		$ebook=""; //ebook kiadás
		if ($link_ekonyv) {$ebook.="<a class='button_square' style='background:purple' href='$link_ekonyv' target='_blank' >eKönyv.hu</a>";}
		if ($link_googleplay) {$ebook.="<a class='button_square' style='background:darkblue' href='$link_googleplay' target='_blank' >Google Play (Android)</a>";}
		if ($link_ibook) {$ebook.="<a class='button_square' style='background:darkgreen' href='$link_ibook' target='_blank' >iTunes (iPhone)</a>";}
		if (strlen($ebook)>0) {$ebook="Ebook: ".$ebook;}
	}
	if ($status==5) { //lezárt
		$shop="<strong><em>Már nem kapható</em></strong>";
	}

#	$htmlpage .= "<div class='fb-share-button' data-href='https://adlibrum.hu/katalogus/$catalogueurl.html' data-layout='button_count' data-mobile-iframe='true'><a class='fb-xfbml-parse-ignore' target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fadlibrum.hu%2Fkatalogus%2F$catalogueurl.html&amp;src=sdkpreparse'>Megosztás</a></div>";
	$htmlpage .= "
		<div class='grid'>
			<div>
				<div class='col_3' style='margin-top:20px;'><img class='align-left' title='$author: $title - Borító' src='$cover' /></div>
				<div class='col_9' style='margin-top:20px;'>
					<p style='color:#538b01; font-weight:bold;'>$abstractshort</p>
					<p><strong>$publisher</strong></p>
					<p>$pages oldal $format $weighttext $price ISBN $isbn</p>
					<p style='padding:4px;'>$shop</p>
					<p style='padding:4px;'>$ebook</p>
					<h1>$fulltitle</h1>
					<em>$blurb</em>
					<p>$extrainfo</p>
					<p style='padding:4px;'>$read</p>
				</div>
			</div>";
				//~ sidemenu(). //ha ez alkalmazott, a fenti div col_6
	
	# Kapcsolódó tartalmak
	$related="";
	$sql="select category as relatedcategory,label as relatedlabel,title as relatedtitle,description as relateddescription,link as relatedlink, image as relatedimage from bookRelated where bookid=$idbook order by weight desc";
	$relarray=$db->query($sql);
	//if (! empty($relarray)) {
		foreach ($relarray as $rel)
			{
				extract($rel);
				if ($relatedtitle) {
					$related.="<div>";
						$related.="<div class='col_3'>";
							if ($relatedimage) {$related.="<img src='$relatedimage' />";}
						$related.="</div>";
						$related.="<div class='col_9 evenrow'>";
							$related.="<h3>$relatedtitle</h3>";
							$related.="<p>$relateddescription";
							if ($relatedlink) {$related.=" <a href='$relatedlink' target='_blank'>BŐVEBBEN</a>";}
							$related.="</p>";
						$related.="</div>";
					$related.="</div><hr class='alt2' />\n";
				}
			}
		if ($related) {$related="<div><h2>Kapcsolódó tartalom</h2>\n".$related."</div>\n";}
	//}
	
	
	$htmlpage .= $related;
	
	$htmlpage .= "</div> <!-- End Grid -->\n";
	
	//$htmlpage .= "</body></html>";
	$htmlpage .= catalogueFooter();
	
	//~ file_put_contents("/home/gondolat/domains/adlibrum.hu/public_html/katalogus/$catalogueurl.html",$htmlpage);
	file_put_contents("../katalogus/$catalogueurl.html",$htmlpage);
	
	$i++;

	if ($updated="cron") {$body = "$catalogueurl.html létrejött\n";}
		else {$body .= "<p><a href='../katalogus/$catalogueurl.html'>$catalogueurl.html</a> létrejött</p>";}
}

if ($updated=="cron") {$body.= "$i lap generálva a $sql lekérés alapján.\n"; print $body;}
else {$body.= "<hr/><p>$i lap generálva a <em>$sql</em> lekérés alapján.</p>"; print adminPage($body);}

if ($updated=="modified" or $updated=="cron") {$db->exec("update books set updated=0");} // a most generált könyvlapok jelölőjének nullázása

?>
