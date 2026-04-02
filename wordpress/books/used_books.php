<?php

//include('../xcrud/xcrud/xcrud.php');

$FN=$_SERVER['PHP_SELF'];

if (isset($_POST['task'])) {$_GET['task']=$_POST['task'];} //ha van post, akkor ez a feladat
if (isset($_GET['task'])) {$task=$_GET['task'];} else {$task="crudList";}

require_once("booksFunctions.php"); //categories tömb miatt
$editform[]=array("label"=>"Szerző","field"=>"author","type"=>"text","size"=>"40");
$editform[]=array("label"=>"Cím","field"=>"title","type"=>"text","size"=>"40");
$editform[]=array("label"=>"Rövid leírás<br/>(alapadatok)","field"=>"abstractshort","type"=>"textarea");
$editform[]=array("label"=>"Teljes ár","field"=>"price","type"=>"text","size"=>"5");
$editform[]=array("label"=>"Akciós ár","field"=>"saleprice","type"=>"text","size"=>"5");
$editform[]=array("label"=>"Webboltban","field"=>"onlineshop","type"=>"dropdown","options"=>bookParameters('onlineshop'));
$editform[]=array("label"=>"Webboltban kiemelt","field"=>"onlineshopwindow","type"=>"dropdown","options"=>bookParameters('onlineshopwindow'));
$editform[]=array("label"=>"Kategória 1","field"=>"category1","type"=>"dropdown","options"=>bookParameters('categories'));
$editform[]=array("label"=>"Kategória 2","field"=>"category2","type"=>"dropdown","options"=>bookParameters('categories'));
$editform[]=array("label"=>"Árukategória","field"=>"status","type"=>"dropdown","options"=>bookParameters('status'));
$editform[]=array("label"=>"Hátszöveg","field"=>"blurb","type"=>"textarea");
$editform[]=array("label"=>"Borítókép","field"=>"coverfile","type"=>"text","size"=>"40");
$editform[]=array("label"=>"Egyéb (belső) infó","field"=>"addedinfo","type"=>"text","size"=>"40");

$listlabels=array("","Azonosító","Szerző","Cím","Kiadási adatok","Ár (Ft)","Akciós ár (Ft)","Kategória");

$table="<p><a href='".$_SERVER['PHP_SELF']."?task=crudList'>LISTA</a> |
	<a href='".$_SERVER['PHP_SELF']."?task=crudCreate'>ÚJ</a></p>";

$listsql="select idbook,author,title,abstractshort,price,saleprice,status from books where status>=6 order by category1";

switch ($task) {
	case "crudList": $table.=crudList($listsql,"idbook",$listlabels); break;
	case "crudEdit": $table.=crudEdit($editform,"books","idbook=".$_GET['id']); break;
	case "crudUpdate": crudUpdate(); $table.="<p><em>Mentve!</em></p>"; $table.=crudList($listsql,"idbook",$listlabels); break;
	case "crudCreate": $newid=crudCreate(); $table.="<p>Új azonosító: $newid</p>"; $table.=crudEdit($editform,"books","idbook=".$newid); break;
	}

function crudList($sql,$idname="id",$listlabels) {
	# Kilistázza táblázatban a lekérdezés eredményét.
	# Paraméterek: $sql = a lekérdezés; $idname = a fő azonosító mező neve (ha nem "id")
	
	require_once("dbopen.php");
	$db=dbopen();
	$sth = $db->prepare($sql);
	$sth->execute();
	$data = $sth->fetchall(PDO::FETCH_ASSOC);

	$t="";
	$t.="<table><tr>";
	foreach ($listlabels as $th) {$t.="<th>$th</th>";}
	$t.="</tr>";
	foreach ($data as $row) {
		$t.="<tr><td><a href='$FN?task=crudEdit&id=$row[$idname]' title='Tétel módosítása'>M</a></td>";
		foreach ($row as $cell) {$t.="<td>$cell</td>";}
		$t.="</tr>";
		}
	$t.="</table>";
	return $t;
}

function crudEdit($editform,$table,$where) {
	# Szerkesztési űrlapban megjeleníti az adatbázis egy sorát.
	# Paraméterek: $sql = a lekérdezés, $editform = az űrlap sorai, $table = az adatbázis tábla neve
	
	require_once("dbopen.php");
	require_once("booksFunctions.php"); //űrlap funkciók miatt

	$sql="select * from $table where $where";
	$db=dbopen();
	$sth = $db->prepare($sql);
	$sth->execute();
	$data = $sth->fetch(PDO::FETCH_ASSOC);

	$t="<table>";
	$t.="<form action=".$_SERVER['PHP_SELF']." method='post' >";
	$t.=formHidden("task","crudUpdate");
	$t.=formHidden("table",$table);
	$t.=formHidden("where",$where);
	foreach ($editform as $row) {
		//$t.=print_r($row);
		$value=$data[$row['field']];
		$t.="<tr><td>".$row['label'].": </td>";
		if ($row['type']=="text") {$t.="<td>".formInput($row['field'],$value,$row['size'])."</td></tr>";}
		if ($row['type']=="textarea") {$t.="<td>".formTextarea($row['field'],$value,$row['size'])."</td></tr>";}
		if ($row['type']=="dropdown") {$t.="<td>".formSelect($row['options'],$row['field'],$value,0)."</td></tr>";}
		}
	$t.="<tr><td></td><td>".formSubmit("ADATOK RÖGZÍTÉSE")."</td></tr></form></table>";
	return $t;
}

function crudUpdate() {
	$t="";
	$u="";
	foreach($_POST as $key => $value) {
		if ($key<>"table" and $key<>"where" and $key<>"task") {$u.=$key."='".$value."',";}
		}
	$u=substr($u,0,strlen($u)-1); //a felesleges sorvégi vessző eltüntetése
	$sql="update ".$_POST['table']." set ".$u." where ".$_POST['where'];
	require_once("dbopen.php");
	$db=dbopen();
	$sth = $db->prepare($sql);
	$sth->execute();
	}

function crudCreate() {

	$sql="insert into books default values";
	require_once("dbopen.php");
	$db=dbopen();
	$sth = $db->prepare($sql);
	$sth->execute();

	$result = $db->query('SELECT last_insert_rowid() as last_insert_rowid')->fetch();
	return $result['last_insert_rowid'];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu" lang="hu">

<head>
	<title>Használt könyvek adatainak rögzítése</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<!-- <link rel="stylesheet" href="layout.css"> -->
	<style>
		body {font: 14px/1.3 verdana, arial, helvetica, sans-serif;}
		th {background-color: orange;color: white;}
		h2 {color: green;}
	</style>
</head>

<body>

<h2>Használt könyvek adatainak rögzítése</h2>

<?php print $table; ?>
	
</body>

</html>