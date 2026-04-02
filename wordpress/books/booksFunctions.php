<?php 

function sqlquery($db,$sql) {
	$result=$db->query($sql)
		or die ("<br/>Nem sikerült a lekérdezés! Az sql a következő volt:<br/><i>$sql</i>");
	return $result;
	}

function bookParameters($cat,$selected=0) {
	# választható elemek
	$p['status']=array("- -","Tervezett","Kiadás alatt","Kiadott","Meghiúsult","Lezárva","Antikvár","Viszonteladás","Más áru (nem könyv)");
	$p['sponsor']=array("- -","Szerzői (előfinanszírozott) kiadás",
		"Ingyenes (utófinanszírozott) kiadás","Saját (kiadói) kockázatú kiadás",
		"Egyéb (magyarázat a megjegyzéseknél)","POD (részben előfinanszírozott) kiadás",
		"Digitális kiadás");
	$p['series']=array("- -","Régi Utazások","Doktori Disszertációk",
		"Fiatal Kutatók","Speculum Hungariae","Politikatörténet");
	$p['publisher']=array("- -","Szerzői kiadás","Ad Librum Kiadó","Egyéb kiadás","StormingBrain","Expert Books","Személyes Történelem");
	$p['format']=array("- -","A5","B5","A4");
	$p['pubyear']=array("- -","2008","2009","2010","2011","2012","2013","2014","2015","2016","2017");
	$p['months']=array("- -","január","február","március","április","május","június",
		"július","augusztus","szeptember","október","november","december");
	$p['days']=range(1,31);
	array_unshift($p['days'],"- -");
	$p['contracttype']=array("- -","Havi","Negyedévi","Félév+negyedév","Elővásárlás+félévi","Letét+félévi");
	$p['status_contract']=array("- -","Tárgyalás alatt","Kipostázva",
		"Megkötve","Meghiúsult, szerződés bontva");
	$p['status_copyediting']=array("- -","Nem igényel korrektúrát",
		"Végleges kéziratra várva","Korrektúrán","Korrektúrázva");
	$p['status_dtp']=array("- -","Végleges kéziratra várva",
 		"Tördelési előkészítésen","Tördelésen","Szerzői korrektúrán","Javítások visszavezetése",
 		"Újabb korrektúrafordulón","Végleges tördelés",
 		"Szerző által benyújtandó tördelés","Szerző által benyújtott tördelés");
	$p['status_cover']=array("- -","Borítóadatokra várva",
 		"Borítóterv megrendelve","Borítóterv véleményezésen","Végleges borítóterv");
	$p['status_printing']=array("- -","Nyomdai anyag előkészítése","Árajánlat beszerzése",
		"Nyomdai munkák megrendelve","Nyomdában","Kinyomtatva, leszállítva");
	$p['status_billing']=array("- -","Nincs számlázás","Előlegszámla szerzőnek",
		"Előlegszámla kifizetve","Végszámla kiküldve","Végszámla kifizetve");
	$p['inventorytypes']=array("- -","Eladás kiadóból","Eladás viszonteladónak",
		"Szerzőnek a saját példányai","Szállítás viszonteladónak","Visszáru",
		"Beszállítás nyomdából","Kötelespéldány","Tiszteletpéldány/Ajándék","Külső raktárba átszállítás ","Külső raktárból beszállítás",
		"Beszállítás bizományosi kezelésbe","Átvezetés kiadói tulajdonba","Bérraktárba átszállítás","Bérraktárból visszaszállítás",
		"Ismeretlen hely","Megtaláltuk");
	$p['paid']=array("Nem igényel befizetést","Fizetést várunk","Kifizetve");
	$p['shippingtype']=array("Személyes átvétel","Postai csomag","Postai levél","Utánvételes","Szállító");
	$p['reported']=array("Igen","Nem");
	$p['invoiced']=array("Nem igényel számlázást","Számlával","Számla nélkül");
	$p['wholesaler']=array("- -","Fok-ta Bt.","Líra Rt.","Egyéb");
	$p['costtypes']=array("- -","Egyéb költség","Nyomdaköltség","Tördelési költség","Borítóköltség","Postaköltség","Korrektúra","Jogdíjkifizetés",
		"Szerzői befizetés","Eladásból bevétel","Egyéb bevétel");
	$p['costpaid']=array("- -","Fizetendő","Fizetett","Belső költség");
	$p['categories']=array("NINCS MEGADOTT KATEGÓRIA","Szépirodalom/Dráma","Szépirodalom/Vers","Szépirodalom/Novella","Szépirodalom/Regény","Szépirodalom/Antológia","Szépirodalom/Útleírás",
		"- -","Szórakoztató irodalom/Történelmi","Szórakoztató irodalom/Politikai krimi","Szórakoztató irodalom/Krimi",
		"Szórakoztató irodalom/Kalandregény","Szórakoztató irodalom/Romantika,párkapcsolatok",
		"Szórakoztató irodalom/Sci-fi,fantasy","Szórakoztató irodalom/Vámpír,horror","Szórakoztató irodalom/Utazás","Szórakoztató irodalom/Mese,ifjúsági",
		"Szórakoztató irodalom/Család","Szórakoztató irodalom/Emlékirat","Szórakoztató irodalom/Blog","Szórakoztató irodalom/Humor",
		"Szórakoztató irodalom/Bölcsességek","Szórakoztató irodalom/Vallás,ezotéria","Szórakoztató irodalom/Képregény,manga","Szórakoztató irodalom/Egyéb",
		"- -","Ismeretterjesztő/Életvezetési tanácsok","Ismeretterjesztő/Elmélkedések","Ismeretterjesztő/Vallás,ezotéria",
		"Ismeretterjesztő/Szakácskönyv","Ismeretterjesztő/Egészség,életmód","Ismeretterjesztő/Egyéb",
		"- -","Szakkönyv/Informatika","Szakkönyv/Üzlet","Szakkönyv/Nyelvészet,nyelvoktatás","Szakkönyv/Pszichológia","Szakkönyv/Szociológia,szociográfia,néprajz",
		"Szakkönyv/Jog, kriminológia","Szakkönyv/Történelem","Szakkönyv/Politológia,közigazgatás","Szakkönyv/Irodalom- és művészettörténet",
		"Szakkönyv/Filozófia","Szakkönyv/Egyéb","Szakkönyv/Könyvkiadás",
		"Egyéb termék (nem könyv)");
	$p['onlineshop']=array("Nincs katalóguslap","Megjelenik a katalóguslap");
	$p['onlineshopwindow']=array("Nem kiemelt","Boltban kiemelt","Kategóriában kiemelt","Ingyenes postázás");
	$p['language']=array("magyar","angol","német","egyéb");
	$p['distribution']=array("Teljes","Csak kiadói terjesztés","Nem terjesztjük");
	if ($selected!=0) {return $p[$cat][$selected];} else {return $p[$cat];}
}

function timesincepublication($datepuby,$datepubm) {
	global $datem;
	if ($datepuby==2008) {$months=12-$datepubm+96+$datem-1;}
	if ($datepuby==2009) {$months=12-$datepubm+84+$datem-1;}
	if ($datepuby==2010) {$months=12-$datepubm+72+$datem-1;}
	if ($datepuby==2011) {$months=12-$datepubm+60+$datem-1;}
	if ($datepuby==2012) {$months=12-$datepubm+48+$datem-1;}
	if ($datepuby==2013) {$months=12-$datepubm+36+$datem-1;}
	if ($datepuby==2014) {$months=12-$datepubm+24+$datem-1;}
	if ($datepuby==2015) {$months=12-$datepubm+12+$datem-1;}
	if ($datepuby==2016) {$months=12-$datepubm+$datem-1;}
	if ($datepuby==2017) {$months=$datem-$datepubm-1;}
	return $months;
	}

function menu() {
	//$_GET['q']=11; #állandó főnöki mód
	$fajlnev=$_SERVER['PHP_SELF'];
	if ($_GET['q']) {$q=$_GET['q'];} else {$q="";}
	if ($q==11) {$qq="
		<td align='center'><a href='$fajlnev?feladat=31&q=11' title='Kiadási költség és eredmény'>Költségek</a>
		<br/><a href='$fajlnev?feladat=statReportCircularLetter&q=11' title='Szerzőknek havi fogyási jelentés küldése'>Körlevél</a>
<br/>
		<a href='$fajlnev?feladat=11&q=11' title='Könyvek listázása'>Listázás</a></td>
		";
		$q="&q=11";
		} else {$qq="";$q="";}
		print "
		<table align='center' bgcolor='orange' cellspacing='8'>
		<tr>
		<td align='left'>
			Keresések<br/>
			<form action='$fajlnev' method='get'>
				<input type='hidden' name='feladat' value='11'/>
				<input type='text' name='query' size='20' />
				<input type='submit' value='KÖNYVEK' />
			</form>
			<form action='$fajlnev' method='get'>
				<input type='hidden' name='feladat' value='21'/>
				<input type='hidden' name='inv' value='s'/>
				<input type='text' name='query' size='20' />
				<input type='submit' value='LELTÁRBAN' />
			</form>
		</td>
		<td align='center'>
			<A href='$fajlnev?feladat=12' TITLE='Hozzáadás'>Új könyv hozzáadása</A>
			<br/>
			<form action='$fajlnev' method='get' >
				<input type='hidden' name='feladat' value='11' />
				<select name='listing'>
					<option/>Fordított időrendben
					<option selected/>Hozzáadás időrendje szerint
					<option/>Szerző szerint<option/>Cím szerint
					<option/>Sorozat szerint<option/>Formátum szerint
					<option/>- - -<option/>Státusz szerint<option/>Tervezett
					<option/>Kiadás alatt<option/>Kiadott<option/>Meghiúsult</select>
				<input type='submit' value='Listázás' />
			</form>
			<a href='$fajlnev?feladat=bookListCategories$q' title='Kategóriák szerint listázás'>Kategóriák</a> 
			<a href='$fajlnev?feladat=bookAddfromold$q' title='Új könyvtétel egy régiből'>Duplikálás</a><br/>
		</td>	
		<td align='center'>
			Leltár<br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2009$q' title='Leltári összesítés'>Leltár 2009</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2010$q' title='Leltári összesítés'>Leltár 2010</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2011$q' title='Leltári összesítés'>Leltár 2011</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2012$q' title='Leltári összesítés'>Leltár 2012</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2013$q' title='Leltári összesítés'>Leltár 2013</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2014$q' title='Leltári összesítés'>Leltár 2014</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2015$q' title='Leltári összesítés'>Leltár 2015</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2016$q' title='Leltári összesítés'>Leltár 2016</a><br/>
			<a href='$fajlnev?feladat=inventoryTotal&ev=2017$q' title='Leltári összesítés'>Leltár 2017</a><br/>
			<a href='$fajlnev?feladat=21&inventory=$q' title='Könyvmozgások felvitele'>Tételek</a><br/>
			&nbsp;
		</td>
		<td align='center'>
			Munkaterv<br/>
			<a href='$fajlnev?feladat=17$q' title='Kiadási időrend'>Program</a><br/>
			<a href='$fajlnev?feladat=18$q' title='Tördelés állása'>Tördelés</a><br/>
			<a href='$fajlnev?feladat=19$q' title='Borítókészítés állása'>Borító</a>
		</td>
		<td align='center'>
			Elszámolások<br/>
			<a href='$fajlnev?feladat=51$q' title='POD és egyéb jogdíjas eladások'>Jogdíjas</a><br/>
			<a href='$fajlnev?feladat=52$q' title='Ingyenes kiadások egyenlege'>Ingyenes</a><br/>
			<a href='$fajlnev?feladat=53$q' title='Előfinanszírozott kiadás állása'>Bizományos</a>
			
		</td>
		$qq
		</tr>
		<tr><td align='center' colspan='4'><font size='-1' color='darkgreen'><b>$message</b></font></td></tr>
		</table>";
	}

function htmlHeader($title) {
	print "
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"hu\" lang=\"hu\">
	<head>
		<title>$title</title>
		<link rel='shortcut icon' type='image/png' href='favicon.ico' />
		<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />
	</head>
	<body>";
}

function htmlFooter() {
	print "<p></p><hr><p align=\"center\"><font size=\"-1\">&#169; Soós Gábor/Ad Librum Kft. 2008-2017</font></p>";
	print "</BODY></HTML>";
}

