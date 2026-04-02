<?php
require_once("catalogueFunctions.php");

$body = "<div>";
$body .= "<p><a href='catalogueGeneratorIndex.php'>index.html generálása</a></p>";
$body .= "<p><a href='catalogueGeneratorSearch.php'>kereso.html generálása</a></p>";
$body .= "<p><a href='catalogueGeneratorPages.php?updated=modified'>módosított lapok frissítése</a></p>";
$body .= "<p><a href='catalogueGeneratorPages.php?updated=all'>összes lap generálása</a></p>";
$body .= "<p><a href='catalogueGeneratorPages.php?idbook=1'>egy adott lap generálása</a></p>";
$body .= "<p><a href='catalogueMissing.php'>hiányzó adatok</a></p>";
$body .= "</div>";

//$body .= "<div>".phpinfo()."</div>";
$body .= "<pre>".exec('whereis php')."</pre>";
$body .= "<pre>".exec('whereis bash')."</pre>";

$o = exec('whereis grep');
$body .= "<p>! $o !</p>";

print adminPage($body);

?>
