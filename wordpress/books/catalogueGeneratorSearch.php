<?php

require_once("catalogueFunctions.php");
$db=dbopen() or die ("Nem sikerült az adatbázis megnyitása.");

$searchable="";
$sql="select * from books,bookPublishers 
	where (books.publisher=bookPublishers.id and (status=2 or status=3 or status=5) and sponsor<6 and onlineshop=2) order by pubyear desc,date_publication desc ";
foreach ($db->query($sql) as $r) {
	extract($r);
	if ($publisher==3) {$name=$publishing;} //egyéb kiadó
	$publisher= "$name, $pubyear.";
	# KERESŐ sorai
	if ($status==2) {$inprogress="<em>Megjelenés alatt</em>";} else {$inprogress="";}
	$searchable .= "
		<tr>
			<td>$author: <em><a href='$catalogueurl.html'>$title</a></em> $publisher ISBN $isbn $inprogress</td>
		</tr>
		";
}

# ------------
# KERESŐ OLDAL
# ------------

$og = "<meta property='og:type' content='website' />";
$og .= "<meta property='og:title' content='Kereshető könyvlista' />";
$og .= "<meta property='og:url' content='https://adlibrum.hu/katalogus/kereso.html' />";
$og .= "<meta property='og:description' content='Az Ad Librum, Személyes Történelem, Expert Books és Storming Brain kiadók megjelent könyvei kereshető listában.' />";
$og .= "<meta property='og:image' content='https://adlibrum.hu/katalogus/includes/I_am_writer__Fotolia_96517918_M.jpg' />";
$og .= "<meta property='og:locale' content='hu_HU' />";

$searchabletable = catalogueHeader("Az Ad Librum, Személyes Történelem, Expert Books és Storming Brain kiadók megjelent könyvei kereshető listában",$og);
$searchabletable .= callout();
//$searchabletable .= "<h1>Az Ad Librum, Személyes Történelem, Expert Books és Storming Brain kiadók könyvei kereshető listában</h1>";
$searchabletable .= "
	<div class='col_9'>
	<table id='myTable'>
		<tr class='header'><th><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Keresés...' title='Kezdje el begépelni a szerző nevét, a könyv címet vagy más adatot!'></th></tr>
		$searchable
	</table>
	</div>";
$searchabletable .= sidemenu();
$searchabletable .= "
	<script>
	function myFunction() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById('myInput');
	  filter = input.value.toUpperCase();
	  table = document.getElementById('myTable');
	  tr = table.getElementsByTagName('tr');
	  for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName('td')[0];
		if (td) {
		  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = '';
		  } else {
			tr[i].style.display = 'none';
		  }
		}       
	  }
	}
	</script>
	";
file_put_contents("../katalogus/kereso.html",$searchabletable);

print adminPage("<p><a href='../katalogus/kereso.html'>Az kereso.html elkészült.</a></p>");

?>