function modNewBook($db) {
	# ÚJ könyv FELTÖLTÉSE
	# adatok átvétele
	$author="'".$_GET['author']."'";
	$title="'".$_GET['title']."'";
	$isbn="'".$_GET['isbn']."'";
	$publishing=$_GET['publishing'];
	$publisher="'".$_GET['publisher']."'";
	$pubyear="'".$_GET['pubyear']."'";
	$format="'".$_GET['format']."'";
	$pages="'".$_GET['pages']."'";
	$series="'".$_GET['series']."'";
	$source="'".$_GET['source']."'";
	$link_website="'".$_GET['link_website']."'";
	$link_webshop="'".$_GET['link_webshop']."'";
	$price="'".$_GET['price']."'";
	$comment="'".$_GET['comment']."'";
	$blurb="'".$_GET['blurb']."'";
	$status=$_GET['status'];

	switch ($publishing) {
	 case "Ad Librum Kiadó": $publishing="'1'"; $publisher="'Ad Librum Kiadó'"; break;
	 case "Szerzői kiadás": $publishing="'2'"; $publisher="'Szerzői kiadás'"; break;
	 case "Egyéb kiadás": $publishing="'3'"; break;
	}
	#switch ($format) {
	# case "A5": $format="'1'"; break;
	# case "B5": $format="'2'"; break;
	# case "A4": $format="'3'"; break;
	#}
	switch ($status) {
	 case "Tervezett": $status="'10'"; break;
	 case "Kiadás alatt": $status="'20'"; break;
	 case "Kiadott": $status="'30'"; break;
	 case "Meghiúsult": $status="'40'"; break;
	}
	# feltöltés
	$eredmeny=sqlite_query($db,
		"INSERT INTO book
			values ('',$author,$title,$isbn,$publishing,$publisher,$pubyear,$format,$pages,$series,
						$price,$source,$link_website,$blurb,$comment,datetime(),datetime(),$status,$link_webshop ) ")
		 or die ("Nem sikerült a feltöltés!");

	$uzenet=1;
}

function modBookData($db) {
	# könyv MÓDOSÍTÁS
	# adatok átvétele
	$idbook="'".$_GET['idbook']."'";
	$author="'".$_GET['author']."'";
	$title="'".$_GET['title']."'";
	$isbn="'".$_GET['isbn']."'";
	$publishing=$_GET['publishing'];
	$publisher="'".$_GET['publisher']."'";
	$pubyear="'".$_GET['pubyear']."'";
	$format="'".$_GET['format']."'";
	$pages="'".$_GET['pages']."'";
	$series="'".$_GET['series']."'";
	$source="'".$_GET['source']."'";
	$link_website="'".$_GET['link_website']."'";
	$link_webshop="'".$_GET['link_webshop']."'";
	$price="'".$_GET['price']."'";
	$comment="'".$_GET['comment']."'";
	$blurb="'".$_GET['blurb']."'";
	$status=$_GET['status'];

	switch ($publishing) {
	 case "Ad Librum Kiadó": $publishing="'1'"; $publisher="'Ad Librum Kiadó'"; break;
	 case "Szerzői kiadás": $publishing="'2'"; $publisher="'Szerzői kiadás'"; break;
	 case "Egyéb kiadás": $publishing="'3'"; break;
	}
	#switch ($format) {
	# case "A5": $format="'1'"; break;
	# case "B5": $format="'2'"; break;
	# case "A4": $format="'3'"; break;
	#}
	switch ($status) {
	 case "Tervezett": $status="'10'"; break;
	 case "Kiadás alatt": $status="'20'"; break;
	 case "Kiadott": $status="'30'"; break;
	 case "Meghiúsult": $status="'40'"; break;
	}
	# feltöltés
	$sql="UPDATE book SET author=$author,title=$title,isbn=$isbn,publishing=$publishing,publisher=$publisher,pubyear=$pubyear,series=$series,
				format=$format,pages=$pages,price=$price,source=$source,link=$link_website,link_webshop=$link_webshop,blurb=$blurb,comment=$comment,
				status=$status,date_modified=datetime()
			WHERE idbook=$idbook ";
	#print "$sql<br />";
	$eredmeny=sqlite_query($db,$sql)
		 or die ("Nem sikerült a módosítás!");
	$uzenet=2;
	}

function modEventAdd($db) {
	# ESEMÉNY HOZZÁADÁSA
	# adatok átvétele
	$newevent="'".$_GET['newevent']."'";
	$bookid="'".$_GET['idbook']."'";
	# feltöltés
	sqlite_query($db,"INSERT INTO event (bookid,event,date_created,date_modified) valueS ($bookid,$newevent,datetime(),datetime())")
		 or die ("Nem sikerült a feltöltés!");
	$uzenet=7;
	}

function modEvent($db) {
	# ESEMÉNY MÓDOSÍTÁSA
	# adatok átvétele
	$modevent="'".$_GET['modevent']."'";
	$idevent="'".$_GET['idevent']."'";
	//print "$idtag - $tagname <br/> ";
	# feltöltés
	sqlite_query($db,"UPDATE event SET event=$modevent,date_modified=datetime() WHERE idevent=$idevent")
		 or die ("Nem sikerült a módosítás!");
	$uzenet=8;
	}

function bookDTP($db) {
	if ($_GET['dtp']<>"") {
		$idbook=$_GET['idbook'];
#		$d=$_GET['dtp']+1;
#		$sql="update books set status_dtp=".$d." where idbook=".$idbook.";";
		if ($_GET['change']=='up') {
			$sql="update books set status_dtp=status_dtp+1 where idbook=".$idbook.";";
			}
		else
			{
			$sql="update books set status_dtp=status_dtp-1 where idbook=".$idbook.";";
			}
		sqlquery($db,$sql);
		}
	# LISTÁZÁS TERVEZETT KIADÁSI DÁTUM SZERINT
	$e=sqlquery($db,"select * from books where status=2 order by status_dtp");
	//$dtp=0;
	while ($s=$e->fetch() ) {
		if (!($dtp==$s['status_dtp'])) {
			$dtp=$s['status_dtp'];
			print "<h3>".bookParameters("status_dtp",$dtp)."</h3>";
		}
		$idbook=$s['idbook'];
		print "
		[<a href='$fajlnev?feladat=18&idbook=$idbook&change=up&dtp=".$dtp."' title='Egy fokozattal feljebb léptet'>+</a>]  
		<a href='$fajlnev?feladat=13&idbook=$idbook' title='Könyvadatok szerkesztése'>".$s['author'].": ".$s['title']."</a>
		[<a href='$fajlnev?feladat=18&idbook=$idbook&change=down&dtp=".$dtp."' title='Egy fokozattal visszaléptet'>-</a>]<br/>";
		//$d=$dtp+1;$sql="update books set status_dtp=".$d." where idbook=".$idbook.";";
		//if ($dtp>1) {print $sql;sqlquery($db,$sql);}
	}
}

function bookCover($db) {
	if ($_GET['cover']<>"") {
		$idbook=$_GET['idbook'];
		if ($_GET['change']=='up') {
			$sql="update books set status_cover=status_cover+1 where idbook=".$idbook.";";
			}
		else
			{
			$sql="update books set status_cover=status_cover-1 where idbook=".$idbook.";";
			}
		sqlquery($db,$sql);
		}
	# LISTÁZÁS A BORÍTÓKÉSZÍTÉS STÁDIUMA SZERINT
	$e=sqlquery($db,"select * from books where status=2 order by status_cover");
	//$dtp=0;
	while ($s=$e->fetch() ) {
		if (!($cover==$s['status_cover'])) { # csak új esetén írja ki a készültségi kategóriát
			$cover=$s['status_cover'];
			print "<h3>".bookParameters("status_cover",$cover)."</h3>";
		}
		$idbook=$s['idbook'];
		print "
		[<a href='$fajlnev?feladat=19&idbook=$idbook&change=up&cover=".$cover."' title='Egy fokozattal feljebb léptet'>+</a>]  
		<a href='$fajlnev?feladat=13&idbook=$idbook' title='Könyvadatok szerkesztése'>".$s['author'].": ".$s['title']."</a> 
		[<a href='$fajlnev?feladat=19&idbook=$idbook&change=down&cover=".$cover."' title='Egy fokozattal visszaléptet'>-</a>]<br/>";
		//$d=$dtp+1;$sql="update books set status_dtp=".$d." where idbook=".$idbook.";";
		//if ($dtp>1) {print $sql;sqlquery($db,$sql);}
	}
}

function bookProgram($db) {
	# LISTÁZÁS TERVEZETT KIADÁSI DÁTUM SZERINT
	$e=sqlquery($db,"select * from books where status=2 order by datepuby,datepubm,datepubd");
	while ($s=$e->fetch() ) {
		if (!($y==$s['datepuby'] && $m==$s['datepubm'] && $d==$s['datepubd'])) {
			$y=$s['datepuby'];$m=$s['datepubm'];$d=$s['datepubd'];
			print "<h3>".$y." ".bookParameters("months",$m)." ".$d.".</h3>";
		}
		$idbook=$s['idbook'];
		print "<a href='$fajlnev?feladat=13&idbook=$idbook' title='Könyvadatok szerkesztése'>".$s['author'].": ".$s['title']."</a><br/>";
	}
}

function bookList($db) {
	# KÖNYVEK LISTÁZÁSA
	//$_GET['q']=11; #állandó főnöki mód
	// keresés
	$query=$_GET['query'];
	if ($query=='') {
			// listázási utasítás
			$listing=$_GET['listing'];
			switch ($listing) {
				case "Hozzáadás időrendje szerint": $sqladd="ORDER BY idbook DESC"; break;
				case "Fordított időrendben": $sqladd="ORDER BY date_modified DESC "; break;
				case "Szerző szerint": $sqladd="ORDER BY author "; break;
				case "Cím szerint": $sqladd="ORDER BY title "; break;
				case "Sorozat szerint": $sqladd="ORDER BY series "; break;
				case "Formátum szerint": $sqladd="ORDER BY format "; break;
				case "Státusz szerint": $sqladd="ORDER BY status "; break;
				case "Tervezett": $sqladd="WHERE status=1"; break;
				case "Kiadás alatt": $sqladd="WHERE status=2"; break;
				case "Kiadott": $sqladd="WHERE status=3"; break;
				case "Meghiúsult": $sqladd="WHERE status=4"; break;
				default: $sqladd="ORDER BY datepuby DESC,datepubm DESC,datepubd DESC"; break;
			}
		}
		else {
		$sqladd="WHERE (
			(author LIKE '%$query%') 
			OR (title LIKE '%$query%') 
			OR (author_address LIKE '%$query%') 
			OR (author_email LIKE '%$query%') 
			OR (addedinfo LIKE '%$query%') 
			OR (comment LIKE '%$query%')
			OR (abstractshort LIKE '%$query%')
			) 
			ORDER BY title";
		}
/*
	$sql="SELECT idbook,author,title,date_created,date_modified,status,
		publisher,series,format,price,isbn,sponsor FROM books $sqladd ";
	$eredmeny=$db->query($sql)
		or die ("<br/>Nem sikerült a lekérdezés! Az sql a következő volt:<br/><i>$sql</i>");
*/
	$eredmeny=sqlquery($db,"SELECT * FROM books $sqladd ");
	// listázás
	//print "<table align=\"center\" CELLSPACING='5'>";
	//formTableHead(array("Sor-<br/>szám","Szerző & Cím","Könyvadatok"));
	$case[1]="";$case[2]="";$case[3]="";$case[4]="";
	$sorok_szama=0;$nr[1]=0;$nr[2]=0;$nr[3]=0;$nr[4]=0;
	while ($sor = $eredmeny->fetch() ) {
		$sorok_szama++;
		$idbook_formatted=sprintf("%03d",$sor['idbook']);
		$status=bookParameters("status",$sor['status']);
		$publisher=bookParameters("publisher",$sor['publisher']);
		if ($sor['series']>0)
			{$series='"'.bookParameters("series",$sor['series']).'",';}
			else {$series="";}
		$price=$sor['price']." Ft";
		$isbn=$sor["isbn"];
		#$format=bookParameters("format",$sor['format']);
		$format=$sor['format'];
		if ($sor['weight']) {$weight=$sor['weight']." gr.,";} else {$weight="<font color='red'>!</font> gr.";}
		/*
		#formátum egyszeri átalakítás
		if ($sor['format']==1) {$format="A5";}
		if ($sor['format']==2) {$format="B5";}
		if ($sor['format']==3) {$format="A4";}
		$sql="update books set format='$format' where idbook='$idbook'";
		sqlquery($db,$sql);
		*/
		# kiadási mód
		if ($sor['sponsor']=="") {$sor['sponsor']=0;}
		switch ($sor['sponsor']) {
			case 0: $sponsor="";break;
			case 1: $sponsor="- Előfinanszírozott"; break;
			case 2: $sponsor="- Utófinanszírozott"; break;
			case 3: $sponsor="- Ad Librum költségén"; break;
			case 4: $sponsor="- Egyéb finanszírozású"; break;
			case 5: $sponsor="- POD kiadás"; break;
			case 6: $sponsor="- Digitális kiadás"; $format="EBOOK"; break;
			}
		$idbook=$sor['idbook'];
		$author=$sor['author'];
		$title=$sor['title'];
		$pages=$sor['pages']." o.";
		$printrun=$sor['printrun']." pld.";
		$td1="<td><font size='-1'><a href='$fajlnev?feladat=26&idbook=$idbook' title='Leltár'>
			$idbook_formatted</a></font></td>";
		if ($_GET['q']==11) {$q="$fajlnev?feladat=13&idbook=$idbook&q=11";} else {$q="$fajlnev?feladat=13&idbook=$idbook";}
		$td2="<td><a href='$q' title='Könyvadatok megnézése és szerkesztése hozzáadása'>
					$author: <i>$title</i></a></td>";
		if ($sor['status_printing']==4)
				{$nyomda="<font color='brown'>NYOMDÁBAN! </font>";}
			else {$nyomda="";}
		if ($sor['status']==2 and ($sor['status_dtp']==7 or $sor['status_dtp']==9) )
				{$tordelt="<font color='darkblue'>T </font>";}
			else {$tordelt="";}
		if ($sor['status']==2 and $sor['status_cover']==4)
				{$keszborito="<font color='darkgreen'>B </font>";}
			else {$keszborito="";}
		if ($sor['onlineshop']>0) 
			{$onlineshop="<font color='brown'>S </font>";}
			else {$onlineshop="";}
		$addedinfo=$sor['addedinfo'];
		$pubdate=$sor['date_publication'];
		$td3="<td><font size='-1'>$onlineshop$nyomda$tordelt$keszborito$publisher, $series $format, $pages, $price, $printrun, $weight $isbn <em>$addedinfo</em> $pubdate</font>";
		if ($_GET['q']==11) {$td4="<a href='$fajlnev?feladat=32&idbook=$idbook&q=11' title='Költségek'> K</a></td>";}
			else {$td4="</td>";}
		$st=$sor['status'];
		if ($st==2 || $st==3 || $st==5 || $st==6 || $st==7 || $st==8) {
			$st=($sor['status']*10)+$sor['sponsor'];
			}
		#print $sor['idbook']." $st<br/>";
		$case[$st].="<tr>".$td1.$td2.$td3.$td4."</tr>";
		$nr[$st]++;
		$series="";
		#egyszeri átalakítás
		$pubdateymd=explode('-',$sor['date_publication']);
		if ($pubdateymd[0]=="Array") {$pubdateymd[0]="2008";}
		if ($pubdateymd[0]=="") {$pubdateymd[0]="2008";}
		if ($pubdateymd[1]=="") {$pubdateymd[1]="0";}
		$sql="update books set datepuby='".$pubdateymd[0]."', datepubm='"
			.$pubdateymd[1]."', datepubd='".$pubdateymd[2]."' where idbook='$idbook'";
sqlquery($db,$sql); #HA EZ NINCS LEKAPCSOLVA, NAGYON SOKAT SZÁMOL A MEGJELENÍTÉS ELŐTT
	#	sqlquery($db,"update books set date_publication='2008-0-0',datepuby='2008'
	#	where status=3 and pubyear='2008'");
	}
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - Saját finanszírozású kiadás</font></th><th>".$nr[23]." könyv</th></tr>".$case[23]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - Előfinanszírozott kiadás</font></th><th>".$nr[21]." könyv</th></tr>".$case[21]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - POD kiadás</font></th><th>".$nr[25]." könyv</th></tr>".$case[25]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - \"Ingyenes\" kiadás</font></th><th>".$nr[22]." könyv</th></tr>".$case[22]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - Egyéb finanszírozás</font></th><th>".$nr[24]." könyv</th></tr>".$case[24]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgreen' size='+2'>"
		.bookParameters("status",2)." - Digitális kiadás</font></th><th>".$nr[26]." könyv</th></tr>".$case[26]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - Digitális kiadás</font></th><th>".$nr[36]." könyv</th></tr>".$case[36]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - Saját finanszírozású kiadás</font></th><th>".$nr[33]." könyv</th></tr>".$case[33]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - Előfinanszírozott kiadás</font></th><th>".$nr[31]." könyv</th></tr>".$case[31]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - POD kiadás</font></th><th>".$nr[35]." könyv</th></tr>".$case[35]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - \"Ingyenes\" kiadás</font></th><th>".$nr[32]." könyv</th></tr>".$case[32]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",3)." - Egyéb finanszírozás (pl. bérmunka)</font></th><th>".$nr[34]." könyv</th></tr>".$case[34]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='deeppink' size='+2'>"
		.bookParameters("status",1)."</font></th><th>".$nr[1]." könyv</th></tr>".$case[1]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkgoldenrod' size='+2'>"
		.bookParameters("status",4)."</font></th><th>".$nr[4]." könyv</th></tr>".$case[4]."</table><hr/>";
	#print "<table cellspacing='5'><tr><th></th><th><font color='darkgoldenrod' size='+2'>"
	#	.bookParameters("status",5)."</font></th><th>".$nr[5]." könyv</th></tr>".$case[5]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - Digitális kiadás</font></th><th>".$nr[56]." könyv</th></tr>".$case[56]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - Saját finanszírozású kiadás</font></th><th>".$nr[53]." könyv</th></tr>".$case[53]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - Előfinanszírozott kiadás</font></th><th>".$nr[51]." könyv</th></tr>".$case[51]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - POD kiadás</font></th><th>".$nr[55]." könyv</th></tr>".$case[55]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - \"Ingyenes\" kiadás</font></th><th>".$nr[52]." könyv</th></tr>".$case[52]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darksalmon' size='+2'>"
		.bookParameters("status",5)." - Egyéb finanszírozás (pl. bérmunka)</font></th><th>".$nr[54]." könyv</th></tr>".$case[54]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='blue' size='+2'>"
		.bookParameters("status",6)."</font></th><th>".$nr[60]." könyv</th></tr>".$case[60]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='blue' size='+2'>"
		.bookParameters("status",7)."</font></th><th>".$nr[70]." könyv</th></tr>".$case[70]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='blue' size='+2'>"
		.bookParameters("status",8)."</font></th><th>".$nr[80]." árucikk</th></tr>".$case[80]."</table><hr/>";
	print "<table cellspacing='5'><tr><th></th><th><font color='darkred' size='+2'>"
		."És ez mi a fene?"."</font></th><th>".$nr[0]." könyv</th></tr>".$case[0]."</table><hr/>";
	# találatok száma
	//$sorok_szama=$eredmeny->rowCount();
	print "<p align='center'>A listázott összes könyv száma: $sorok_szama</p>";
	print "<a href='$fajlnev?feladat=111'>Rövid leírás listázása</a>";
}

function bookListFull($db) {
	$e=sqlquery($db,"SELECT * FROM books WHERE status=2 OR status=3 ORDER BY author");
	while ($s = $e->fetch() ) {
		$pubyear=($s['pubyear']+2007);
		switch ($s['publisher']) {
			case 1: $publisher="Budapest, $pubyear."; break;
			case 2: $publisher="Ad Librum, $pubyear."; break;
			case 3: $publisher=$s['publishing'].", $pubyear."; break;
		}
		$format=$s['format'];
		$sponsor=bookParameters("sponsor",$s['sponsor']);
		print $s['idbook'].". ".$s['author'].": ".$s['title'].". $publisher ISBN ".$s['isbn'].", $format, ".$s['pages']." o., ".$s['price'].
			" Ft<br/>";
	}
}

function bookAdd($db) {
	# ÚJ KÖNYV hozzáadása
	bookForm($db,0);
}


# # # # # # # # # # # # # # # # # # # #
# Űrlapelemek						  #
# formInput, formSelect, formDate	  #
# # # # # # # # # # # # # # # # # # # #

function formHidden($name,$value) {
	return "<input type='hidden' name='$name' value='$value' />";
}

function formSubmit($name) {
	return "<input type='submit' value='$name' />";
}

function formDate($default,$nr="") {
	# $default[0]: év, $default[1]: hónap, $default[2]: nap
	$years=bookParameters("pubyear");
	$months=bookParameters("months");
	$days=bookParameters("days");
	if (substr($default[1],0,1)=="0") {$default[1]=substr($default[1],1,1);}
	if (substr($default[2],0,1)=="0") {$default[2]=substr($default[2],1,1);}
	return formSelect($years,"year$nr",$default[0],1)
		.formSelect($months,"month$nr",$default[1])
		.formSelect($days,"day$nr",$default[2]);
	# settype($default[1],int)
}

function formSelect($options,$name,$default,$defaulttype=0) {
	# egy select elemet készít az $options tömbből, a $name az űrlapelem neve,
	# a $default a selected elem,
	# a $defaulttype jelöli, hogy a tömbelemelem számát (0) vagy értéket (1) tartalmaz-e
	$select="<select name=\"$name\">";
	if ($defaulttype==0) {$default=$options[$default];}
	$value=0;
	foreach ($options as $option) {
		if ($option==$default) {$sel="selected='selected'";} else {$sel="";}
		$select.="<option value='$value' $sel>$option</option>";
		$value++;
		}
	$select.="</select>";
	return $select;
}

function formInput($name,$value,$urlapszelesseg=50) {
	# argumentumok: $name: a name az inputban,
	# $value: űrlap alapérték, $urlapszelesseg: az input szélessége,
	return "<input type='text' name='$name' size='$urlapszelesseg' value='$value'/>";
}

function formTextarea($name,$value,$rows=5,$cols=50) {
	# argumentumok: $name: a name az inputban,
	# $value: űrlap alapérték, $urlapszelesseg: az input szélessége,
	return "<textarea name='$name' rows='$rows' cols='$cols'>$value</textarea>";
}

function formSelectOLD($caption,$cat,$selected) {
	# egy select elemet készít, a $caption a felirat, a $cat a paraméternév,
	# a $selected a default
	$bookparams=bookParameters();
	print "<td>$caption</td>td><td><select name=\"$cat\">";
	$value=0;
	$selected=$bookparams[$cat][$selected];
	foreach ($bookparams[$cat] as $options) {
		if ($options==$selected) {$sel="selected=selected";} else {$sel="";}
		print "<option value='0' $sel>$options</option>";
		}
	print "</select></td>";
}

function formTableRow($tr,$center=0) {
	if ($center==1) {$align="align='center'";} else {$align="align='left'";} 
	print "<tr $align>";
	foreach ($tr as $td) {
		print "<td>$td</td>";
	}
	print "</tr>";
}

function formTableHead($tr) {
	print "<tr>";
	foreach ($tr as $td) {
		print "<th>$td</th>";
	}
	print "</tr>";
}

function bookAddfromold($db) {
	print "<h1>Új könyv egy régiből</h1>
			<form action='$fajlnev' method='get' >
				<input type='hidden' name='feladat' value='bookForm' />
				<input type='input' name='idold' size='3' />
				<input type='submit' value='Új könyv az ezen számú régi adataiból' />
			</form>";
}

