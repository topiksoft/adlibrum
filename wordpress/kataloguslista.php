<?php
function sqlquery($sql) {
	$result=$db->query($sql)
	or die ("Nem sikerült a lekérdezés! Az sql a következő volt: <i>$sql</i>");
return $result;
}

try{
$db= new PDO('sqlite:books/books.db');#adlibrum.hu
	}catch( PDOException $exception ){
		die($exception->getMessage());
	}

$categories=array("NINCS MEGADOTT KATEGÓRIA",
"Szépirodalom/Dráma, forgatókönyv","Szépirodalom/Vers","Szépirodalom/Novella","Szépirodalom/Regény","Szépirodalom/Antológia","Szépirodalom/Útleírás",
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

$body="<h3>Legújabb kiadványaink</h3>";
$e=$db->query("select * from books where onlineshop=1 order by datepuby desc,datepubm desc,datepubd desc limit 10")
	or die ("Nem sikerült a lekérdezés! Az sql a következő volt: <i>$sql</i>");
while ($sor = $e->fetch() ) {
	$author=$sor['author'];
	$title=$sor['title'];
	//$link="http://adlibrum.hu/cedula.php?id=".$sor['idbook'];
	$link="cedula/?id=" . $sor['idbook'];
	$body.="<p><a title='Kattintson ide a könyv bővebb leírásáért!' href='$link'>$author: $title</a></p>";
}

$body.="<h2>Ad Librum könyvek 2008-tól máig</h2>";

foreach(array(3,4,2,1,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,26,27,28,29,30,31,33,34,35,36,37,38,39,40,41,42,43) as $i) {
	$body.="<h3>".$categories[$i]."</h3>";
	$e=$db->query("select * from books where ((category1=$i or category2=$i) and (status=2 or status=3 or status=5) and onlineshop=1) order by author")
		or die ("Nem sikerült a lekérdezés! Az sql a következő volt: <i>$sql</i>");
	while ($sor = $e->fetch() ) {
		$author=$sor['author'];
		$title=$sor['title'];
		$link="cedula/?id=".$sor['idbook'];
		$body.="<p><a title='Kattintson ide a könyv bővebb leírásáért!' href='$link'>$author: $title</a></p>";
	}
}

/*
*/
print $body;

unset($db);#sqlite3

?>
