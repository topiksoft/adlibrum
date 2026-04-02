<?php

# transactions: fizetve,számlával,fogyási jelentés,postázási mód

///////////////////////////////////////////
# inicilizálás
	$fajlnev=$_SERVER['PHP_SELF'];
	global $fajlnev;
	if ($_POST['task']=="") {$feladat=$_GET['feladat'];}
		else { $feladat=$_POST['task']; }
	include("booksFunctions.php");
	include("booksFunctionsB.php");
	$datem=2; # az év adott hónapjának száma; global kell az eléréséhez
	if (empty($feladat)) {$feladat=11; $listing="Hozzáadás időrendje szerint"; $uzenet=0;}
	$modositas=$_GET['modositas'];
	htmlHeader("Ad Librum Könyvek");
///////////////////////////////////////////////////
# adatbázis megnyitása
	include("dbopen.php");
	$db=dbopen() or die ("Nem sikerült az adatbázis megnyitása.");
///////////////////////////////////////////////////
# MENÜ
	menu();

///////////////////////////////////////////
# FELADATOK
switch ($feladat) {
	case "10": //kikommentezni, nehogy véletlenül hozzányúljunk az adatbázishoz
		include("booksTransferSql.php");//dbcreate($db);
		//dbtransferfrommysql($db);
		break;
	case "11": bookList($db); break;
	case "111": bookListFull($db); break;
	case "bookListCategories": bookListCategories($db); break; # kategóriák szerinti listázás
	case "bookAddfromold": bookAddfromold($db); break; # kategóriák szerinti listázás
	case "bookForm": bookForm($db,$_GET['idold']); break; # kategóriák szerinti listázás
	case "12": bookForm($db,0); break; #új könyv
	case "13": bookForm($db); break;
	case "14": bookMod($db); bookList($db); break;
	case "15": bookDetails($db); break;
	case "16": bookSearch($db); break;
	case "17": bookProgram($db); break;
	case "18": bookDTP($db); break;
	case "19": bookCover($db); break;
	//case "20": inventoryCreate($db); # adatbázis létrehozása
	case "21": inventoryList($db,$_GET['inventory']); break;
	case "22": inventoryForm($db); break;
	case "23": inventoryData($db);inventorySalesReport($db);break;
	case "24": inventoryAdd($db); break;
	case "25": inventoryStat($db); break;
	case "26": inventorySalesReport($db); break;
	case "inventoryTotal": inventoryTotal($db); break;
	//case "30": costsCreate($db); # adatbázis létrehozása
	case "31": costsList($db); break;
	case "32": costsForm($db); break;
	case "33": costsData($db); costsList($db); break;
	case "34": costsAdd($db); break;
	//case "40": dtpCreate($db); break;
	case "41": dtpList($db); break;
	case "42": dtpForm($db); break;
	case "43": dtpData($db); dtpList($db); break;
	case "44": dtpNewJob($db); break;
	case "51": statRoyalty($db); break;
	case "52": statFree($db); break;
	case "53": statPrepaid($db); break;
	case "statReportLetter": statReportLetter(); break;
	case "statReportLetterSend": statReportLetterSend(); break;
	case "statReportCircularLetter": statReportCircularLetter(); break;
	case "statReportCircularLetterSend": statReportCircularLetterSend(); break;
	case "statReportCircularLetterSending": statReportCircularLetterSending(); break;
	}

# adatbázis lezárása
	unset($db);

# HTML lezárása
	htmlFooter();
?>