function bookForm($db,$idold=-1) {
	# előállítja a könyvfeltöltéshez és módosításhoz az űrlapot
	if ($idold==0) {
		# új könyv felvitele
		sqlquery($db,"insert into books (author,category1,category2,reported) values ('Új','0','0','1')");
		$r=sqlquery($db,"select idbook from books order by idbook desc");
		$s=$r->fetch();
		$idbook=$s[0];
		}
		else {$idbook=$_GET['idbook'];}
	if ($idold>0) {
		# új könyv egy régi adataiból
		print "#$idold duplikálása<br/>";
		# új könyvszám létrehozása
		sqlquery($db,"insert into books (author) values ('Új')");
		$r=sqlquery($db,"select idbook from books order by idbook desc");
		$s=$r->fetch();
		$idbook=$s[0];
		# feltöltés a régi adataival
		$v=sqlquery($db,"select * from books where idbook=$idold");
		$w=$v->fetch(SQLITE_ASSOC);
		foreach($w as $kulcs => $ertek) {
			#print "$kulcs: $ertek<br/>";
			if ($kulcs<>"queryString" and $kulcs<>"idbook") {
				$sql="update books set $kulcs='$ertek' where idbook=$idbook";
				#print "$sql<br/>";
				sqlquery($db,$sql);
				}
			}
		}
	if ($idold==-1) {$idbook=$_GET['idbook'];}
	# lekérdezés
	print "<p>Sorszám: $idbook</p>";
	$sql="SELECT * FROM books WHERE idbook='$idbook'";
	$eredmeny=$db->query($sql)
		or die ("<br/>Nem sikerült a lekérdezés! Az sql a következő volt:<br/><i>$sql</i>");
	$sor=$eredmeny->fetch();
	# űrlap
	$width=70; #input űrlapelem szélessége
	print "<BR />
		<form action='$fajlnev' method='post' >
		<table align='center' CELLSPACING='5'>";
		print formHidden("feladat",14);
		print formHidden("task",14);
		print formHidden("idbook",$idbook);
		formTableRow(array("",formSubmit("ADATOK RÖGZÍTÉSE")) );
		formTableRow(array("Megjegyzés","<textarea name='comment' cols='$width' ROWS='10'>".$sor['comment']."</textarea>"));
		formTableRow(array("","<b>TÖRZSADATOK</b>"));
		formTableRow(array("Szerző",formInput("author",$sor['author'],$width)));
		formTableRow(array("Cím",formInput("title",$sor['title'],$width)));
		formTableRow(array("Kiadó",formSelect(bookParameters("publisher"),"publisher",$sor['publisher']).
			formInput("publishing",$sor['publishing'],15) ) );
		formTableRow(array("Kiadás éve",formSelect(bookParameters("pubyear"),"pubyear",$sor['pubyear']) ) );
		#formTableRow(array("Formátum",formSelect(bookParameters("format"),"format",$sor['format']) ) );
		formTableRow(array("Formátum",formInput("format",$sor['format'],10) ) );
		formTableRow(array("Terjedelem",formInput("pages",$sor['pages'],3)." oldal") );
		formTableRow(array("Súly",formInput("weight",$sor['weight'],3)." gramm") );
		formTableRow(array("ISBN",formInput("isbn",$sor['isbn'],14)));
		formTableRow(array("Könyv teljes ára",formInput("price",$sor['price'],3) ) );
		formTableRow(array("Példányszám:",
			formInput("printrun",$sor['printrun'],4)." példány",
			"A kiadás teljes példányszáma"));
		formTableRow(array("Sorozat",formSelect(bookParameters("series"),"series",$sor['series'])));
		formTableRow(array("Nyelv",formSelect(bookParameters("language"),"language",$sor['language'])));
		formTableRow(array("Egyéb kiadási információ",formInput("addedinfo",$sor['addedinfo'],$width)));

		formTableRow(array("","<b>KIADÁS ADATAI</b>"));
		formTableRow(array("Finanszírozás:",formSelect(bookParameters("sponsor"),"sponsor",$sor['sponsor']) ) );
		formTableRow(array("Státusz:",formSelect(bookParameters("status"),"status",$sor['status'])  ) );
		if ($_GET['q']==11) {
			formTableRow(array("Kiadási megjegyzések","<textarea name='commentcontract' cols='$width' ROWS='2'>".
			$sor['commentcontract']."</textAREA>"));}

		formTableRow(array("","<b>LEÍRÁS</b>"));
		formTableRow(array("Rövid leírás","<textarea name='abstractshort' cols='$width' ROWS='2'>".$sor['abstractshort']."</textarea>") );
		formTableRow(array("Hátszöveg","<textarea name='blurb' cols='$width' ROWS='10'>".$sor['blurb']."</textarea>" ) );
		formTableRow(array("További információ","<textarea name='extrainfo' cols='$width' ROWS='10'>".$sor['extrainfo']."</textarea>"),
			"A webboltban megjelenő további információ (szerzői életrajz, részlet stb.) html formátumban.");

		formTableRow(array("","<b>KATEGÓRIA</b>"));
		formTableRow(array("Kategória 1",formSelect(bookParameters("categories"),"category1",$sor['category1']),"Feltétlenül megjelölendő") );
		formTableRow(array("Kategória 2",formSelect(bookParameters("categories"),"category2",$sor['category2']),"Nem kötelező választani") );

		formTableRow(array("","<b>KATALÓGUSLAP ÉS ONLINE BOLT</b>"));
		formTableRow(array("Katalóguslap",formSelect(bookParameters("onlineshop"),"onlineshop",$sor['onlineshop']),"A katalóguslap megjelenése az Ad Librum weboldalán.") );
		formTableRow(array("Borítókép",formInput("coverfile",$sor['coverfile'],40),"A fájl neve http://adlibrum.hu/docs/webcovers/ címen --FD.jpg végződéssel.") );
		formTableRow(array("Link: Könyvesbolt.Online",formInput("link_webshop",$sor['link_webshop'],$width,"A konyvesbolt.online terméklap teljes url-je")));
		//~ formTableRow(array("Webboltban kiemelt",formSelect(bookParameters("onlineshopwindow"),"onlineshopwindow",$sor['onlineshopwindow'])  ) );
		//~ formTableRow(array("Akciós ár",formInput("saleprice",$sor['saleprice'],3)." Ft","Az akciós ár. Üresen marad, ha nem akciózzuk a terméket.") );

		formTableRow(array("","<b>TERJESZTŐK</b>"));
		formTableRow(array("Terjesztés",formSelect(bookParameters("distribution"),"distribution",$sor['distribution']),"Terjesztés módja") );
		formTableRow(array("Könyv weboldala",formInput("link_website",$sor['link_website'],$width),"Nem teljes URL, csak a kategória neve (pl. \"Sary-Gyula\")" ));
		//~ formTableRow(array("Link: webbolt",formInput("link_webshop",$sor['link_webshop'],$width)),"Teljes URL (http://shop.adlibrum.hu/...)" );
		formTableRow(array("Link: Bookline",formInput("link_bookline",$sor['link_bookline'],$width)));
		formTableRow(array("Link: Líra",formInput("link_lira",$sor['link_lira'],$width),"fo.hu"));
		formTableRow(array("Link: Libri",formInput("link_libri",$sor['link_libri'],$width)));
		formTableRow(array("Link: Alexandra",formInput("link_alexandra",$sor['link_alexandra'],$width)) );
		formTableRow(array("Link: Google Books",formInput("link_googlebooks",$sor['link_googlebooks'],$width)));
		
		formTableRow(array("","<b>SZERZŐ</b>"));
		formTableRow(array("Jogtulaj elérhetősége",formInput("author_address",$sor['author_address'],$width-10)));
		formTableRow(array("Jogtulaj emailje",formInput("author_email",$sor['author_email'],$width-20)));

		formTableRow(array("","<b>JOGDÍJ</b>"));
		formTableRow(array("Jogdíj webboltos eladásnál:",
			formInput("royaltywebshop",$sor['royaltywebshop'],4)."%",
			"Jogdíj mértéke - POD-kiadásnál üresen marad"));
		formTableRow(array("Jogdíj viszonteladós eladásnál:",
			formInput("royaltyreseller",$sor['royaltyreseller'],4)."%",
			"Jogdíj mértéke"));
		formTableRow(array("Szerzői ár:",
			formInput("authorprice",$sor['authorprice'],4)."Ft",
			"POD-kiadásnál a minimálár"));
		formTableRow(array("Fogyási jelentés:",formSelect(array("nem","igen"),"reported",$sor['reported']),"Kell-e fogyási jelentést küldeni" ) );
		formTableRow(array("Számlatartozás:",formSelect(array("nem","igen"),"overdue",$sor['overdue']),"Van-e lejárt tartozása, amit a fogyási jelentésben jelezni akarunk?" ) );
		
		formTableRow(array("","<b>INGYENES KIADÁS</b>"));
		formTableRow(array("Szerződéstípus:",
			formSelect(bookParameters("contracttype"),"contracttype",$sor['contracttype']),
			"(1) Havi, (2) Negyedévi, (3) Félévi+negyedévi, (4) 30% elővásárlás + féléves, (5) letét + féléves"));
		formTableRow(array("Vállalt forgalom:",
			formInput("contracted",$sor['contracted'],4)." példány",
			"A szerző által vállalt forgalom"));
		/*
		if ($_GET['q']==11) { //főnökadat
			formTableRow(array("Nyomdaköltség:",
				formInput("printingcost",$sor['printingcost'],4)." Ft",
				"Példányonkénti nettó nyomdaköltség"));
			formTableRow(array("ÁFA:",
				formInput("vat",$sor['vat'],4)."%",
				"A nyomdai munka áfája (5% vagy 20%)"));
			}
		*/
		formTableRow(array("Elvárt forgalom: ",
			formInput("quarter",$sor['quarter'],4)." példány/negyedév",
			"A szerződésben vállalt negyedévi forgalom."));

		formTableRow(array("","<b>KIADÁS MENETRENDJE</b>"));
		formTableRow(array("Szerződés",
			formSelect(bookParameters("status_contract"),"status_contract",$sor['status_contract']) ) );
		formTableRow(array("Kéziratleadási dátum",formDate(explode("-",$sor['date_submission']),"1") ) );
		formTableRow(array("Korrektúra",formSelect(bookParameters("status_copyediting"),"status_copyediting",$sor['status_copyediting']) ) );
		formTableRow(array("Tördelés",formSelect(bookParameters("status_dtp"),"status_dtp",$sor['status_dtp']) ) );
		formTableRow(array("Borító",formSelect(bookParameters("status_cover"),"status_cover",$sor['status_cover']) ) );
		formTableRow(array("Nyomda",formSelect(bookParameters("status_printing"),"status_printing",$sor['status_printing']) ) );
		formTableRow(array("Számlázás",formSelect(bookParameters("status_billing"),"status_billing",$sor['status_billing']) ) );
		formTableRow(array("Kiadási dátum",formDate(explode("-",$sor['date_publication']),"2")) );
		
		formTableRow(array("","<b>DIGITÁLIS KÜLÖNNYOMAT</b>"));
		formTableRow(array("Borítókép törzsnév",formInput("imagename",$sor['imagename'],$width-20)) );
		formTableRow(array("Digitális különnyomat",formInput("extraname",$sor['extraname'],$width-10)) );

		print "</table></form>";
		
		bookDetails($db,$idbook);
	}

function bookMod($db) {
	# MÓDOSÍTÁS VÉGREHAJTÁSA
	# adatok átvétele
	$idbook=$_POST['idbook'];
	# feltöltés
	if (!empty($_POST['printingcost'])) {
		$printcost="printingcost='".$_POST['printingcost']."',vat='".$_POST['vat']."',";
		}
	$sql="update books set "
		.$printcost.
		"author='".$_POST['author']."',
		title='".$_POST['title']."',
		isbn='".$_POST['isbn']."',
		publisher='".$_POST['publisher']."',
		publishing='".$_POST['publishing']."',
		pubyear='".$_POST['pubyear']."',
		format='".$_POST['format']."',
		series='".$_POST['series']."',
		pages='".$_POST['pages']."',
		price='".$_POST['price']."',
		saleprice='".$_POST['saleprice']."',
		language='".$_POST['language']."',
		weight='".$_POST['weight']."',
		sponsor='".$_POST['sponsor']."',
		reported='".$_POST['reported']."',
		overdue='".$_POST['overdue']."',
		addedinfo='".$_POST['addedinfo']."',
		contracttype='".$_POST['contracttype']."',
		printrun='".$_POST['printrun']."',
		contracted='".$_POST['contracted']."',
		quarter='".$_POST['quarter']."',
		royaltywebshop='".$_POST['royaltywebshop']."',
		royaltyreseller='".$_POST['royaltyreseller']."',
		authorprice='".$_POST['authorprice']."',
		commentcontract='".$_POST['commentcontract']."',		
		link_website='".$_POST['link_website']."',
		link_webshop='".$_POST['link_webshop']."',
		link_bookline='".$_POST['link_bookline']."',
		link_lira='".$_POST['link_lira']."',
		link_libri='".$_POST['link_libri']."',
		link_alexandra='".$_POST['link_alexandra']."',
		link_telekiteka='".$_POST['link_telekiteka']."',
		link_googlebooks='".$_POST['link_googlebooks']."',
		onlineshop='".$_POST['onlineshop']."',
		onlineshopwindow='".$_POST['onlineshopwindow']."',
		coverfile='".$_POST['coverfile']."',
		imagename='".$_POST['imagename']."',
		extraname='".$_POST['extraname']."',
		status='".$_POST['status']."',
		status_contract='".$_POST['status_contract']."',
		status_dtp='".$_POST['status_dtp']."',
		status_copyediting='".$_POST['status_copyediting']."',
		status_cover='".$_POST['status_cover']."',
		status_printing='".$_POST['status_printing']."',
		status_billing='".$_POST['status_billing']."',
		author_address='".$_POST['author_address']."',
		author_email='".$_POST['author_email']."',
		date_submission='".bookParameters("pubyear",$_POST['year1'])."-".$_POST['month1']."-".$_POST['day1']."',
		date_publication='".bookParameters("pubyear",$_POST['year2'])."-".$_POST['month2']."-".$_POST['day2']."',
		abstractshort='".$_POST['abstractshort']."',
		blurb='".$_POST['blurb']."',
		extrainfo='".$_POST['extrainfo']."',
		comment='".$_POST['comment']."',
		category1='".$_POST['category1']."',
		category2='".$_POST['category2']."',
		distribution='".$_POST['distribution']."',
		date_modified='".time()."'
		where idbook=$idbook";
	sqlquery($db,$sql);
	print "A módosítás sikerült!";
}

function bookSearch($db) {
	# KERESÉS
	print "<BR />
			<P align='center'>
		<A HREF='$fajlnev?feladat=11&recent=20'>Az utolsó 20 tétel listázása</A></P>
			<form action='$fajlnev' method='get' >
				<input type='hidden' name='feladat' value='11' />
				<P align='center'>Keresőkifejezés: <input type='text' name='query' size='55' /></P>
				<P align='center'><input type='submit' value='KERESÉS'/></P>
				</form>";
	}

function bookDetails($db,$idbook=0) {
	# KÖNYV MEGJELENÍTÉSE, CIMKÉZÉS, ESEMÉNYEK HOZZÁADÁSA	
	# adatok átvétele
	if ($idbook==0) {$idbook=$_GET['idbook'];}
/*
	if ($uzenet==1)
		{$eredmeny=sqlite_query($db,"SELECT idbook FROM book ORDER BY date_created DESC");
			$sor = sqlite_fetch_array($eredmeny); $idbook=$sor[0];}
		else {$idbook=$_GET['idbook'];}
	# lekérdezés: könyv adatai
*/
	$eredmeny=sqlquery($db,"SELECT * FROM books WHERE idbook=$idbook");
	$sor=$eredmeny->fetch();
	$idbook_formatted=sprintf("%03d",$idbook);
	# lekérdezés: események
	$author=$sor['author'];
	if ((substr($sor['title'],-1)=="?") or (substr($sor['title'],-1)=="!") or (substr($sor['title'],-1)==".") )
		{$title=$sor['title'];} else {$title=$sor['title'].".";}
	$price="$sor[9] Ft";
	$isbn=$sor['isbn'];
	switch ($sor['sponsor']) {
		case 0: $sponsor="";break;
		case 1: $sponsor="- Előfinanszírozott"; break;
		case 2: $sponsor="- Utófinanszírozott"; break;
		case 3: $sponsor="- Ad Librum költségén"; break;
		case 4: $sponsor="- Egyéb finanszírozású"; break;
		}
	$pubyear=bookParameters("pubyear",$sor['pubyear']);
	switch ($sor['publisher']) {
		case 1: $publisher="Szerzői kiadás";$pub="Budapest, $pubyear."; break;
		case 2: $publisher="Ad Librum";$pub="Ad Librum, Budapest, $pubyear."; break;
		case 3: $publisher=$sor['publishing'];$pub=$sor['publishing'].", Budapest, $pubyear."; break;
		}
	#$format=bookParameters("format",$sor['format']);
	$format=$sor['format'];
	$pages=$sor['pages'];
	if ($sor['series']>0) {
		$series1='"'.bookParameters("series",$sor['series']).'" sorozat';
		$series2='Sorozat: <b>'.bookParameters("series",$sor['series'])."</b>";}
		else {$series="";}
	$price=$sor['price'];
	if (substr($sor['link_website'],0,4)=="http") {
			$link_website=$sor['link_website'];
		} else {
			$link_website="http://www.adlibrum.hu/".$sor['link_website'];
		}
	$link_webshop=$sor['link_webshop'];
	if ($link_webshop) {$shop="<p><a href='$link_webshop' title='Megveszem az Ad Librum webboltjában!'>Vásárolja meg webboltunkban!</a></p>";}
	if ($sor['link_googlebooks']) {$google="<p><a href='".$sor['link_googlebooks']."' title='Beleolvasok a Google Books-ban'>Olvasson bele (Google Books)!</a></p>";}
	if ($sor['link_lira'] or $sor['link_bookline']) {
		if ($sor['link_lira']) {$lira="<a href='".$sor['link_lira']."' title='Megveszem (Líra-Fókusz)!'>Fókusz Online</a>";}
		if ($sor['link_bookline']) {$bookline="<a href='".$sor['link_bookline']."' title='Megveszem (Bookline)!'>Bookline</a>";}
		$webshops="<p>Megvásárolható itt is: <strong>$bookline &nbsp; $lira &nbsp;&nbsp; 
		<a href='http://www.lirakonyv.hu/web/guest/bolthalozat' title='Az Ad Librum könyvei megvásárolhatóak a Líra bolthálózatában'>Líra könyvesbolt-hálózat</a> 
		</strong></p>";
		}
	$blurb=$sor['blurb'];
	$blurbhtml=str_replace("\n","<br/>",$blurb);
	$comment=$sor['comment'];
	$status=bookParameters("status",$sor['status']);
	if ($sor['category1']) {$categories="<p>Kategória: <strong>".bookParameters(categories,$sor['category1']);}
	if ($sor['category2']) {$categories.=", ".bookParameters(categories,$sor['category2'])."</strong></p>";} else {$categories.="</p>";}
	# listázás
	print "
		<table align=\"center\" CELLSPACING=\"10\">
		<tr bgcolor=\"lightgoldenrodyellow\"><td>
			<font size='-1'><A HREF='$fajlnev?feladat=13&idbook=$idbook' 
				title='Könyvadatok szerkesztése'>$idbook_formatted</A></font>
		</td></tr>
		<tr bgcolor='lightskyblue'><td><p>$author: <i>$title</i> $pub $series1</p></td></tr>
		<tr><td>Weboldalra</td></tr>
		<tr bgcolor='lightcoral'><td>
			$shop
			$google
			<p>Szerző: <b>$author</b></p>
			<p>Cím: <b>$title</b></p>
			$series2
			<p>Kiadó: <b>$publisher</b></p>
			<p>Kiadási év: <b>$pubyear</b></p>
			<p>ISBN: <b>$isbn</b></p>
			<p>Terjedelem: <b>$pages oldal</b></p>
			<p>Méret: <b>$format</b></p>
			<p>Ár: <b>$price Ft</b></p>
			$categories
			$webshops</strong>
			<p>Ismertető:</p>
			<p><strong>$blurbhtml</strong></p>
		</td></tr>
		<tr><td>Webshopba</td></tr>
		<tr bgcolor='lightsalmon'><td>
			$google
			<p>Szerző: <b>$author</b></p>
			<p>Cím: <b>$title</b></p>
			$series2
			<p>Kiadó: <b>$publisher</b></p>
			<p>Kiadási év: <b>$pubyear</b></p>
			<p>ISBN: <b>$isbn</b></p>
			<p>Terjedelem: <b>$pages oldal</b></p>
			<p>Méret: <b>$format</b></p>
			<p>Ár: <b>$price Ft</b></p>
			$categories
			$webshops
			<p><a href='$link_website'
				title='További információ a könyvről és szerzőjéről'>További információ</a></p>
		</td></tr>
		<tr bgcolor=\"lightgoldenrodyellow\"><td>
			<p>A kiadás állapota: <b>$status</b></p>
		</td></tr>
		<tr><td>Digitális különnyomatba</td></tr>
		<tr bgcolor='lightpink'><td>
			\\newcommand{\szerzo}{<i>$author</i>}<br/>
			\\newcommand{\copyrightname}{<i>$author</i>}<br/>
			\\newcommand{\\focim}{<i>$title</i>}<br/>
			\\newcommand{\alcim}{}<br/>
			\\newcommand{\webcim}{<i>$link_website</i>}<br/>
			\\newcommand{\shop}{<i>$link_webshop</i>}<br/>
			\\newcommand{\kiado}{<i>$publisher</i>}<br/>
			\\newcommand{\isbn}{<i>$isbn</i>}<br/>
			\\newcommand{\ev}{<i>".$pubyear."</i>}<br/>
			\\newcommand{\\terjedelem}{<i>$pages oldal</i>}<br/>
			\\newcommand{\meret}{<i>$format</i>}<br/>
			\\newcommand{\konyvar}{<i>$price Ft</i>}<br/>
			\\newcommand{\borito}{<i>../../Boritokepek/".$sor['imagename']."--FC.jpg</i>}<br/>
		</td></tr>
		</table>";
	}

function bookListCategories($db) {
	$fajlnev=$_SERVER['PHP_SELF'];
	print "<p>
		<a href=$fajlnev?feladat=bookListCategories&listamod=teljes>Teljes</a> 
		<a href=$fajlnev?feladat=bookListCategories&listamod=teljesforgalmazott>Teljes forgalmazott</a> 
		<a href=$fajlnev?feladat=bookListCategories&listamod=nemforgalmazott>Nem forgalmazott</a> 
		<a href=$fajlnev?feladat=bookListCategories&listamod=adlibrum>Ad Librum</a> 
		<a href=$fajlnev?feladat=bookListCategories&listamod=magankiadas>Magánkiadás</a> 
		</p>";
	if ($_GET['listamod']=="") {$_GET['listamod']="teljesforgalmazott";}
	switch ($_GET['listamod']) {
		case "teljes": $sqlplus=""; break;
		case "teljesforgalmazott": $sqlplus="and distribution<2"; break;
		case "nemforgalmazott": $sqlplus="and distribution=2"; break;
		case "adlibrum": $sqlplus="and publisher=2"; break;
		case "magankiadas": $sqlplus="and publisher=1"; break;
		}
	print "<table>";
	for ($i=1;$i<=44;$i++) {
		//print "<h3>$i - ".bookParameters("categories",$i)."</h3>";
		print "<h3>".bookParameters("categories",$i)."</h3>";
		$e=sqlquery($db,"select * from books where ( (category1=$i or category2=$i) $sqlplus) order by author");
		while ($sor = $e->fetch() ) {
			$pubyear=bookParameters("pubyear",$sor['pubyear']);
			switch ($sor['publisher']) {
				case 1: $publisher="Szerzői kiadás";$pub="Budapest, $pubyear."; break;
				case 2: $publisher="Ad Librum";$pub="Ad Librum, $pubyear."; break;
				case 3: $publisher=$sor['publishing'];$pub=$sor['publishing'].", Budapest, $pubyear."; break;
				}
			$pub=$pub." ISBN ".$sor['isbn'].", ".$sor['format'].", ".$sor['pages']." o., ".$sor['price']." Ft";
			if ($sor['link_googlebooks']) {$google="<a href='".$sor['link_googlebooks']."' 
					title='Beleolvasok a Google Könyvkeresőben'>Olvasson bele (Google Books)!</a> *";}
				else {$google="";}
			if ($sor['link_webshop']) {$webshops="<a href='".$sor['link_webshop']."' title='Megveszem az Ad Librum webboltjában!'>Ad Librum Webbolt</a>";}
			if ($sor['link_bookline']) {$webshops.=" + <a href='".$sor['link_bookline']."' title='Megveszem (Bookline)!'>Bookline</a>";}
			if ($sor['link_lira']) {$webshops.=" + <a href='".$sor['link_lira']."' title='Megveszem (Líra-Fókusz)!'>Fókusz Online</a> 
				+ <a href='http://www.lirakonyv.hu/web/guest/bolthalozat' title='Az Ad Librum könyvei megvásárolhatóak a Líra bolthálózatában'>Líra könyvesbolt-hálózat</a>";}
			if ($sor['distribution']==2) {$webshops="nem forgalmazzuk.";}
			
			if (substr($sor['link_website'],0,4)=="http") {
				$link_website=$sor['link_website'];
				} else {
					$link_website="http://www.adlibrum.hu/".$sor['link_website'];
				}

			print "<p>".$sor['author'].": <em><a href=$link_website title='Kattintson ide a könyv bővebb leírásáért!' >".$sor['title'].
				"</a></em></strong>. $pub</p>";
				#"</a></em></strong>. $pub<br/>".
				#"---> $google Megvásárolható: $webshops</p>";
			}
		}
		print "<hr/>";
		print "<h3>Kategorizálatlanok</h3>";
		$e=sqlquery($db,"select * from books where ( (category1=0 or category1 isnull) and idbook>0 and status=3)"); # a még kategorizálatlan esetek
		while ($sor = $e->fetch() ) {
			$idbook=$sor['idbook'];
			print "<p>".$sor['author'].": <em><a title='Könyvadatok szerkesztése' href='$fajlnev?feladat=13&idbook=$idbook'>".$sor['title']
				."</a></em></p>";
			
		}
	
	print "</table>";
	}


function inventoryCreate($db) {
	//$db->exec("drop table inventory") or die ("<br/>Nem sikerült a tábla dobása! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$sql="create table inventory (
		idtransaction integer primary key,
		idbook numeric,
		type numeric,
		client text,
		ordernr numeric,
		unitnr numeric,
		unitprice numeric,
		shipping numberic,
		postage numeric,
		wholesaler numeric,
		shippingtype numeric,
		paid numeric,
		inoviced numeric,
		reported numeric,
		transactiondate date,
		transactioninfo text,
		comment text
		)";
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$sql="insert into inventory
		values ('1','2','0','Viola Zoltán','','1','3790','0','','','2008-04-13','Saját vásárlás','')";
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$sql="insert into inventory
		values ('2','2','0','Becskeházy Adél','','3','2274','990','','','2008-04-21','Szerzői áron, nem jogdíjas','')";
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
}

function inventoryList($db,$idbook="") {
	$fajlnev=$_SERVER['PHP_SELF'];
	if ($_GET['inv']=="s") {$idbook="s";}
	switch ($idbook) {
	 case "": 
	 	$sqladd="where paid=1 and wholesaler=0 order by transactiondate desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "a": 
	 	$sqladd="order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 /*
	 case "b": 
	 	$sqladd="where paid=1 and wholesaler=0 order by transactiondate desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 */
	 case "c": 
	 	$sqladd="where wholesaler=2 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "d":
	 	$sqladd="where wholesaler=1 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "e":
	 	$sqladd="where wholesaler=3 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "f":
	 	$sqladd="where type=6 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "g":
	 	$sqladd="where type=7 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "h":
	 	$sqladd="where type=1 order by idtransaction desc";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "i": 
	 	$sqladd="order by idtransaction desc limit 100";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 case "s": # keresés
		$query=$_GET['query'];
	 	$sqladd="where ( (client like '%$query%') or (comment like '%$query%') or (transactioninfo like '%$query%') ) order by idtransaction desc limit 200";
		print "<a href='$fajlnev?feladat=24'>Új hozzáadása</a>";
		break;
	 default:
	 	$sqladd="where idbook=$idbook order by transactiondate desc";
		print "<a href='$fajlnev?feladat=22&idbook=$idbook&new=1'>Új hozzáadása</a>";
	 	break;
	}
	print " 
	<a href='$fajlnev?feladat=21&inventory=a' title='Összes könyvtranzakció megjelenítése'>Teljes lista</a> 
	<a href='$fajlnev?feladat=21&inventory=a' title='Kifizetetlen tételek (viszonteladók nélkül)'>Kifizetetlen</a> 
	<a href='$fajlnev?feladat=21&inventory=c' title='Líra: Szállítások és visszáru'>Líra</a> 
	<a href='$fajlnev?feladat=21&inventory=d' title='Fok-ta: Szállítások és visszáru'>Fok-ta</a> 
	<a href='$fajlnev?feladat=21&inventory=e' title='Egyéb viszonteladó: Szállítások és visszáru'>Egyéb</a> 
	<a href='$fajlnev?feladat=21&inventory=f' title='Nyomdai szállítások'>Nyomda</a> 
	<a href='$fajlnev?feladat=21&inventory=g' title='Kötelespéldányok'>Köteles</a> 
	<a href='$fajlnev?feladat=21&inventory=h' title='Eladások a webboltból'>Webbolt</a> 
	<a href='$fajlnev?feladat=21&inventory=i' title='Az utolsó 100 leltári mozgás'>Utolsó 100</a> 
	<br/>";
	$sql="select * from inventory $sqladd";
	$eredmeny=$db->query($sql)
		 or die ("<br/>Nem sikerült a lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");	
	print "<table>";
	formTableHead(array("Sor-<br/>szám","Könyvcím","Típus","Vevő","Kifizetés","Rendelés-<br/>szám",
		"Példány","Összár","Viszont-<br/>eladó","Dátum","Megjegyzés"));
	while ($sor=$eredmeny->fetch(PDO::FETCH_ASSOC) ) {
		//print $sor['idtransaction']." ".$sor['client']."<br/>";
		# a könyvcím hozzáadása
		$idbook=$sor['idbook'];
		# javítás - az egyszámjegyű hónap- és napszámok kétjegyűsítése a helyes sorbarakás érdekében
		/*		
		$datum=explode("-",$sor['transactiondate']);
		if (strlen($datum[1])==1) {$datum[1]="0".$datum[1];}
		if (strlen($datum[2])==1) {$datum[2]="0".$datum[2];}
		$sor['transactiondate']=$datum[0]."-".$datum[1]."-".$datum[2];
		$sql="update inventory set transactiondate='".$sor['transactiondate']."' where idtransaction='".$sor['idtransaction']."'";
		sqlquery($db,$sql);
		*/
		if (! empty($idbook)) {
			$eredmeny2=$db->query("select author,title from books where idbook=$idbook")
				 or die ("<br/>Nem sikerült a lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
			$sor2=$eredmeny2->fetch();
			$sor['idbook']=$sor2[0].": ".$sor2[1];
			}
		# egyéb adatok
		if (empty($sor['wholesaler'])) {$wholesaler="";} else {$wholesaler=bookParameters("wholesaler",$sor['wholesaler']);}
		if ($sor['type']==0) {$type="<font color='red'>KITÖLTENDŐ!</font>";} else {$type=bookParameters("inventorytypes",$sor['type']);}
		# link létrehozása
		$sor['idtransaction']="<a href='$fajlnev?feladat=22&idtransaction="
			.$sor['idtransaction']."' >".$sor['idtransaction']."</a>";
		# fizetés jelző
		if ($sor['paid']==0) {$paid="---";}
		if ($sor['paid']==1) {$paid="<font color='darkred'>Kifizetetlen</font>";}
		if ($sor['paid']==2) {$paid="Fizetve";}
		
		# táblázat kiíratása
		formTableRow(array($sor['idtransaction'],"<a href='$fajlnev?feladat=26&idbook=$idbook' 
			title='Fogyási jelentés'>".$sor['idbook']."</a>",$type,
			$sor['client'],$paid,$sor['ordernr'],$sor['unitnr'],$sor['unitnr']*$sor['unitprice'],
			$wholesaler,$sor['transactiondate'],$sor['transactioninfo']));
	}
	print "</table>";
}

function inventoryForm($db) {
	if ($_GET['new']==1) {
			$idbook=$_GET['idbook'];
			sqlquery($db,"insert into inventory (idbook) values ('$idbook')");
			$e=sqlquery($db,"select max(idtransaction) from inventory");
			$s=$e->fetch();
			$idtransaction=$s[0];
		}
		else {$idtransaction=$_GET['idtransaction'];}
	$eredmeny=sqlquery($db,"select * from inventory where idtransaction=$idtransaction");	
	$sor=$eredmeny->fetch(PDO::FETCH_ASSOC);
	print "<form action=\"$fajlnev\" method=\"get\" >";
	print formHidden("feladat","23");
	print formHidden("nexttask",$_GET['nexttask']);
	print "<table>";
	formTableHead(array("Mező","Adat","Megjegyzés"));
	formTableRow(array("Sorszám:",$sor['idtransaction'],
		"A tranzakció sorszáma. Nem változtatható meg."));
	print formHidden("idtransaction",$sor['idtransaction']);
	$idbook=$sor['idbook'];
	if (! empty($idbook)) {
		$eredmeny2=$db->query("select author,title,price from books where idbook=$idbook")
			 or die ("<br/>Nem sikerült a lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
		$sor2=$eredmeny2->fetch();
		$booktitle="<em>".$sor2[0].": ".$sor2[1]."</em>";
		}
	formTableRow(array("Tranzakciótípus:",
		formSelect(bookParameters("inventorytypes"),"type",$sor['type']),
		"A leltári mozgás fajtája. Feltétlenül kitöltendő! (Eladás kiadóból = webbolt, email, tel., levelezőlap stb.)"));
	formTableRow(array("Könyv sorszáma:",
		formInput("idbook",$idbook,3),
		$booktitle));
	formTableRow(array("Vevő neve:",
		formInput("client",$sor['client'],25),
		"Bármilyen értelmes leírás megfelelő, ami megkönnyíti a tranzakció azonosítását."));
	formTableRow(array("Rendelésszám:",
		formInput("ordernr",$sor['ordernr'],7),
		"Az internetes rendelések vagy szállítólevelek sorszáma."));
	formTableRow(array("Példány:",
		formInput("unitnr",$sor['unitnr'],3),
		"A tranzakcióban érintett példányok száma."));
	formTableRow(array("Egységár:",
		formInput("unitprice",$sor['unitprice'],4)." Ft (könyvár: ".$sor2['price']." Ft)",
		"A könyv eladási egységára áfával, kedvezményekkel."));
	formTableRow(array("Összesített bruttó ár:",
		$sor['unitnr']*$sor['unitprice']." Ft",
		"A könyvek összes ára 5% áfával."));
	formTableRow(array("Összesített nettó ár:",
		round(20/21*$sor['unitnr']*$sor['unitprice'])." Ft",
		"A könyvek összes ára áfa nélkül."));
	formTableRow(array("Továbbszámlázott postaköltség:",
		formInput("shipping",$sor['shipping'],4)." Ft",
		"Utánvétel összegébe bevett költség vagy a számlán felszámolt postaköltség"));
	formTableRow(array("Teljes számlázott összeg:",
		round(($sor['unitnr']*$sor['unitprice'])+$sor['postage'])." Ft",
		"Teljes számlázott bruttó összeg: könyv+postaköltség+áfa."));
	formTableRow(array("Postaköltség:",
		formInput("postage",$sor['postage'],4)." Ft",
		"A küldemény feladáskor jelentkező postaköltsége (akkor is, ha nincs továbbszámlázva)"));
	formTableRow(array("Postázási mód:",
		formSelect(bookParameters("shippingtype"),"shippingtype",$sor['shippingtype']),
		"A szállítás típusa."));
	formTableRow(array("Számla:",
		formSelect(bookParameters("invoiced"),"invoiced",$sor['invoiced']),
		"Számla kibocsájtása."));
	formTableRow(array("Fizetve:",
		formSelect(bookParameters("paid"),"paid",$sor['paid']),
		"Az ellenérték kifizetése megtörtént-e."));
	formTableRow(array("Fogyási jelentésbe:",
		formSelect(bookParameters("reported"),"reported",$sor['reported']),
		"Bekerül-e a fogyási jelentésbe."));
	formTableRow(array("Kereskedő:",
		formSelect(bookParameters("wholesaler"),"wholesaler",$sor['wholesaler']),
		"Viszonteladói kapcsolat (kereskedőnek szállítás és visszáru).
		Az \"Egyéb\" a Megjegyzés rovatban megnevezendő."));
	formTableRow(array("Dátum:",
		formDate(explode("-",$sor['transactiondate'])),
		"A leltári mozgás dátuma."));
	formTableRow(array("Megjegyzés:",
		#formInput("transactioninfo",$sor['transactioninfo'],25),
		"<textarea name='transactioninfo' cols='35' ROWS='4'>".$sor['transactioninfo']."</textarea>",
		"Olyan megjegyzések, amelyek segítik a tranzakció azonosítását: kifizetési adatok, antikvár könyv címe, átvétel körülményei stb."));
#	formTableRow(array("Egyéb megjegyzés:",
#		"<textarea name='abstractshort' cols='35' ROWS='2'>".$sor['comment']."</textarea>",
#		"Minden egyéb feljegyzés."));
	if (q==11) {$q='formHidden("q","11")';}
	formTableRow(array("",
		"<br/>".$q.formSubmit("ADATOK RÖGZÍTÉSE"),
		""));
	print "</table>";
}

function inventoryData($db) {
	if ($_GET['year']==0) {$year="%";}
		else {$years=bookParameters("pubyear");$year=$years[$_GET['year']];}
	if ($_GET['month']==0) {$month="%";} else {
		if ($_GET['month'] < 10) {$month="0".$_GET['month'];} else {$month=$_GET['month'];}
		}
	if ($_GET['day']==0) {$day="%";} else {
		if ($_GET['day']<10) {$day="0".$_GET['day'];} else {$day=$_GET['day'];}
		}
	$transactiondate=$year."-".$month."-".$day;
	$sql="update inventory set idbook='".$_GET['idbook']
		."',type='".$_GET['type']
		."',client='".$_GET['client']
		."',ordernr='".$_GET['ordernr']
		."',unitnr='".$_GET['unitnr']
		."',unitprice='".$_GET['unitprice']
		."',shipping='".$_GET['shipping']
		."',postage='".$_GET['postage']
		."',shippingtype='".$_GET['shippingtype']
		."',paid='".$_GET['paid']
		."',invoiced='".$_GET['invoiced']
		."',reported='".$_GET['reported']
		."',wholesaler='".$_GET['wholesaler']
		."',transactiondate='".$transactiondate
		."',transactioninfo='".$_GET['transactioninfo']
		."',comment='".$_GET['comment']
		."' where idtransaction=".$_GET['idtransaction'];
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	print "A módosítás sikerült!<br/>
		<a href='$fajlnev?feladat=22&idtransaction=".$_GET['idtransaction']."'>Módosított javítása</a><br/>";
	//<a href='$fajlnev?feladat=24'>Új hozzáadása</a><br/> <a href='$fajlnev?feladat=21'>Listázás</a><br/>
	$sql="select * from inventory where idtransaction=".$_GET['idtransaction'];
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
}

function inventoryAdd($db) {
	$e=sqlquery($db,"select idbook,author,title from books order by author");
	while ($s=$e->fetch()) {
		print "<a href='$fajlnev?feladat=22&new=1&idbook=".$s['idbook']."'>".$s['author'].": ".$s['title']."</a><br/>";
		}
	$sql="insert into inventory (client) values ('ÚJ')";
	//$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	//inventoryList($db);
}

function inventoryStat($db) {
	$sql="select books.idbook as id,author,title,count(idtransaction) as soldtr,
		sum(unitnr*(type=1)) as soldweb, sum(unitnr*(type=2)) as soldother
		from inventory,books 
		where books.idbook=inventory.idbook group by books.idbook";
	$e=sqlquery($db,$sql);
	print "<table>";
	formTableHead(array("Sorszám","Könyvcím","Tranzakciók száma",
		"Webboltból","Egyéb eladás"));
	while ($s=$e->fetch(PDO::FETCH_ASSOC) ) {
		formTableRow(array($s['id'],$s['author'].": ".$s['title'],
			$s['soldtr'],$s['soldweb']." pld.",$s['soldother']." pld."));
	}
	print "</table>";
	$sql="select books.idbook as id,author,title,count(idtransaction) as soldtr,
		sum(unitnr*(type=1)) as soldweb, sum(unitnr*(type=2)) as soldother
		from inventory,books 
		where books.idbook=inventory.idbook group by books.idbook";
	
	$sql="select books.idbook as id,author,title,
		count(idtransaction) as soldtr,
		sum(unitnr*(type=1)) as soldweb,
		sum(unitnr*(type=1)*(paid=2)) as soldwebpaid,
		sum(unitnr*(type=1)*unitprice) as soldwebsum,
		sum(unitnr*(type=1)*unitprice*(paid=2)) as soldwebsumpaid,
		sum(unitnr*(type=2)) as soldother,
		sum(unitnr*(type=2)*unitprice) as soldothersum,
		sum(unitnr*(type=3)) as toauthor,
		sum(unitnr*(type=4)) as toreseller,
		sum(unitnr*(type=5)) as fromreseller,
		sum(unitnr*(type=6)) as fromprinter,
		sum(unitnr*(type=7)) as tolibraries
		from inventory,books 
		where books.idbook=inventory.idbook group by books.idbook order by books.author";
	$e=sqlquery($db,$sql);
	while ($s=$e->fetch(PDO::FETCH_ASSOC) ) {
		print "<b>".$s['author'].": ".$s['title']."</b><br/>".
			"Webboltból eladott könyvek száma: ".$s['soldweb'].
				" pld., ebből kifizetve:".$s['soldwebpaid']." pld.<br/>".
			"Webboltból eladott könyvek értéke: ".$s['soldwebsum']." Ft., ebből kifizetve:".$s['soldwebsumpaid']." Ft<br/>".
			"Viszonteladón keresztül eladott könyvek száma: ".$s['soldother']." pld.<br/>".
			"Viszonteladón keresztül eladott könyvek értéke: ".$s['soldothersum']." Ft<br/>".
			"Szerzőnek saját példányok: ".$s['toauthor']." pld.<br/>".
			"Viszonteladónak beszállítás: ".$s['toreseller']." pld.<br/>".
			"Visszáru viszonteladótól: ".$s['fromreseller']." pld.<br/>".
			"Beszállított könyvek (nyomdából): ".$s['fromprinter']." pld.<br/>".
			"Kötelespéldány: ".$s['tolibraries']." pld.<br/>"
			;
	}
	$sql="select 
		count(idtransaction) as soldtr,
		sum(unitnr*(type=1)) as soldweb,
		sum(unitnr*(type=1)*(paid=2)) as soldwebpaid,
		sum(unitnr*(type=1)*unitprice) as soldwebsum,
		sum(unitnr*(type=1)*unitprice*(paid=2)) as soldwebsumpaid,
		sum(unitnr*(type=2)) as soldother,
		sum(unitnr*(type=2)*unitprice) as soldothersum,
		sum(unitnr*(type=3)) as toauthor,
		sum(unitnr*(type=4)) as toreseller,
		sum(unitnr*(type=5)) as fromreseller,
		sum(unitnr*(type=6)) as fromprinter,
		sum(unitnr*(type=7)) as tolibraries
		from inventory,books 
		where books.idbook=inventory.idbook";
	$e=sqlquery($db,$sql);
	$s=$e->fetch(PDO::FETCH_ASSOC);
	print "<br/><b>Összesen</b><br/>".
		"Webboltból eladott könyvek száma: ".$s['soldweb'].
			" pld., ebből kifizetve:".$s['soldwebpaid']." pld.<br/>".
		"Webboltból eladott könyvek értéke: ".$s['soldwebsum']." Ft., ebből kifizetve:".$s['soldwebsumpaid']." Ft<br/>".
		"Viszonteladón keresztül eladott könyvek száma: ".$s['soldother']." pld.<br/>".
		"Viszonteladón keresztül eladott könyvek értéke: ".$s['soldothersum']." Ft<br/>".
		"Szerzőnek saját példányok: ".$s['toauthor']." pld.<br/>".
		"Viszonteladónak beszállítás: ".$s['toreseller']." pld.<br/>".
		"Visszáru viszonteladótól: ".$s['fromreseller']." pld.<br/>".
		"Beszállított könyvek (nyomdából): ".$s['fromprinter']." pld.<br/>".
		"Kötelespéldány: ".$s['tolibraries']." pld.<br/>"
		;
}

function inventorySum($db,$idbook,$reported=1,$targetdate='2020-01-01') {
	if($reported==1) {$reported="";} else {$reported="*(inventory.reported=0)";}
	#$reported="*(reported=0)";
	$e=sqlquery($db,"select author,title,price,
		contracted,quarter,contracttype,printrun,
		datepuby,datepubm,royaltywebshop,royaltyreseller,authorprice,
		count(idtransaction) as soldtr,
		$soldweb
		sum(unitnr*(type=1)$reported) as soldweb,
		sum(unitnr*(type=1)*(paid=2)$reported) as soldwebpaid,
		sum(unitnr*(type=1)*unitprice$reported) as soldwebsum,
		sum(unitnr*(type=1)*unitprice*(paid=2)$reported) as soldwebsumpaid,
		sum(unitnr*(type=2)$reported) as soldreseller,
		sum(unitnr*(type=2)*(paid=2)$reported) as soldresellerpaid,
		sum(unitnr*(type=2)*unitprice$reported) as soldresellersum,
		sum(unitnr*(type=2)*unitprice*(paid=2)$reported) as soldresellersumpaid,
		sum(unitnr*(type=2)*(wholesaler=1)$reported) as soldresellerfokta,
		sum(unitnr*(type=2)*(paid=2)*(wholesaler=1)$reported) as soldresellerpaidfokta,
		sum(unitnr*(type=2)*unitprice*(wholesaler=1)$reported) as soldresellersumfokta,
		sum(unitnr*(type=2)*unitprice*(paid=2)*(wholesaler=1)$reported) as soldresellersumpaidfokta,
		sum(unitnr*(type=2)*(wholesaler=2)$reported) as soldresellerlira,
		sum(unitnr*(type=2)*(paid=2)*(wholesaler=2)$reported) as soldresellerpaidlira,
		sum(unitnr*(type=2)*unitprice*(wholesaler=2)$reported) as soldresellersumlira,
		sum(unitnr*(type=2)*unitprice*(paid=2)*(wholesaler=2)$reported) as soldresellersumpaidlira,
		sum(unitnr*(type=2)*(wholesaler=3)$reported) as soldresellerother,
		sum(unitnr*(type=2)*(paid=2)*(wholesaler=3)$reported) as soldresellerpaidother,
		sum(unitnr*(type=2)*unitprice*(wholesaler=3)$reported) as soldresellersumother,
		sum(unitnr*(type=2)*unitprice*(paid=2)*(wholesaler=3)$reported) as soldresellersumpaidother,
		sum(unitnr*(type=3)$reported) as soldauthor,
		sum(unitnr*(type=3)*(paid=2)$reported) as soldauthorpaid,
		sum(unitnr*(type=3)*unitprice$reported) as soldauthorsum,
		sum(unitnr*(type=3)*unitprice*(paid=2)$reported) as soldauthorsumpaid,
		sum(unitnr*(type=4)$reported) as toreseller,
		sum(unitnr*(type=5)$reported) as fromreseller,
		sum(unitnr*(type=4)*(wholesaler=1)$reported) as toresellerfokta,
		sum(unitnr*(type=5)*(wholesaler=1)$reported) as fromresellerfokta,
		sum(unitnr*(type=4)*(wholesaler=2)$reported) as toresellerlira,
		sum(unitnr*(type=5)*(wholesaler=2)$reported) as fromresellerlira,
		sum(unitnr*(type=4)*(wholesaler=3)$reported) as toresellerother,
		sum(unitnr*(type=5)*(wholesaler=3)$reported) as fromresellerother,
		sum(unitnr*(type=6)$reported) as fromprinter,
		sum(unitnr*(type=7)$reported) as tolibraries,
		sum(unitnr*(type=8)$reported) as freecopy,
		sum(unitnr*(type=9)$reported) as tostores,
		sum(unitnr*(type=10)$reported) as fromstores,
		sum(unitnr*(type=11)$reported) as toconsignment,
		sum(unitnr*(type=12)$reported) as fromconsignment,
		sum(unitnr*(type=13)$reported) as todepot,
		sum(unitnr*(type=14)$reported) as fromdepot,
		sum(unitnr*(type=15)$reported) as tounknown,
		sum(unitnr*(type=16)$reported) as fromunknown,
		sum(unitnr*(type=1)*(inventory.reported=0))*price*100/105*royaltywebshop/100 as royaltywebshopsum,
		sum(unitnr*(type=1)*(paid=2)*(inventory.reported=0))*price*100/105*royaltywebshop/100 as royaltywebshopsumpaid,
		sum(unitnr*(type=2)*(inventory.reported=0))*price*100/105*royaltyreseller/100 as royaltyresellersum,
		sum(unitnr*(type=2)*(paid=2)*(inventory.reported=0))*price*100/105*royaltyreseller/100 as royaltyresellersumpaid,
		sum(unitnr*(type=11)) as toconsignment,
		sum(unitnr*(type=12)) as toproperty,
		sponsor,author_email,link_website,link_webshop,addedinfo
		from inventory,books
		where books.idbook=$idbook and inventory.idbook=books.idbook and transactiondate<'$targetdate'");
	$s=$e->fetch(PDO::FETCH_ASSOC);
	if ($s['sponsor']==5 and $s['royaltywebshop']=="") {
		$s['royaltywebshopsum']=$s['soldweb']*($s['price']-$s['authorprice']);
		$s['royaltywebshopsumpaid']=$s['soldwebpaid']*($s['price']-$s['authorprice']);
	}
	$s['totalsold']=$s['soldweb']+$s['soldreseller']+$s['soldauthor']+$s['tolibraries']+$s['freecopy']; #minden állományból kikerült
	$s['totalsoldpaid']=$s['soldwebpaid']+$s['soldresellerpaid']+$s['soldauthorpaid']+$s['tolibraries']+$s['freecopy'];

	return $s;
}

function inventoryTotal($db) {
	if ($_GET['q']=='11') {$ertek="Érték";$totalvalue=0;$q="&q=11";}
	$ev=$_GET['ev'];
	print "<a href='$fajlnev?feladat=inventoryTotal&ev=$ev&sponsor=3$q'>Saját kiadás</a> <a href='$fajlnev?feladat=inventoryTotal&ev=$ev&sponsor=1$q'>Előfinanszírozott kiadás</a> 
		<a href='$fajlnev?feladat=inventoryTotal&ev=$ev&sponsor=5$q'>POD kiadás</a> <a href='$fajlnev?feladat=inventoryTotal&ev=$ev&sponsor=2$q'>Ingyenes kiadás</a></p>
		<a href='$fajlnev?feladat=inventoryTotal&ev=$ev&sponsor=4$q'>Bérmunka</a>
		</p>";
	$sponsor=$_GET['sponsor'];
	if ($sponsor=="") {$sponsor=2;} # alapeset az ingyenes kiadás
	$sql="select * from books where (sponsor=$sponsor and status=3 and datepuby<='$ev') order by datepuby desc,datepubm desc,datepubd desc";
	$booklist=sqlquery($db,$sql);
	print "<table>";
	formTableHead(array("Dátum","Könyvcím","Iroda","Raktár","Ismeretlen","Kiadóban","Líra","Fok-ta","Egyéb","Viszonteladónál","Összesen",$ertek));
	while ($sor=$booklist->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		#összesítések a forgalomról az inventory táblából MINDEN TÉTEL
		if ($ev==2009) {$t=inventorySum($db,$idbook,"1","2010-01-01");}
		if ($ev==2010) {$t=inventorySum($db,$idbook,"1","2011-01-01");}
		if ($ev==2011) {$t=inventorySum($db,$idbook,"1","2012-01-01");}
		if ($ev==2012) {$t=inventorySum($db,$idbook,"1","2013-01-01");}
		if ($ev==2013) {$t=inventorySum($db,$idbook,"1","2014-01-01");}
		if ($ev==2014) {$t=inventorySum($db,$idbook,"1","2015-01-01");}
		if ($ev==2015) {$t=inventorySum($db,$idbook,"1","2016-01-01");}
		if ($ev==2016) {$t=inventorySum($db,$idbook,"1","2017-01-01");}
		if ($ev==2017) {$t=inventorySum($db,$idbook,"1","2018-01-01");}
		#if ($ev=="") {$t=inventorySum($db,$idbook,"1");}
		$s=costsData($db,$idbook); #kiadási-bevételi összesítések a costs táblából
		$contracttype=$sor['contracttype'];
		$book=$sor['author'].": ".strtok($sor['title']," ")." ".strtok(" ");
		$netto=100/105;
		$invresellerfokta=$t['toresellerfokta']-$t['fromresellerfokta']-$t['soldresellerfokta'];
		$invresellerlira=$t['toresellerlira']-$t['fromresellerlira']-$t['soldresellerlira'];
		$invresellerother=$t['toresellerother']-$t['fromresellerother']-$t['soldresellerother'];
		$invreseller=$t['toreseller']-$t['fromreseller']-$t['soldreseller'];
		$invstores=$t['tostores']-$t['fromstores'];
		if ($_GET['q']=='11') {
				$invpublisher=$t['fromprinter']-$t['toreseller']+$t['fromreseller']-$t['soldweb']-$t['soldauthor']-$t['tolibraries']-$t['freecopy'];
				$invdepot=$t['todepot']-$t['fromdepot'];
				$invunknown=$t['tounknown']-$t['fromunknown'];
				$invoffice=$invpublisher-$invstores-$invdepot-$invunknown;
				if ($invoffice<0) { #a bizományosi kezelésből származó mínuszok átírása a Líra vagy a raktár készletébe
					$invoffice=$invoffice+$t['toconsignment'];
					$invpublisher=$invpublisher+$t['toconsignment'];
					if ($invstores>$t['toconsignment']) {$invstores=$invstores-$t['toconsignment'];} else {$invresellerlira=$invresellerlira-$t['toconsignment'];}
					# ha még mindig nem jó
					if ($invoffice<0) {$invresellerlira=$invresellerlira+$invoffice;$invoffice=0;$invpublisher=$invstores;}
					if ($invresellerfokta<0) {$invresellerlira=$invresellerlira+$invresellerfokta; $invresellerfokta=0;}
					if ($invresellerlira<0) {$invresellerfokta=$invresellerfokta+$invresellerlira;$invresellerlira=0;}
					}
				}
			else {
				$invpublisher=$t['fromprinter']-$t['toreseller']+$t['fromreseller']-$t['soldweb']-$t['soldauthor']-$t['tolibraries']-$t['freecopy']+$t['toconsignment'];
				$invunknown=$t['tounknown']-$t['fromunknown'];
				//$invoffice=$invpublisher-$invstores-$invdepot-$invunknown;
				$invoffice=$invpublisher-$invstores;
				}
		$invtotal=$invreseller+$invpublisher;
		if ($_GET['q']=='11') {
			if ($t['fromprinter']==0) {
					$invvalue="<a href='$fajlnev?feladat=32&idbook=$idbook&q=11 title='Költségek'>JAVÍTANI!</a>";
				} else {
					$value=$invtotal*100/105*$s['printingcosts']/$t['fromprinter'];
					$invvalue="<a href='$fajlnev?feladat=32&idbook=$idbook&q=11 title='Költségek'>".
						number_format($value,0,","," ")
						." Ft</a>";
					# a még meglévő példányok száma szorozva az egyes példányok árának áfa nélküli értékével (egyben link a költségekre)
					$totalvalue+=$value;
				}
			} else {
				$invvalue="";
			}
		if ($_GET['q']=='11' and ($invtotal<1 or $s['printingcosts']==0)) {# ha nincs készlet vagy elrontott vagy csak átvett, érték nélküli (Gáthy) = nem jelenik meg
			} else {
			$totalpublisher+=$invpublisher;
			$totalinventory+=$invtotal;
			formTableRow(array(
				"<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>".$sor['datepuby']."-".$sor['datepubm']."</a>",
				"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
				"<strong><em>".$invoffice."</em></strong>",$invstores,$invunknown,"<strong>".$invpublisher."</strong>",
				$invresellerlira,$invresellerfokta,$invresellerother,
				"<strong>".$invreseller."</strong>","<strong>".$invtotal."</strong>",
				"<strong>".$invvalue."</strong>"
				),$center=1);
			}
	}
	if ($_GET['q']=='1') {
		formTableRow(array("","","","","$totalpublisher","","","","","$totalinventory","<strong>".number_format($totalvalue,0,","," ")." Ft</strong>"),$center=1);
		}
	print "</table>";
}

function inventorySalesReport($db) {
	$idbook=$_GET['idbook'];
	print "<table cellspacing='8'>";
	$t=inventorySum($db,$idbook);
	$s=costsData($db,$idbook);

	formTableRow(array("Sorszám","<a href='$fajlnev?feladat=13&idbook=$idbook' title='Könyvadatok szerkesztése'>$idbook</a>"));
	formTableRow(array("Szerző","<b>".$t['author']."</b>"));
	formTableRow(array("Cím","<font size='+1'><em>".$t['title']."</em></font>"));
	formTableRow(array("Könyvár:",$t['price']." Ft"));
	formTableRow(array("Megjegyzés:",$t['addedinfo']));
	print "</table><hr/>";
	
	inventoryList($db,$idbook);
	
	print "<hr/>";
	
	print "<table cellspacing='8'>";
	#if ($t['sponsor'] == 2 or $t['sponsor'] == 3 or $t['sponsor'] == 5) {$totalin=$t['fromprinter']+$t['toconsignment'];}
	#	else {$totalin=$t['fromprinter'];}
	$totalin=$t['fromprinter']+$t['toconsignment'];
	formTableRow(array(""));
	formTableRow(array("<strong>Forgalom</strong>"));
	formTableRow(array("Beszállított példányszám","<b>".$totalin."</b> példány"));
	if ($totalin>$t['fromprinter']) {formTableRow(array("Bizományba adott példányszám","<b>".$consignment."</b> példány"));}
	formTableRow(array("Webboltból eladott könyvek száma: ",$t['soldweb'].
		" példány, ebből kifizetve: ".$t['soldwebpaid']." példány"));
	formTableRow(array("Viszonteladón keresztül eladott könyvek száma: ",$t['soldreseller'].
		" példány, ebből kifizetve: ".$t['soldresellerpaid']." példány"));
	formTableRow(array("Szerzői vásárlás: ",$t['soldauthor'].
		" példány, ebből kifizetve: ".$t['soldauthorpaid']." példány"));
	formTableRow(array("Tiszteletpéldány, ajándék, referencia: ",$t['freecopy']." példány"));
	formTableRow(array("Kötelespéldány: ",$t['tolibraries']." példány"));
#	$t['totalsold']=$t['soldweb']+$t['soldreseller']+$t['soldauthor']+$t['tolibraries']+$t['freecopy'];
#	$t['totalsoldpaid']=$t['soldwebpaid']+$t['soldresellerpaid']+$t['soldauthorpaid']+$t['tolibraries']+$t['freecopy'];
	formTableRow(array("Eddigi forgalom:","<strong>".$t['totalsold']."</strong> pld. (ebből kifizetve <strong>".
		$t['totalsoldpaid']."</strong> pld., kifizetetlen <strong>".($t['totalsold']-$t['totalsoldpaid'])."</strong> pld.)"));
	formTableRow(array("Megmaradt:","<strong>".($totalin-$t['totalsold'])."</strong> példány"));
	
	formTableRow(array(""));
	formTableRow(array("<strong>Leltár</strong>"));
	$invreseller=$t['toreseller']-$t['fromreseller']-$t['soldreseller'];
	formTableRow(array("Viszonteladónál:",$invreseller." példány (".$t['toreseller'].
		" pld. kiszállítva, visszáru ".$t['fromreseller'].
		" pld., eladva ".$t['soldreseller']." pld.)"));
	$invresellerfokta=$t['toresellerfokta']-$t['fromresellerfokta']-$t['soldresellerfokta'];
	$invresellerlira=$t['toresellerlira']-$t['fromresellerlira']-$t['soldresellerlira'];
	$invresellerother=$t['toresellerother']-$t['fromresellerother']-$t['soldresellerother'];
	formTableRow(array(" + Líra:"," + ".$invresellerlira." példány (".$t['toresellerlira'].
		" pld. kiszállítva, visszáru ".$t['fromresellerlira'].
		" pld., eladva ".$t['soldresellerlira']." pld.)"));
	formTableRow(array(" + Fok-ta:"," + ".$invresellerfokta." példány (".$t['toresellerfokta'].
		" pld. kiszállítva, visszáru ".$t['fromresellerfokta'].
		" pld., eladva ".$t['soldresellerfokta']." pld.)"));
	formTableRow(array(" + Egyéb:"," + ".$invresellerother." példány (".$t['toresellerother'].
		" pld. kiszállítva, visszáru ".$t['fromresellerother'].
		" pld., eladva ".$t['soldresellerother']." pld.)"));
	$invpublisher=$totalin-$t['toreseller']+$t['fromreseller']-$t['soldweb']-$t['soldauthor']-$t['tolibraries']-$t['freecopy'];
	$invstores=$t['tostores']-$t['fromstores'];
	$invdepot=$t['todepot']-$t['fromdepot'];
	$invunknown=$t['tounknown']-$t['fromunknown'];
	$invoffice=$invpublisher-$invstores-$invdepot-$invunknown;
	formTableRow(array("Kiadónál:","$invpublisher példány"));
	formTableRow(array(" + Irodában:"," + $invoffice példány"));
	formTableRow(array(" + Külső raktárban:"," + $invstores példány (beszállítva ".$t['tostores']." pld., visszaszállítva ".$t['fromstores']." pld.)"));
	formTableRow(array(" + Bérraktárban:"," + $invdepot példány (beszállítva ".$t['todepot']." pld., visszaszállítva ".$t['fromdepot']." pld.)"));
	formTableRow(array(" + Ismeretlen helyen:"," + $invunknown példány (beszállítva ".$t['tounknown']." pld., visszaszállítva ".$t['fromunknown']." pld.)"));
	formTableRow(array("Összesen:","<strong>".($invreseller+$invpublisher)."</strong> példány"));

	if ($t['sponsor'] == 2 or $t['sponsor'] == 3 or $t['sponsor'] == 5) {#alapból kiadói tulajdon
		$consignment=$t['toconsignment'];
		$pubproperty=$invreseller+$invpublisher-$consignment;
		}
	if ($t['sponsor'] == 1 or $t['sponsor'] == 4) {#alapból bizományosi átvétel
		if ( ($totalin-$t['totalsold']) < $t['toproperty']) {# ha már csak a saját utánnyomásból maradt
			$pubproperty=$totalin-$t['totalsold'];
			$consignment=0;}
			else {$pubproperty=$t['toproperty']; $consignment=$totalin-$t['totalsold']-$pubproperty;}
		}
	formTableRow(array(""));
	formTableRow(array("<strong>Kiadó által kezelt példányok tulajdoni megoszlása</strong>"));
	formTableRow(array("Kiadói tulajdonban: ",$pubproperty." példány"));
	formTableRow(array("Bizományba átvéve: ",$consignment." példány"));
	formTableRow(array("Összesen:","<strong>".($pubproperty+$consignment)."</strong> példány"));	
		
	formTableRow(array(""));
	formTableRow(array("<strong>Bevétel</strong>","<em>(áfás összegek)</em>"));
	formTableRow(array("Webboltból eladott könyvek értéke: ",round($t['soldwebsum']).
		" Ft, ebből kifizetve: ".round($t['soldwebsumpaid'])." Ft"));
	formTableRow(array("Viszonteladón keresztül eladott könyvek értéke: ",round($t['soldresellersum']).
		" Ft, ebből kifizetve: ".round($t['soldresellersumpaid'])." Ft"));
	formTableRow(array("Szerzői vásárlás értéke: ",round($t['soldauthorsum']).
		" Ft, ebből kifizetve: ".round($t['soldauthorsumpaid'])." Ft"));

	formTableRow(array(""));
	formTableRow(array("<strong>Jogdíj</strong>","<em>(áfa nélküli, adózás előtti összegek)</em>"));
	formTableRow(array("Webboltból eladott könyvek jogdíja: ",round($t['royaltywebshopsumpaid']).
		" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)"));
	formTableRow(array("Viszonteladón keresztül eladott könyvek jogdíja: ",
		round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)"));
	$royalty=round($t['royaltyresellersumpaid']+$t['royaltywebshopsumpaid']);
	$royaltyexpected=round($t['royaltyresellersum']+$t['royaltywebshopsum']);
	formTableRow(array("Összes jogdíj: ","$royalty Ft (várhatóan: $royaltyexpected Ft)"));
	$royaltyremained=$royalty-$s['royaltypaid'];
	$royaltyremainedexpected=$royaltyexpected-$s['royaltypaid'];
	formTableRow(array("Kifizetett jogdíj: ",$s['royaltypaid']." Ft (költség járulékokkal együtt)"));
	formTableRow(array("Összegyűlt jogdíj: ","$royaltyremained Ft (várhatóan: $royaltyremainedexpected Ft)"));
	
	#Ingyenes kiadási program
	$contracttype=$t['contracttype'];
	if ($t['sponsor'] == 2) {
		formTableRow(array(""));
		formTableRow(array("<strong>Ingyenes kiadási program</strong>"));
		formTableRow(array("Vállalt forgalom","<b>".$t['contracted']."</b> példány"));
		formTableRow(array("Szerződéstípus",bookParameters("contracttype",$contracttype)." elszámolás az elvárt forgalomról"));
		$months=timesincepublication($t['datepuby'],$t['datepubm']);
		$quarters=floor($months/3);
		formTableRow(array("Eddig eltelt idő:","<b>$months</b> teljes hónap / $quarters teljes negyedév"));
		if ($contracttype==1) {$expected=$months*$t['quarter']/3;}
		if ($contracttype==2) {$expected=$quarters*$t['quarter'];}
		if ($contracttype==3 and $months<6) {$expected=0;}
		if ($contracttype==3 and $months>=6) {$expected=$quarters*$t['quarter'];}
		if ($contracttype==4 and $months<6) {$expected=$t['contracted']*.3;}
		if ($contracttype==4 and $months>=6) {$expected=$t['contracted']*.6;} 
		if ($contracttype==4 and $months>=12) {$expected=$t['contracted'];}
		if ($contracttype==5 and $months<6) {$expected=0;}
		if ($contracttype==5 and $months>=6) {$expected=$t['contracted']*.5;} 
		if ($contracttype==5 and $months>=12) {$expected=$t['contracted'];}
		formTableRow(array("Eddigi elvárt forgalom","<b>$expected</b> példány"));
		}
	print "</table><hr/>";
	
	# FOGYÁSI
	$letter="\nAz alábbiakban küldjük a könyve eddigi forgalmával kapcsolatos adatokat. Az adatok a kiadói eladások esetén naprakészek, a bizományosi forgalom esetén pedig a kereskedők által leadott utolsó fogyási jelentésekben (általában az előző hónap utolsó napjáig tartó fogyás) közölteket tartalmazzák.\n\n".
		"SZERZŐ: ".$t['author']."\n".
		"CÍM: ".$t['title']."\n".
		"KÖNYVÁR: ".$t['price']." Ft\n".
		"WEBOLDAL: www.adlibrum.hu/".$t['link_website']."\n".
		"WEBBOLT: ".$t['link_webshop']."\n\n";
	# levélformában
	$t=inventorySum($db,$idbook,"0");
	print "<table cellspacing='8'>
			<p>".$t['author_email']."</p>
			<h3>Kedves ".$t['author']."!	</h3>
			<p><i>Az alábbiakban küldjük a könyve eddigi forgalmával kapcsolatos adatokat.</i></p>";
	formTableRow(array("Sorszám:","$idbook"));
	formTableRow(array("Szerző:","<b>".$t['author']."</b>"));
	formTableRow(array("Cím:","<font size='+1'><em>".$t['title']."</em></font>"));
	formTableRow(array("Könyvár:",$t['price']." Ft"));

	#formTableRow(array(""));
	formTableRow(array("<strong>Forgalom</strong>"));
	formTableRow(array("Webboltból eladott könyvek száma: ",$t['soldweb'].
		" példány, ebből kifizetve: ".$t['soldwebpaid']." példány"));
	formTableRow(array("Viszonteladón keresztül eladott könyvek száma: ",$t['soldreseller'].
		" példány, ebből kifizetve: ".$t['soldresellerpaid']." példány"));
	$letter .= "FORGALOM\n".
		"A kiadóból (shop.adlibrum.hu) eladott könyvek száma:\n\t".$t['soldweb'].
		" példány, amiből a megrendelők már kifizettek ".$t['soldwebpaid']." példányt.\n".
		"Viszonteladón keresztül eladott könyvek száma:\n\t".$t['soldreseller'].
		" példány, amiből a kereskedők már kifizettek ".$t['soldresellerpaid']." példányt.\n";
	if ($t['sponsor']==1 or $t['sponsor']==4) {
		formTableRow(array("Szerzőnek: ",$t['soldauthor']." példány"));
		formTableRow(array("Egyéb (köteles-, marketing-, tiszteletpéldányok): ",($t['freecopy']+$t['tolibraries'])." példány"));
		formTableRow(array("Eddigi forgalom","<b>".$t['totalsold']."</b> példány"));
		$letter .= "Szerzőnek:\n\t".$t['soldauthor']." példány\n".
			"Egyéb (köteles-, marketing-, tiszteletpéldányok):\n\t".($t['freecopy']+$t['tolibraries'])." példány\n".
			"Eddigi teljes forgalom:\n\t".$t['totalsold']." példány\n\n";
		} else {
		formTableRow(array("Szerzőnek: ",$t['soldauthor']." példány, ebből kifizetve: ".$t['soldauthorpaid']." példány"));
		formTableRow(array("Egyéb (köteles-, marketing-, tiszteletpéldányok): ",($t['freecopy']+$t['tolibraries'])." példány"));
		formTableRow(array("Eddigi forgalom","<b>".$t['totalsold']."</b> példány (ebből kifizetve ".$t['totalsoldpaid']." példány)"));
		$letter .= "Szerzőnek:\n\t".$t['soldauthor']." példány, amiből már kifizetve ".$t['soldauthorpaid']." példány\n".
			"Egyéb (köteles-, marketing-, tiszteletpéldányok):\n\t".($t['freecopy']+$t['tolibraries'])." példány\n".
			"Eddigi teljes forgalom:\n\t".$t['totalsold']." példány (ebből a kiadónak már kifizetve ".$t['totalsoldpaid']." példány)\n\n";
		}

	if ($t['sponsor']==1 or $t['sponsor']==4) {
		formTableRow(array("<strong>Bizományosi részesedés</strong>","<em>(áfa nélküli összegek)</em>"));
		formTableRow(array("Webboltból eladott könyvek: ",round($t['royaltywebshopsumpaid']).
			" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)"));
		formTableRow(array("Viszonteladón keresztül eladott könyvek: ",
			round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)"));
		formTableRow(array("Összes részesedés: ","$royalty Ft (várhatóan: $royaltyexpected Ft)"));
		formTableRow(array("Kifizetett/levont részesedés: ",$s['royaltypaid']." Ft"));
		formTableRow(array("Összegyűlt részesedés: ","<strong>$royaltyremained Ft</strong> (várhatóan: $royaltyremainedexpected Ft)"));
		$letter .= "BIZOMÁNYOSI RÉSZESEDÉS (áfa nélküli összegek)\n".
		"A kiadóból eladott könyvek:\n\t".round($t['royaltywebshopsumpaid']).
			" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)\n".
		"A viszonteladón keresztül eladott könyvek:\n\t".
			round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)\n".
		"Összes részesedés:\n\t$royalty Ft (várhatóan: $royaltyexpected Ft)\n".
		"Eddig kifizetett/levont részesedés:\n\t".$s['royaltypaid']." Ft\n".
		"Összegyűlt részesedés:\n\t$royaltyremained Ft (várhatóan: $royaltyremainedexpected Ft)\n";
	} else {
		formTableRow(array("<strong>Jogdíj</strong>","<em>(áfa nélküli és adózás előtti összegek)</em>"));
		formTableRow(array("Webboltból eladott könyvek jogdíja: ",round($t['royaltywebshopsumpaid']).
			" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)"));
		formTableRow(array("Viszonteladón keresztül eladott könyvek jogdíja: ",
			round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)"));
		$royalty=$t['royaltyresellersumpaid']+$t['royaltywebshopsumpaid'];
		$royaltyexpected=$t['royaltyresellersum']+$t['royaltywebshopsum'];
		formTableRow(array("Összes jogdíj: ","$royalty Ft (várhatóan: $royaltyexpected Ft)"));
		formTableRow(array("Kifizetett/levont jogdíj: ",$s['royaltypaid']." Ft"));
		$royaltyremained=$royalty-$s['royaltypaid']; 
		$royaltyremainedexpected=$royaltyexpected-$s['royaltypaid']; 
		formTableRow(array("Összegyűlt jogdíj: ","<strong>$royaltyremained Ft</strong> (várhatóan: $royaltyremainedexpected Ft)"));
		$letter .= "JOGDÍJ (áfa nélküli és adózás előtti összegek)\n".
		"A kiadóból eladott könyvek:\n\t".round($t['royaltywebshopsumpaid']).
			" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)\n".
		"A viszonteladón keresztül eladott könyvek:\n\t".
			round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)\n".
		"Eddigi összes jogdíjjogosultság:\n\t$royalty Ft (várhatóan: $royaltyexpected Ft)\n".
		"Eddig kifizetett/levont jogdíj:\n\t".$s['royaltypaid']." Ft\n".
		"Összegyűlt jogdíj:\n\t$royaltyremained Ft (várhatóan: $royaltyremainedexpected Ft)\n";
	}	
	if ($t['sponsor'] == 2) {
		formTableRow(array("<strong>Elvárt forgalom</strong>","<em></em>"));
		formTableRow(array("Vállalt forgalom","<b>".$t['contracted']."</b> példány"));
		formTableRow(array("Szerződéstípus",bookParameters("contracttype",$contracttype)." elszámolás az elvárt forgalomról"));
		formTableRow(array("Eddig eltelt idő:","<b>$months</b> teljes hónap / <b>$quarters</b> teljes negyedév"));
		if ($expected>$t['contracted']) {$expected=$t['contracted'];}
		formTableRow(array("Eddigi elvárt forgalom:","<b>$expected</b> példány"));
		if ($t['datepuby']<2016) {$sofar=$t['totalsold'];} else {$sofar=$t['soldweb']+$t['soldreseller']+$t['soldauthor'];}
		formTableRow(array("Eddigi tényleges forgalom:","<b>$sofar</b> példány"));
		$expectedpurchase=$expected-$sofar;
		if ($expectedpurchase>0) {
				$ep="$expectedpurchase példány";
				$expectedpurchaseprice=$expectedpurchase*$t['price']*.5;
				$epp="$expectedpurchaseprice Ft ($expectedpurchase pld. x ".$t['price']." Ft x 50%)";
				if ($royaltyremainedexpected<0) {
					$tobepaid=$expectedpurchaseprice;
					$eppp="$tobepaid Ft"; } 
				else {
					$tobepaid=$expectedpurchaseprice-$royaltyremainedexpected;			
					$eppp="$tobepaid Ft ($expectedpurchaseprice Ft - $royaltyremainedexpected Ft)";}
			} else {
				$ep="NINCS";
				$epp="NINCS";
				$eppp="NINCS";
				}
		formTableRow(array("Az elvárt forgalomhoz szükséges szerzői vásárlás:",$ep));
		formTableRow(array("Az elvárt forgalomhoz szükséges szerzői vásárlás teljes összege:",$epp));
		formTableRow(array("A szerzői jogdíjról való lemondás esetén a tartozás:",$eppp));
		$letter .= "\nELVÁRT FORGALOM\n".
		"Vállalt forgalom\n\t".$t['contracted']." példány\n".
		"Szerződéstípus\n\t".bookParameters("contracttype",$contracttype)." elszámolás az elvárt forgalomról\n".
		"Eddig eltelt idő:\n\t$months teljes hónap / $quarters teljes negyedév\n".
		"Eddigi elvárt forgalom:\n\t$expected példány\n".
		"Az elvárt forgalomhoz szükséges szerzői vásárlás:\n\t$ep\n".
		"Az elvárt forgalomhoz szükséges szerzői vásárlás teljes összege:\n\t$epp\n".
		"A szerzői jogdíjról való lemondás esetén a tartozás:\n\t$eppp\n";
	}
	print "</table>";
	$letter .= "\nMEGJEGYZÉSEK\n";
	if ($expectedpurchase>0) {
		$letter .= "\n1. Kérjük minél hamarabb jelezzen vissza, hogy a példányokért bejön vagy kipostázzuk!\n".
			"2. Amennyiben a forgalom alakulása alapján úgy ítéli meg, hogy elővásárlással akarja elkerülni az elvárt forgalomhoz szükséges jövőbeni vásárlásokat vagy egy lépésben le szeretné zárni a kötelezettségeit, kérjen tőlünk ajánlatot!\n".
			"3. Ha a szerző az összegyűlt jogdíjáról lemond, az elvárt forgalomhoz szükséges szerzői vásárlás összege a jogdíjnak megfelelő összeggel csökkenthető. Ebben az esetben jogdíjba a kiadónak még ki sem fizetett értékesítéseket is beleszámoljuk, vagyis a maximális lehetséges jogdíjat. Egyes esetekben ez szerződésmódosítást igényelhet, amiről külön értesítjük.\n".
			"4. A kiadás hónapjára nem számolunk elvárt forgalmat, csak az azt követő teljes hónaptól. Csak teljes periódusokra (hónapok vagy negyedévek) számoljuk a forgalmi elvárást.\n".
			 "5. A jogdíjból lehetnek előre egyeztetett levonások (pl. postaköltség, korrektúra költsége, könyvheti reklám).\n";
		} else {
			if ($t['sponsor'] == 2) {$letter .= "Önnek nincs az elvárt forgalommal kapcsolatos kötelezettsége. A jogdíjból lehetnek előre egyeztetett levonások (pl. postaköltség, korrektúra költsége, könyvheti reklám).\n";}
			if ($t['sponsor'] == 1) {$letter .="A példányok az Ön tulajdonát képezik, az Ad Librumnál levő példányok bizományosi kezelésben vannak. A fenti adatok az Ad Librum kezelésébe vett példányok forgalmáról szólnak, előre jelezve a kereskedők által már lejelentett, de még ki nem fizetett példányokat is. A ténylegesen befolyt részesedését ($royaltyremained forintot) kérésére egy megállapodás keretében fizetjük ki, amennyiben a szerződési feltételek lehetővé teszik (függhet pl. a kiadás kezdetétől eltelt időtől és vagy meghatározott minimumösszeg elérésétől). Ha a kiadási szerződést  cég vagy vállalkozó kötötte, (5%-os áfa hozzáadásával) számlát várunk.\n";}
		}
	#print "<p><em>>>>A kiadó 2010. augusztus 2. és 19. között zárva tart. Ezért legközelebb fogyási jelentést szeptemberben küldünk.<<<</em></p>";

	$letter .= "\n\nKönyve forgalmával kapcsolatos kérdésekkel keresse kereskedelmi vezetőnket, Dr. Markosné Virág Klárát (markosne.klara@adlibrum.hu)!\n\n".
		"---------------------\nAd Librum Kft.\n1107 Budapest, Mázsa tér 2-6.\n".
		"Cégjegyzékszám: 01-09-888596\nAdószám: 14093818-2-42\nBankszámlaszám: 10400157-00020656-00000005\nwww.adlibrum.hu";
	print "
		<br/><p>
		<form action='$fajlnev' method='post' >
			<input type='hidden' name='task' value='statReportLetter' />
			<input type='hidden' name='idbook' value='$idbook' />
			<input type='hidden' name='letter' value='$letter' />
			<input type='hidden' name='emailaddress' value='".$t['author_email']."' />
			<input type='hidden' name='addressee' value='".$t['author']."' />
			<input type='submit' value='Értesítő levél küldése' />
		</form>
		</p>";
}

function statReportLetter() {
	print "<h2>FOGYÁSI JELENTÉS KÜLDÉSE</h2>";
	$emailaddress=$_POST['emailaddress'];
	$addressee=$_POST['addressee'];
	$idbook=$_POST['idbook'];
	$copy1="markosne.klara@adlibrum.hu";
	$copy2="info@adlibrum.hu";
	$letter=$_POST['letter'];
	print "<form action='$fajlnev' method='post'>";
	print "<p>Címzett: <input type='text' name='emailaddress' size='30' value='$emailaddress'> (Csak kivételes esetben javítandó!)<p/>";
	print "<p>Másolat megy a <em>$copy1</em> és az <em>$copy2</em> email címekre.<p/>";
	print "<p>Megszólitás (Egyes álneves szerzők esetén javítandó!):</p>
			<p><em>Tisztelt <input type='text' name='addressee' size='25' value='$addressee'>!</em><p/>";
	print "A levél szövege:<br /><textarea name='letter' cols='100' rows='40'>".$letter."</textarea><br />";
	print "<input type='hidden' name='idbook' value='$idbook' />";
	print "<input type='hidden' name='task' value='statReportLetterSend' />";
	print "<input type='submit' value='Értesítő levél küldése' /> (nem visszavonható lépés!)";
	print "</form>";
	}

function statReportLetterSend() {
	require_once "Mail.php";
	print "Levelet küldünk\n";
	$idbook=$_POST['idbook'];
	$to = $_POST['emailaddress'].",markosne.klara@adlibrum.hu,info@adlibrum.hu";
	$from = "info@adlibrum.hu";
	global $datem;
	$subject = "Ad Librum fogyási jelentés 2010. ".bookParameters("months",$datem)." [#".$idbook."]";
	$body = "Ha rosszul latja a levelben az ekezeteket, valassza az Unicode (UTF-8) karakterkodolast!\n\n".
		"Tisztelt ".$_POST['addressee']."!\n\n".$_POST['letter'];
	$host = "mail.adlibrum.eu:26";
	$username = "info+adlibrum.eu";
	$password = "alex.Is";
	$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
	$smtp = Mail::factory('smtp',
	array ('host' => $host,
			'auth' => true,
			'username' => $username,
			'password' => $password));
	$mail = $smtp->send($to, $headers, $body);
	if (PEAR::isError($mail)) {
		echo("<p>HIBA: " . $mail->getMessage() . "</p>");
	} else {
		echo("<p>Az üzenet sikeresen elküldve a $to címre!</p>");
	}
}


function statRoyalty($db) {
	print "<table>";
	formTableHead(array("Dátum","Könyvcím","Webboltos<br/>jogdíj","Viszonteladós<br/>jogdíj","Összes<br/>jogdíj","Kifizetett<br/>jogdíj","Jogdíj-<br/>tartozás"));
	$sql="select * from books where ( (sponsor=3 or sponsor=5) and status=3 and reported=1) order by datepuby desc,datepubm desc,datepubd desc ";
	$booklist=$db->query($sql)
		 or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$totalnumber=0;
	while ($sor=$booklist->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		$t=inventorySum($db,$idbook,"0"); #összesítések a forgalomról az inventory táblából
		$s=costsData($db,$idbook); #kiadási-bevételi összesítések a costs táblából
		$book=$sor['author'].": ".strtok($sor['title']," ")." ".strtok(" ");
		$netto=100/105;
		$months=timesincepublication($t['datepuby'],$t['datepubm']);
		$royaltyremainedexpected=$t['royaltyresellersum']+$t['royaltywebshopsum']-$s['royaltypaid'];
		formTableRow(array("<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>".$sor['datepuby']."-".$sor['datepubm']."</a>",
			"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
			round($t['royaltywebshopsum'])." Ft",round($t['royaltyresellersum'])." Ft",round($t['royaltywebshopsum']+$t['royaltyresellersum'])." Ft",
			round($s['royaltypaid'])." Ft",round($royaltyremainedexpected)." Ft",
			)
			,1);
		$totalnumber++;
		$totalroyaltywebshopsum+=$t['royaltywebshopsum'];
		$royaltyresellersum+=$t['royaltyresellersum'];
		$totalroyaltypaid+=$s['royaltypaid'];
		$totalroyaltyremained+=$royaltyremainedexpected;
	}
	if ($_GET['q']==11) {
		formTableHead(array("Összesen",$totalnumber." cím",
			round($totalroyaltywebshopsum)." Ft",round($royaltyresellersum)." Ft",round($totalroyaltywebshopsum+$royaltyresellersum)." Ft",
			round($totalroyaltypaid)." Ft",$totalroyaltyremained." Ft"));
		}
	print "</table>";
}

function statFree($db) {
	print "<table>";
	formTableHead(array("Dátum","Könyvcím","Szerződés<br/>típusa","Vállalt<br/>példány",
		"Eltelt<br/>idő","Elvárt<br/>vásárlás","Elvárt<br/>vásárlás",
		"Jogdíj","Jogdíj-<br/>levonással"));
	$sql="select * from books where (sponsor=2 and status=3 and reported=1) order by datepuby desc,datepubm desc,datepubd desc ";
	$booklist=$db->query($sql)
		 or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$totalnumber=0;
	while ($sor=$booklist->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		$t=inventorySum($db,$idbook,"0"); #összesítések a forgalomról az inventory táblából
		$s=costsData($db,$idbook); #kiadási-bevételi összesítések a costs táblából
		$contracttype=$sor['contracttype'];
		$book=$sor['author'].": ".strtok($sor['title']," ")." ".strtok(" ");
		$netto=100/105;
		$months=timesincepublication($t['datepuby'],$t['datepubm']);
		$quarters=floor($months/3);
		if ($contracttype==1) {$expected=$months*$t['quarter']/3;}
		if ($contracttype==2) {$expected=$quarters*$t['quarter'];}
		if ($contracttype==3 and $months<6) {$expected=0;}
		if ($contracttype==3 and $months>=6) {$expected=$quarters*$t['quarter'];}
		if ($contracttype==4 and $months<6) {$expected=$t['contracted']*.3;}
		if ($contracttype==4 and $months>=6) {$expected=$t['contracted']*.6;} 
		if ($contracttype==4 and $months>=12) {$expected=$t['contracted'];}
		if ($contracttype==5 and $months<6) {$expected=0;}
		if ($contracttype==5 and $months>=6) {$expected=$t['contracted']*.5;} 
		if ($contracttype==5 and $months>=12) {$expected=$t['contracted'];}
		$royaltyremainedexpected=$t['royaltyresellersum']+$t['royaltywebshopsum']-$s['royaltypaid'];
		$expectedpurchase=$expected-$t['totalsold'];
		if ($expectedpurchase<0) {
			$expectedpurchase=0;
			$expectedpurchaseprice=0;
			$tobepaid=0;
		} else {
			$expectedpurchaseprice=$expectedpurchase*$t['price']/2;
			$tobepaid=$expectedpurchaseprice-$royaltyremainedexpected;
			}
		$contracted=$sor['contracted']." pld.";			
		formTableRow(array("<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>".$sor['datepuby']."-".$sor['datepubm']."</a>",
			"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
			$contracttype,$contracted,$months." hó",
			$expectedpurchase." pld.",$expectedpurchaseprice." Ft",
			round($royaltyremainedexpected)." Ft",$tobepaid." Ft"
			)
			,1);
		$totalnumber++;
		$totalcontracted+=$t['contracted'];
		$totalexpected+=$expectedpurchase;
		$totaldebt+=$expectedpurchaseprice;
		$totalroyalty+=$royaltyremainedexpected;
		$totaltobepaid+=$tobepaid;
	}
	if ($_GET['q']==11) {
		formTableHead(array("Összesen",$totalnumber." cím","",
			$totalcontracted." pld.","",$totalexpected." pld.",$totaldebt." Ft",$totalroyalty." Ft",$totaltobepaid." Ft"));
		}
	print "</table>";
}

function statPrepaid($db) {
	print "<table>";
	formTableHead(array("Dátum","Könyvcím","Webboltos<br/>részesedés","Viszonteladós<br/>részesedés",
		"Webboltos<br/>rész. Ft","Viszonteladói<br/>rész. Ft","Eddigi<br/>kifizetés","Összesen"));
	$sql="select * from books where (sponsor=1 and status=3 and reported=1) order by datepuby desc,datepubm desc,datepubd desc ";
	$booklist=$db->query($sql)
		 or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$totalnumber=0; 
	while ($sor=$booklist->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		$t=inventorySum($db,$idbook,"0"); #összesítések a forgalomról az inventory táblából
		$s=costsData($db,$idbook); #kiadási-bevételi összesítések a costs táblából
		$contracttype=$sor['contracttype'];
		$book=$sor['author'].": ".strtok($sor['title']," ")." ".strtok(" ");
		$netto=100/105;
		$months=timesincepublication($t['datepuby'],$t['datepubm']);
		$royaltyremainedexpected=$t['royaltyresellersum']+$t['royaltywebshopsum']-$s['royaltypaid'];
		formTableRow(array("<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>".$sor['datepuby']."-".$sor['datepubm']."</a>",
			"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
			$sor['royaltywebshop']." %",$sor['royaltyreseller']." %",
			$t['royaltywebshopsum']." Ft",$t['royaltyresellersum']." Ft",
			$s['royaltypaid']." Ft",$royaltyremainedexpected." Ft"
			)
			,1);
		$totalnumber++;
		$totaltobepaid+=round($royaltyremainedexpected);
		$totalroyalty+=round($s['royaltypaid']);
	}
	if ($_GET['q']==11) {
		formTableHead(array("Összesen",$totalnumber." cím",
			"","","","",$totalroyalty." Ft",$totaltobepaid." Ft"));
		}
	print "</table>";
}

function costsList($db) { #31
	print "<a href='$fajlnev?feladat=31&sponsor=3'>Saját kiadás</a> <a href='$fajlnev?feladat=31&sponsor=1'>Előfinanszírozott kiadás</a> 
		<a href='$fajlnev?feladat=31&sponsor=5'>POD kiadás</a> <a href='$fajlnev?feladat=31&sponsor=2'>Ingyenes kiadás</a></p>
		<a href='$fajlnev?feladat=31&sponsor=4'>Bérmunka</a> <a href='$fajlnev?feladat=31&sponsor=0'>Összesítés</a></p>";
	$sponsor=$_GET['sponsor'];
	if ($sponsor=="") {$sponsor=5;} # alapeset a POD kiadás
	if ($sponsor==0) {
		$eredmeny=sqlquery($db,"select * from books where (status=3 or status=2) order by datepuby desc,datepubm desc,datepubd desc");
	} else {
		$eredmeny=sqlquery($db,"select * from books where (sponsor=$sponsor and (status=3 or status=2)) order by datepuby desc,datepubm desc,datepubd desc");
		}
	//$sql="select * from books where (sponsor=$sponsor) order by datepuby desc,datepubm desc,datepubd desc ";
	//$eredmeny=$db->query($sql)
		// or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	$totalfullincome=0;
	$totalfullcost=0;
	$totalfullincomeexpected=0;
	$totalfullcostexpected=0;
	$totaltobepaidup=0;
	$totaltotalprofit=0;
	$totalownwork=0;
	$totalnum=0;
	$typefullincome[1]=0;
	$typefullcost[1]=0;
	$typeownwork[1]=0;
	$totalprintrun=0;
	$timenum['2008']['01']=0;
	print "<table>";
	if ($sponsor==2) {#ingyenes kiadás esetén több oszlop
		formTableHead(array("Dátum","Könyvcím","Szerződés<br/>típusa",
			"Példány-<br/>szám","Vállalt<br/>példány","Saját munka",
			"Eddigi bevétel","Eddigi kiadás","Eddigi egyenleg","Saját munkával",
			"Várt bevétel","Várt kiadás","Várt egyenleg","Saját munkával",
			"Elvárt vásárlás","Elvárt vásárlás",
			"Teljes haszon","Saját munkával"));
		} else {#minden más kiadási mód
			formTableHead(array("Dátum","Könyvcím",
			"Példány-<br/>szám","Saját munka",
			"Eddigi bevétel","Eddigi kiadás","Eddigi egyenleg","Saját munkával",
			"Várt bevétel","Várt kiadás","Várt egyenleg","Saját munkával",
			));
		}
	while ($sor=$eredmeny->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		$t=inventorySum($db,$idbook); #összesítések a forgalomról az inventory táblából
		$s=costsData($db,$idbook); #kiadási-bevételi összesítések a costs táblából
		$contracttype=$sor['contracttype'];
		$netto=100/105;

		$book=$sor['author'].": ".strtok($sor['title']," ")." ".strtok(" ");
		$price=$t['price'];
		$pages=$sor['pages'];
		$pubyear=$sor['datepuby'];
		$pubmonth=$sor['datepubm'];

		$fullincome=($t['soldwebsumpaid']*$netto)+($t['soldresellersumpaid']*$netto)+($t['soldauthorsumpaid']*$netto)+$s['paidincome'];
		$fullcost=$s['paidcost']+($t['royaltywebshopsumpaid']+$t['royaltyresellersumpaid'])-$s['royaltypaid'];
		$fullincomeexpected=($t['soldwebsum']*$netto)+($t['soldresellersum']*$netto)+($t['soldauthorsum']*$netto)+$s['expectedincome'];
		$fullcostexpected=$s['expectedcost']+($t['royaltywebshopsum']+$t['royaltyresellersum'])-$s['royaltypaid'];
		
		#összesítések
		$typenum[$contracttype] = $typenum[$contracttype] + 1;
		$totalnum = $totalnum + 1;
		$totalprintrun = $totalprintrun + $t['fromprinter'];
		
		#összesítés szerződéstípus szerint
		$typefullincome[$contracttype]=$typefullincome[$contracttype]+$fullincome;
		$typefullcost[$contracttype]=$typefullcost[$contracttype]+$fullcost;
		$typefullincomeexpected[$contracttype]=$typefullincomeexpected[$contracttype]+$fullincomeexpected;
		$typefullcostexpected[$contracttype]=$typefullcostexpected[$contracttype]+$fullcostexpected;
		$typeownwork[$contracttype]=$typeownwork[$contracttype]+$s['expectedinternalcost'];
				
		$totalfullincome=$totalfullincome+$fullincome;
		$totalfullcost=$totalfullcost+$fullcost;
		$totalfullincomeexpected=$totalfullincomeexpected+$fullincomeexpected;
		$totalfullcostexpected=$totalfullcostexpected+$fullcostexpected;
		$totalownwork = $totalownwork + $s['expectedinternalcost'];
		if ($t['contracted'] < $t['totalsold']) {
			$tobesoldtoauthor=0;
			$tobepaidup=0;}
		else {
			$tobesoldtoauthor=($t['contracted'] - $t['totalsold']) * .5*$t['price']*$netto; //az elvárt példányszámból megmaradt példányok nettó ára
			$tobepaidup=$t['contracted'] - $t['totalsold'];
			$totaltobepaidup = $totaltobepaidup + $tobesoldtoauthor;
			$typetobepaidup[$contracttype] = $typetobepaidup[$contracttype] + $tobesoldtoauthor;
		}
		$totalprofit = $fullincomeexpected - $fullcostexpected + $tobesoldtoauthor;
		$totaltotalprofit = $totaltotalprofit + $totalprofit;
		$typetotalprofit[$contracttype] = $typetotalprofit[$contracttype] + $totalprofit;
		
		#összesítés kiadási időpont szerint
		
		$timefullincome[$pubyear][$pubyear]+=$fullincome;
		$timefullcost[$pubyear][$pubyear]+=$fullcost;
		$timefullincomeexpected[$pubyear][$pubyear]+=$fullincomeexpected;
		$timefullcostexpected[$pubyear][$pubyear]+=$fullcostexpected;
		$timeownwork[$pubyear][$pubyear]+=$s['expectedinternalcost'];
		$timetotalprofit[$pubyear][$pubyear]+=$totalprofit;
		$timenum[$pubyear][$pubyear]++;
		$timeprintrun[$pubyear][$pubyear]+=$t['fromprinter'];
		
		$timefullincome[$pubyear][$pubmonth]+=$fullincome;
		$timefullcost[$pubyear][$pubmonth]+=$fullcost;
		$timefullincomeexpected[$pubyear][$pubmonth]+=$fullincomeexpected;
		$timefullcostexpected[$pubyear][$pubmonth]+=$fullcostexpected;
		$timeownwork[$pubyear][$pubmonth]+=$s['expectedinternalcost'];
		$timetotalprofit[$pubyear][$pubmonth]+=$totalprofit;
		$timenum[$pubyear][$pubmonth]++;
		$timeprintrun[$pubyear][$pubmonth]+=$t['fromprinter'];
		
		if ($t['fromprinter']=="") {$t['fromprinter']="--";} #ha még nem jött ki a nyomdából a könyv
		
		# link létrehozása
		$sor['idtransaction']="<a href='$fajlnev?feladat=32&idtransaction="
			.$sor['idtransaction']."' >".$sor['idtransaction']."</a>";
		# kiadás alatt jelzés + átlinkelési lehetőség a könyv adatainak szerkesztéséhez
		$st1="<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>";
		# táblázat kiíratása
		if ($sponsor==2) {
			formTableRow(array("<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>$pubyear-$pubmonth</a>",
				"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
				"<a href='$fajlnev?feladat=32&q=11&idbook=$idbook' title='Kiadás-bevételi összesítések'>".$contracttype."</a>",
				$sor['printrun']." pld.",$t['fromprinter']." pld.",round($s['expectedinternalcost']/1000)." eFt",
				round($fullincome/1000)." eFt",round($fullcost/1000)." eFt","<em>".round(($fullincome-$fullcost)/1000)." eFt</em>",
				"<strong>".round(($fullincome-$fullcost+$s['expectedinternalcost'])/1000)." eFt</strong>",
				round($fullincomeexpected/1000)." eFt",round($fullcostexpected/1000)." eFt","<em>".round(($fullincomeexpected-$fullcostexpected)/1000)." eFt</em>",
				"<strong>".round(($fullincomeexpected-$fullcostexpected+$s['expectedinternalcost'])/1000)." eFt</strong>",
				$tobepaidup." pld.",round($tobesoldtoauthor/1000)." eFt","<em>".round($totalprofit/1000)." eFt</em>",
				"<strong>".round(($totalprofit+$s['expectedinternalcost'])/1000)." eFt</strong>"
				)
				,1);
			} 
		if ($sponsor==1 or $sponsor>2) {
			formTableRow(array("<a href='$fajlnev?feladat=26&q=11&idbook=$idbook' title='Leltári mozgások'>$pubyear-$pubmonth</a>",
				"<a href='$fajlnev?feladat=13&idbook=$idbook&q=11' title='Könyvadatok szerkesztése'>".$book."</a>",
				"<a href='$fajlnev?feladat=32&q=11&idbook=$idbook' title='Kiadás-bevételi összesítések'>".$t['fromprinter']."</a>",
				round($s['expectedinternalcost']/1000)." eFt",
				round($fullincome/1000)." eFt",round($fullcost/1000)." eFt","<em>".round(($fullincome-$fullcost)/1000)." eFt</em>",
				"<strong>".round(($fullincome-$fullcost+$s['expectedinternalcost'])/1000)." eFt</strong>",
				round($fullincomeexpected/1000)." eFt",round($fullcostexpected/1000)." eFt","<em>".round(($fullincomeexpected-$fullcostexpected)/1000)." eFt</em>",
				"<strong>".round(($fullincomeexpected-$fullcostexpected+$s['expectedinternalcost'])/1000)." eFt</strong>"
				)
				,1);
			}
		# teljes lista esetén csak összesítések
		if ($sponsor==0) {
			
		}
	}
	
	#összesítés
	formTableRow(array(""));
	if ($sponsor==2) {
		formTableRow(array("<strong>ÖSSZESEN</strong>",$totalnum." szerződés","",$totalprintrun." pld.",$totalcontracted." pld.",
			round($totalownwork/1000)." eFt",
			round($totalfullincome/1000)." eFt",round($totalfullcost/1000)." eFt","<em>".round(($totalfullincome-$totalfullcost)/1000)." eFt</em>",
			"<strong>".round(($totalfullincome-$totalfullcost+$totalownwork)/1000)." eFt</strong>",
			round($totalfullincomeexpected/1000)." eFt",round($totalfullcostexpected/1000)." eFt",
			"<em>".round(($totalfullincomeexpected-$totalfullcostexpected)/1000)." eFt</em>",
			"<strong>".round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/1000)." eFt</strong>",
			"",round($totaltobepaidup/1000)." e Ft","<em>".round($totaltotalprofit/1000)." eFt</em>","<strong>".round(($totaltotalprofit+$totalownwork)/1000)." eFt</strong>")
			,1);
		} else {
			formTableRow(array("<strong>ÖSSZESEN</strong>",$totalnum." szerződés",$totalprintrun." pld.",
			round($totalownwork/1000)." eFt",
			round($totalfullincome/1000)." eFt",round($totalfullcost/1000)." eFt","<em>".round(($totalfullincome-$totalfullcost)/1000)." eFt</em>",
			"<strong>".round(($totalfullincome-$totalfullcost+$totalownwork)/1000)." eFt</strong>",
			round($totalfullincomeexpected/1000)." eFt",round($totalfullcostexpected/1000)." eFt","<em>".round(($totalfullincomeexpected-$totalfullcostexpected)/1000)." eFt</em>",
			"<strong>".round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/1000)." eFt</strong>",
			)
			,1);
		}
	if ($sponsor==0) {
	        global $datem;
		$lifetime=39+$datem;
		$activetime=timesincepublication(2008,4);
		$overhead2008=15*500;
		$overhead2009=12*600;
		$overhead2010=6*700+4*600+2*300;
		$overhead2011=7*160+5*110;
		$overhead2012=9*160+4*70; #volt egy hónap, amikor a régi még fizetve volt és költözési költség is felmerült
		$overhead2013=12*70; #az irodabérlet nem számít költségnek
		$overhead2014=12*70; #az irodabérlet nem számít költségnek
		$overhead2015=12*150; #az irodabérlet nem számít költségnek, de Julika igen
		$overhead2016=12*350; #az irodabérlet nem számít költségnek, de Julika, a hirdetések, Balázs fizetése és a Guru cikkek igen
		$overhead2017=$datem*400; #az irodabérlet nem számít költségnek, de Julika, a hirdetések, Balázs fizetése és a Guru cikkek igen
		$overheadtotal=$overhead2008+$overhead2009+$overhead2010+$overhead2011+$overhead2012+$overhead2013+$overhead2014+$overhead2015+$overhead2016+$overhead2017;
		$overhead=round($overheadtotal/$lifetime); # havi átlagrezsi ezer forintban 2007-től ez évig
		formTableRow(array("<strong>Élettartam rezsi levonásával (várható nettó) </strong>","","",
			"",
			"","","<em>".(round(($totalfullincome-$totalfullcost)/1000)-$overheadtotal)." eFt</em>",
			"<strong>".(round(($totalfullincome-$totalfullcost+$totalownwork)/1000)-$overheadtotal)." eFt</strong>",
			"(".(round(($totalfullincome-$totalfullcost+$totalownwork)/1000)-$overheadtotal)*.6.")","",
			"<em>".(round(($totalfullincomeexpected-$totalfullcostexpected)/1000)-$overheadtotal)." eFt</em>",
			"<strong>".(round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/1000)-$overheadtotal)." eFt</strong>",
			)
			,1);
		formTableRow(array("<strong>Élettartam havi átlag</strong>",round($totalnum/$lifetime,1)." szerződés",round($totalprintrun/$lifetime)." pld.",
			round($totalownwork/$lifetime/1000)." eFt",
			round($totalfullincome/$lifetime/1000)." eFt",round($totalfullcost/$lifetime/1000)." eFt",
			"<em>".round(($totalfullincome-$totalfullcost)/$lifetime/1000)." eFt</em>",
			"<strong>".round(($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)." eFt</strong>",
			round($totalfullincomeexpected/$lifetime/1000)." eFt",round($totalfullcostexpected/$lifetime/1000)." eFt",
			"<em>".round(($totalfullincomeexpected-$totalfullcostexpected)/$lifetime/1000)." eFt</em>",
			"<strong>".round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/$lifetime/1000)." eFt</strong>",
			)
			,1);
		formTableRow(array("<strong>Élettartam havi átlag rezsi levonásával</strong>","","",
			"",
			"","","<em>".(round(($totalfullincome-$totalfullcost)/$lifetime/1000)-$overhead)." eFt</em>",
			"<strong>".(round(($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)-$overhead)." eFt</strong>",
			"(".round(((($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)-$overhead)*.6).")","",
			"<em>".(round(($totalfullincomeexpected-$totalfullcostexpected)/$lifetime/1000)-$overhead)." eFt</em>",
			"<strong>".(round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/$lifetime/1000)-$overhead)." eFt</strong>",
			)
			,1);
		$lifetime=$activetime; # hogy ne kelljen mindenütt cserélni
		$overhead=round($overheadtotal/$lifetime); # havi átlagrezsi ezer forintban (2007-2008 + 2009 + 2010 + 2011 + 2012 + 2013 + 2014)
		formTableRow(array("<strong>Aktív időszak összesen</strong>",round($totalnum/$lifetime,1)." szerződés",round($totalprintrun/$lifetime)." pld.",
			round($totalownwork/$lifetime/1000)." eFt",
			round($totalfullincome/$lifetime/1000)." eFt",round($totalfullcost/$lifetime/1000)." eFt","<em>".round(($totalfullincome-$totalfullcost)/$lifetime/1000)." eFt</em>",
			"<strong>".round(($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)." eFt</strong>",
			round($totalfullincomeexpected/$lifetime/1000)." eFt",round($totalfullcostexpected/$lifetime/1000)." eFt",
			"<em>".round(($totalfullincomeexpected-$totalfullcostexpected)/$lifetime/1000)." eFt</em>",
			"<strong>".round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/$lifetime/1000)." eFt</strong>",
			)
			,1);
		formTableRow(array("<strong>Aktív időszak rezsi levonásával</strong>","","",
			"",
			"","","<em>".(round(($totalfullincome-$totalfullcost)/$lifetime/1000)-$overhead)." eFt</em>",
			"<strong>".(round(($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)-$overhead)." eFt</strong>",
			"(".round(((($totalfullincome-$totalfullcost+$totalownwork)/$lifetime/1000)-$overhead)*.6).")","",
			"<em>".(round(($totalfullincomeexpected-$totalfullcostexpected)/$lifetime/1000)-$overhead)." eFt</em>",
			"<strong>".(round(($totalfullincomeexpected-$totalfullcostexpected+$totalownwork)/$lifetime/1000)-$overhead)." eFt</strong>",
			)
			,1);
		}

	# idő szerinti bontás - teljes összesítés
	formTableRow(array(""));
	global $datem;
	#évek szerint
	$years=array("2008","2009","2010","2011","2012","2013","2014","2015","2016","2017");
	foreach ($years as $y) {
		formTableRow(array("<strong>$y</strong>",
			$timenum[$y][$y]." kiadás",
			round($timeprintrun[$y][$y])." pld.",
			round($timeownwork[$y][$y]/1000)." eFt",
			round($timefullincome[$y][$y]/1000)." eFt",
			round($timefullcost[$y][$y]/1000)." eFt",
			"<em>".round(($timefullincome[$y][$y]-$timefullcost[$y][$y])/1000)." eFt</em>",
			"<strong>".round(($timefullincome[$y][$y]-$timefullcost[$y][$y]+$timeownwork[$y][$y])/1000)." eFt</strong>",
			round($timefullincomeexpected[$y][$y]/1000)." eFt",
			round($timefullcostexpected[$y][$y]/1000)." eFt",
			"<em>".round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y])/1000)." eFt</em>",
			"<strong>".round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y]+$timeownwork[$y][$y])/1000)." eFt</strong>",
			));
		if ($sponsor==0) {# havi átlag, csak a teljes összesítésnél
			if ($y==2014) {$nm=$datem+1;} else {$nm=12;}
			formTableRow(array("havonta",
				$timenum[$y][$y]." kiadás",
				round($timeprintrun[$y][$y]/$nm)." pld.",
				round($timeownwork[$y][$y]/1000/$nm)." eFt",
				round($timefullincome[$y][$y]/1000/$nm)." eFt",
				round($timefullcost[$y][$y]/1000/$nm)." eFt",
				"<em>".round(($timefullincome[$y][$y]-$timefullcost[$y][$y])/1000/$nm)." eFt</em>",
				"<strong>".round(($timefullincome[$y][$y]-$timefullcost[$y][$y]+$timeownwork[$y][$y])/1000/$nm)." eFt</strong>",
				round($timefullincomeexpected[$y][$y]/1000/$nm)." eFt",
				round($timefullcostexpected[$y][$y]/1000/$nm)." eFt",
				"<em>".round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y])/1000/$nm)." eFt</em>",
				"<strong>".round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y]+$timeownwork[$y][$y])/1000/$nm)." eFt</strong>",
				));
			if ($y==2008) {$overhead=500;}
			if ($y==2009) {$overhead=round($overhead2009/12);}
			if ($y==2010) {$overhead=round($overhead2010/12);}
			if ($y==2011) {$overhead=round($overhead2011/12);}
			if ($y==2012) {$overhead=round($overhead2012/12);}
			if ($y==2013) {$overhead=round($overhead2013/12);}
			if ($y==2014) {$overhead=round($overhead2014/12);}
			if ($y==2015) {$overhead=round($overhead2015/12);}
			if ($y==2016) {$overhead=round($overhead2016/12);}
			if ($y==2017) {$overhead=round($overhead2017/$datem);}
			formTableRow(array("rezsit levonva",
				"","","","","",
				"<em>".(round(($timefullincome[$y][$y]-$timefullcost[$y][$y])/1000/$nm)-$overhead)." eFt</em>",
				"<strong>".(round(($timefullincome[$y][$y]-$timefullcost[$y][$y]+$timeownwork[$y][$y])/1000/$nm)-$overhead)." eFt</strong>",
				"","",
				"<em>".(round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y])/1000/$nm)-$overhead)." eFt</em>",
				"<strong>".(round(($timefullincomeexpected[$y][$y]-$timefullcostexpected[$y][$y]+$timeownwork[$y][$y])/1000/$nm)-$overhead)." eFt</strong>",
				));
			}
		}
	#hónapos bontás
	formTableRow(array(""));
	$years=array("2008","2009","2010","2011","2012","2013","2014","2015","2016","2017");
	$months=array("1","2","3","4","5","6","7","8","9","10","11","12");
	foreach ($years as $y) {
		foreach ($months as $m) {
		formTableRow(array("<strong>$y-$m</strong>",
			$timenum[$y][$m]." kiadás",
			round($timeprintrun[$y][$m])." pld.",
			round($timeownwork[$y][$m]/1000)." eFt",
			round($timefullincome[$y][$m]/1000)." eFt",
			round($timefullcost[$y][$m]/1000)." eFt",
			"<em>".round(($timefullincome[$y][$m]-$timefullcost[$y][$m])/1000)." eFt</em>",
			"<strong>".round(($timefullincome[$y][$m]-$timefullcost[$y][$m]+$timeownwork[$y][$m])/1000)." eFt</strong>",
			round($timefullincomeexpected[$y][$m]/1000)." eFt",
			round($timefullcostexpected[$y][$m]/1000)." eFt",
			"<em>".round(($timefullincomeexpected[$y][$m]-$timefullcostexpected[$y][$m])/1000)." eFt</em>",
			"<strong>".round(($timefullincomeexpected[$y][$m]-$timefullcostexpected[$y][$m]+$timeownwork[$y][$m])/1000)." eFt</strong>",
			));
			}
		}


	# típus szerinti statisztika
	if ($sponsor==2) {
		formTableRow(array(""));
		$contract[1]="Havi (2008. szept.-okt.)";
		$contract[2]="Negyedévi (2008. okt.-nov.)";
		$contract[3]="Félév+negyedévi (2008.11.23.-12.31.)";
		$contract[4]="Elővásárlás+félévi (2009)";
		$contract=bookParameters("contracttype");
		for ($i=1;$i<=5;$i++) {
			formTableRow(array("<strong>$i.</strong>","<strong>".$contract[$i]."</strong>",$typenum[$i],"szerződés","",round($typeownwork[$i]/1000)." eFt",
				round($typefullincome[$i]/1000)." eFt",round($typefullcost[$i]/1000)." eFt","<strong>".round(($typefullincome[$i]-$typefullcost[$i])/1000)." eFt</strong>",
				"<em>".round(($typefullincome[$i]-$typefullcost[$i]+$typeownwork[$i])/1000)." eFt</em>",
				round($typefullincomeexpected[$i]/1000)." eFt",round($typefullcostexpected[$i]/1000)." eFt",
				"<strong>".round(($typefullincomeexpected[$i]-$typefullcostexpected[$i])/1000)." eFt</strong>",
				"<em>".round(($typefullincomeexpected[$i]-$typefullcostexpected[$i]+$typeownwork[$i])/1000)." eFt</em>","",
				round($typetobepaidup[$i]/1000),"<strong>".round($typetotalprofit[$i]/1000)." eFt</strong>",
				"<em>".round(($typetotalprofit[$i]+$typeownwork[$i])/1000)." eFt</em>"
				));
			}
		}
			
	print "</table>";
}

function costsForm($db) {
	$idbook=$_GET['idbook'];
	$idcost=$_GET['idcost'];
	if ($_GET['idcost']>0) {
		sqlquery($db,"update costs set 
		description='".$_GET['description'].
		"', sum='".$_GET['sum'].
		"', type='".$_GET['type'].
		"', paid='".$_GET['paid'].
		"', date='".$_GET['date'].
		"' where idcost='".$_GET['idcost']."'");
	}
	if ($_GET['n']==1) {
		sqlquery($db,
		"insert into costs (bookid,description,sum,type,paid,date) values (".
		"'".$_GET['idbook']."',".
		"'".$_GET['description']."',".
		"'".$_GET['sum']."',".
		"'".$_GET['type']."',".
		"'".$_GET['paid']."',".
		"'".$_GET['date']."')"
		);
		
	}
	$e=sqlquery($db,"select author,title from books where idbook=$idbook");
	$s=$e->fetch();
	print "<h1>".$s['author'].": ".$s['title']."</h1>";
	print "<table cellpadding='5'>";
	formTableHead(array("Leírás","Összeg","Típus","Kategória","Dátum",""));
	$e=sqlquery($db,"select * from costs where bookid=$idbook");
	while ($s=$e->fetch() ) {
		print "<form action='$fajlnev' method='get'>";
		formHidden("feladat","32");
		formTableRow(array(
			formHidden("q","11").
			formHidden("feladat","32").
			formHidden("idbook",$idbook).
			formHidden("idcost",$s['idcost']).		
			formInput("description",$s['description'],25),
			formInput("sum",$s['sum'],6)." Ft",
			formSelect(bookParameters("costtypes"),"type",$s['type']),
			formSelect(bookParameters("costpaid"),"paid",$s['paid']),
			formInput("date",$s['date'],7),
			formSubmit("MÓDOSÍTÁS")
			));
		print "</form>";
		}
	// összesítések
	$t=inventorySum($db,$idbook);
	/*
	$e=sqlquery($db,"select 
		sum(sum*(type>=8)) as expectedincome,sum(sum*(type<8)) as expectedcost,
		sum(sum*(type<8)*(paid=3)) as expectedinternalcost,
		sum(sum*(type>=8)*(paid=2)) as paidincome,sum(sum*(type<8)*(paid>=2)) as paidcost,
		sum(sum*(type<8)*(paid=3)) as paidinternalcost
		from costs where bookid=$idbook");
	$s=$e->fetch();
	*/
	$s=costsData($db,$idbook);
	$netto=100/105;
	formTableRow(array("Tényleges webboltos eladás",round($t['soldwebsumpaid']*$netto/1000)." eFt","",
		"(".round($t['soldwebsumpaid']*$netto)." Ft)"));
	formTableRow(array("Tényleges viszonteladói eladás",round($t['soldresellersumpaid']*$netto/1000)." eFt","",
		"(".round($t['soldresellersumpaid']*$netto)." Ft)"));
	formTableRow(array("Szerző fizetett vásárlásai",round(($t['soldauthorsumpaid']*$netto)/1000)." eFt","","(".round($t['soldauthorsumpaid']*$netto)."Ft)"));
	formTableRow(array("Összes fizetett bevétel",round($s['paidincome']/1000)." eFt","","(".$s['paidincome']." Ft)"));
	$fullincome=($t['soldwebsumpaid']*$netto)+($t['soldresellersumpaid']*$netto)+($t['soldauthorsumpaid']*$netto)+$s['paidincome'];
	formTableRow(array("<b>Összes eddigi bevétel</b>","<b>".round($fullincome/1000)." eFt</b>","","(".round($fullincome)." Ft)"));
	formTableRow(array("Kifizetett/lemondott szerzői jogdíj",round($s['royaltypaid']/1000)." eFt","","(".round($s['royaltypaid'])."Ft)"));
	formTableRow(array("Összes fizetett kiadás (jogdíj nélkül)",round(($s['paidcost']-$s['royaltypaid'])/1000)." eFt","","(".($s['paidcost']-$s['royaltypaid'])." Ft)"));
	formTableRow(array("<b>Összes eddigi kiadás</b>","<b>".round($s['paidcost']/1000)." eFt</b>","","(".round($s['paidcost'])." Ft)"));
	$profit=$fullincome-$s['paidcost'];
	formTableRow(array("<b>Eddigi eredmény</b>","<b>".round($profit/1000)." eFt</b>","",
		"(".round($profit)." Ft)"));
	formTableRow(array("Fizetett belső költség (saját munka)",round($s['paidinternalcost']/1000)." eFt","","(".$s['paidinternalcost']." Ft)"));
	$fullprofit=$profit+$s['paidinternalcost'];
	formTableRow(array("<b>Eddigi teljes haszon</b>","<b>".round($fullprofit/1000)." eFt</b>","",
		"(".round($fullprofit)." Ft)"));

	formTableRow(array(""));

	formTableRow(array("Kiszámlázott webboltos eladás",round($t['soldwebsum']*$netto/1000)." eFt","",
		"(".$t['soldwebsum']." Ft)"));
	formTableRow(array("Kiszámlázott viszonteladói eladás",round($t['soldresellersum']*$netto/1000)." eFt","",
		"(".$t['soldresellersum']." Ft)"));
	formTableRow(array("Szerző kiszámlázott vásárlásai",round(($t['soldauthorsum']*$netto)/1000)." eFt","","(".round(($t['soldauthorsum']*$netto))." Ft)"));
	formTableRow(array("Összes közvetlen bevétel",round($s['expectedincome']/1000)." eFt","","(".round($s['expectedincome'])." Ft)"));
	$fullincomeexpected=($t['soldwebsum']*$netto)+($t['soldresellersum']*$netto)+($t['soldauthorsum']*$netto)+$s['expectedincome'];
	formTableRow(array("<b>Összes várt bevétel</b>","<b>".round($fullincomeexpected/1000)." eFt</b>","","(".round($fullincomeexpected)." Ft)"));
	formTableRow(array("Kifizetett/lemondott szerzői jogdíj",round($s['royaltypaid']/1000)." eFt","","(".round($s['royaltypaid'])." Ft)"));
	formTableRow(array("Még kifizetendő szerzői jogdíj",round(($t['royaltywebshopsum']+$t['royaltyresellersum']-$s['royaltypaid'])/1000)." eFt",
		"","(".round($t['royaltywebshopsum']+$t['royaltyresellersum']-$s['royaltypaid'])." Ft)"));
	formTableRow(array("Összes közvetlen kiadás",round(($s['expectedcost']-$s['royaltypaid'])/1000)." eFt","","(".round($s['expectedcost']-$s['royaltypaid'])." Ft)"));
	$fullcostexpected=$s['expectedcost']+$t['royaltywebshopsum']+$t['royaltyresellersum']-$s['royaltypaid'];
	formTableRow(array("<b>Összes várt kiadás</b>","<b>".round($fullcostexpected/1000)." eFt</b>","","(".round($fullcostexpected)." Ft)"));
	formTableRow(array("<b>Jelenleg várt eredmény</b>","<b>".round(($fullincomeexpected-$fullcostexpected)/1000)." eFt</b>","",
		"(".round($fullincomeexpected-$fullcostexpected)." Ft)"));
	formTableRow(array("Saját munka",round($s['expectedinternalcost']/1000)." eFt","","(".round($s['expectedinternalcost'])." Ft)"));
	formTableRow(array("<b>Jelenleg várt teljes haszon</b>","<b>".round(($fullincomeexpected-$fullcostexpected+$s['expectedinternalcost'])/1000)." eFt</b>","",
		"(".round($fullincomeexpected-$fullcostexpected+$s['expectedinternalcost'])." Ft)","(saját munkával)"));

	formTableRow(array(""));

	if ($t['sponsor']==2) {
		if ($t['contracted'] < $t['totalsold']) {
			formTableRow(array("<em>Kifutott ingyenes kiadás</em>"));}
		else {
			$tobesoldtoauthor=($t['contracted'] - $t['totalsold']) * .5*$t['price']*$netto; //az elvárt példányszámból megmaradt példányok nettó ára
			formTableRow(array("Vállalt példányszám",$t['contracted']." pld."));
			formTableRow(array("Elfogyott példányszám",$t['totalsold']." pld."));
			formTableRow(array("Teljesítendő példányszám",($t['contracted'] - $t['totalsold'])." pld."));
			formTableRow(array("Várható szerzői kényszervásárlás",round($tobesoldtoauthor/1000)." eFt","","(".round($tobesoldtoauthor)." Ft)"));
			$totalprofit = $fullincomeexpected - $fullcostexpected + $tobesoldtoauthor;
			formTableRow(array("Várt végleges haszon","<b>".round($totalprofit/1000)." eFt</b>","","(".round($totalprofit)." Ft)"));
			formTableRow(array("Várt végleges haszon saját munkával","<b>".round(($totalprofit+$s['expectedinternalcost'])/1000)." eFt</b>",
				"","(".($totalprofit+$s['expectedinternalcost'])." Ft)"));
		}
	}

	// új tétel felvitele
	formTableRow(array(
		"<form action='$fajlnev' method='get'>".
		formHidden("n","1").
		formHidden("q","11").
		formHidden("feladat","32").
		formHidden("idbook",$idbook).
		formInput("description",$s['description'],20),
		formInput("sum",$s['sum'],6)." Ft",
		formSelect(bookParameters("costtypes"),"type",$s['type']),
		formSelect(bookParameters("costpaid"),"paid",$s['paid']),
		formInput("date",$s['date'],7),
		formSubmit("ÚJ HOZZÁADÁSA")
		));
	print "</table>";
}

function costsData($db,$idbook) {
	$e=sqlquery($db,"select 
		sum(sum*(type>=8)) as expectedincome,sum(sum*(type<8)) as expectedcost,
		sum(sum*(type<8)*(paid=3)) as expectedinternalcost,
		sum(sum*(type>=8)*(paid=2)) as paidincome,sum(sum*(type<8)*(paid>=2)) as paidcost,
		sum(sum*(type<8)*(paid=3)) as paidinternalcost,
		sum(sum*(type=7)) as royaltytobepaid,
		sum(sum*(type=7)*(paid=2)) as royaltypaid,
		sum(sum*(type=2)) as printingcosts
		from costs where bookid=$idbook");
	$s=$e->fetch();
	return $s;
	/*
	$sql="update costs set 
		contracttype='".$_GET['contracttype']
		."',printrun='".$_GET['printrun']
		."',contracted='".$_GET['contracted']
		."',printingcost='".$_GET['printingcost']
		."',vat='".$_GET['vat']
		."',quarter='".$_GET['quarter']
		."',comment='".$_GET['comment']
		."' where idbook=".$_GET['idbook'];
	$db->exec($sql) or die ("<br/>Nem sikerült a <i>$sql</i> lekérdezés! A hiba:<br/><i>".implode(":",$db->errorInfo())."</i>");
	print "A módosítás sikerült! <a href='$fajlnev?feladat=32&idbook=".$_GET['idtransaction']."'>Módosított javítása</a> ";
	*/
}

function dtpCreate($db) {
	$sql="create table dtp (
		idjob integer primary key,
		idbook int,
		dtpbilling int,
		tobebilled int,
		billed int,
		startdate int,
		duedate int,
		dtpcomment text
		)"; # a books tábla status_dtp mezője is szükséges lesz
	sqlquery($db,$sql);
}

function dtpForm($db) {
	if ($_GET['new']==1) {
		//új elem felvétele
		sqlquery($db,"insert into dtp (idbook) values ('".$_GET['idbook']."')");
		$r=sqlquery($db,"select max(idjob) from dtp");
		$s=$r->fetch();
		$idjob=$s[0];
		}
	else {$idjob=$_GET['idjob'];}
	// munka adatainak lekérdezése
	$r=sqlquery($db,"select * from dtp,books 
		where idjob='$idjob' and books.idbook=dtp.idbook");
	$s=$r->fetch();
	// űrlap
	print "<form action='$fajlnev' method='get'>";
	print formHidden("feladat","43");
	print "<table>";
	formTableHead(array("Mező","Adat","Megjegyzés"));
	print formHidden("idjob",$idjob);
	formTableRow(array("Munkaszám:",$idjob,"A feladat sorszáma. Nem változtatható."));
	formTableRow(array("Könyv sorszáma:",formInput("idbook",$s['idbook'],4),
		"<em>".$s['author'].": ".$s['title']."</em> (a sorszám átírható)"));
	formTableRow(array("Munkafázis:",
		formSelect(bookParameters("status_dtp"),"status_dtp",$s['status_dtp']),
		"A munka jelenlegi státusza."));
	formTableRow(array("Számlázás állapota:",
		formSelect(bookParameters("status_billing"),"dtpbilling",$s['dtpbilling']),
		"A számlázás jelenlegi státusza."));
	formTableRow(array("Számlázható:",formInput("tobebilled",$s['tobebilled'],5),
		"A munka teljes számlázható összege."));
	formTableRow(array("Számlázott:",formInput("billed",$s['billed'],5),
		"Az eddig számlázott összeg."));
	formTableRow(array("Kezdési dátum:",formInput("startdate",$s['startdate'],8),
		"A munka kezdési ideje (év-hónap-nap)."));
	formTableRow(array("Határidő:",formInput("duedate",$s['duedate'],8),
		"A munka határideje (év-hónap-nap)."));
	formTableRow(array("Megjegyzés:",
		"<textarea name='dtpcomment' cols='35' ROWS='5'>".$s['dtpcomment']."</textarea>",
		"Minden egyéb feljegyzés."));
	formTableRow(array("","<br/>".formSubmit("ADATOK RÖGZÍTÉSE"),""));
	print "</table>";
}

function dtpNewJob($db) {
	$r=sqlquery($db,"select idbook,author,title from books order by author");
	while ($s=$r->fetch()) {
		print "<a href='$fajlnev?feladat=42&new=1&idbook=".$s['idbook']."'>".$s['author'].": ".$s['title']."</a><br/>";
		}	
}

function dtpData($db) {
	sqlquery($db,"update dtp set 
		idbook='".$_GET['idbook']
		."',dtpbilling='".$_GET['dtpbilling']
		."',tobebilled='".$_GET['tobebilled']
		."',billed='".$_GET['billed']
		."',startdate='".$_GET['startdate']
		."',duedate='".$_GET['duedate']
		."',dtpcomment='".$_GET['dtpcomment']
		."' where idjob='".$_GET['idjob']."'");
	sqlquery($db,"update books set status_dtp='".$_GET['status_dtp']."' where idbook= '".$_GET['idbook']."'");	
}

function dtpList($db) {
	print "<a href='$fajlnev?feladat=44'>Új hozzáadása</a><br/>";
	$r=sqlquery($db,"select * from dtp,books where dtp.idbook=books.idbook order by status_dtp,duedate");
	print "<table>";
	formTableHead(array("Munka-<br/>szám","Könyvcím","Számlázás állapota",
		"Megbízás","Számlázott","Kezdés","Határidő","Megjegyzés"));
	$n=0;
	while ($s=$r->fetch(PDO::FETCH_ASSOC) ) {
		$idjob=$s['idjob'];
		if ($n<$s['status_dtp']) {
			$n=$s['status_dtp'];
			formTableRow(array("","<font color='darkgreen'>".bookParameters("status_dtp",$s['status_dtp'])."</font>"));
			}
		formTableRow(array("<a href='$fajlnev?feladat=42&idjob=$idjob'>$idjob</a>",
			"<font size='-1'>".strtok($s['author']," ")." ".strtok(" ").": ".strtok($s['title']," ")." ".strtok(" ")."</font>",
			bookParameters("status_billing",$s['dtpbilling']),
			$s['tobebilled'],$s['billed'],$s['startdate'],$s['duedate'],
			"<font size='-2'>".$s['dtpcomment']."</font>"));
		}
	print "</table>";
	
	
}

?>
