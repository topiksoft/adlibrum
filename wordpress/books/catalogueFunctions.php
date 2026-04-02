<?php

function dbopen() {
	print "<h2>PDO</h2>";
	try{
		$db = new PDO('mysql:host=93.104.209.180;dbname=intranet;charset=utf8;port=3306', 'impaktuser', 'Jarguf14');
	}catch( PDOException $exception ){
		die($exception->getMessage());
	}
	return $db;
}

# Egyszerű html lap létrehozása, amelyben a katalógusgenerátor kiírja az üzeneteit.
function adminPage($body) {
return str_replace("[[BODY]]",$body,"<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8' />
    <title>Katalógusgenerátor</title>
    </head>
 
<body>

[[BODY]]

</body>
</html>");

}

function catalogueHeader($pagetitle,$og) {
		return "
		<!DOCTYPE html>
		<html>
		<head>
			<!-- META -->
			<title>$pagetitle</title>
			<meta charset='UTF-8'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
			<meta name='description' content='' />
			$og
			
			<!-- CSS -->
			<link rel='stylesheet' type='text/css' href='css/kickstart.css' media='all' />
			<link rel='stylesheet' type='text/css' href='includes/style.css' media='all' /> 
			
			<!-- Javascript -->
			<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
			<script type='text/javascript' src='js/kickstart.js'></script>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src='https://www.googletagmanager.com/gtag/js?id=UA-73759864-1'></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			  gtag('config', 'UA-73759864-1');
			</script>
			</head>
		<body>
			<div id='fb-root'></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = '//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.8';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			</script>
			<nav class='navbar'>
				<a class='hide-phone' id='logo' href='https://adlibrum.hu/' title='Az Ad Librum kiadók közös honlapja'><i class='fa fa-angle-right'></i> Ad<span>Librum</span>.hu</a></li>
				<ul>
					<li><a href='index.html' title='Vissza a katalógus kezdőlapjára'><span>Kezdő</span>lap</a></li>
					<li><a href='kereso.html' title='Az összes kiadott és kiadás alatt álló könyv kereshető listája'>Könyv<span>kereső</span></a></li>
				</ul>
			</nav>
	";
	}

function catalogueFooter() {return "</body></html>";}

function catalogueHtmlname($cover) {
	$cover = str_replace("--FD.jpg","",$cover); //képnév végződés levágása
	$cover =str_replace("-FD.jpg","",$cover); //régi végződés levágása
	return $cover;
	}

function sidemenu() {
	return "
		<div class='col_3'>
			<p><a class='button large pill orange' href='kereso.html' title='Keresés az összes megjelent könyv között szerző, cím vagy egyéb adat alapján'>KÖNYVKERESŐ</a></p>
			<p>&nbsp;</p>
			<ul class='menu vertical right'>
				<li><a href='https://konyvkiadasa.hu/' target='_blank'>KönyvKiadása.hu: könyvkiadási pályázatok és programok</a></li>
				<li><a href='http://konyvesbolt.online/' target='_blank'>Könyvesbolt.Online: a kiadói webbolt</a></li>
				<li><a href='https://konyv.guru/' target='_blank'>Könyv Guru: az írók portálja</a></li>
				<li><a href='https://adlibrum.hu' target='_blank'>Ad Librum kiadók közös honlapja</a></li>
				<li><a href='http://szemelyestortenelem.hu' target='_blank'>Személyes Történelem Kiadó</a></li>
				<li><a href='http://kisallattenyesztes.hu' target='_blank'>Kisállattenyésztés.hu</a></li>
				<li><a href=''>Facebook</a>
					<ul>
						<li><a href='https://facebook.com/adlibrum/' target='_blank'>Ad Librum Facebook</a></li>
						<li><a href='https://facebook.com/szemelyestortenelem/' target='_blank'>Személyes Történelem Facebook</a></li>
						<li><a href='https://facebook.com/kisallattenyesztes/' target='_blank'>Kisállattenyésztés Facebook</a></li>
						<li><a href='https://facebook.com/www.konyv.guru/' target='_blank'>Könyv Guru Facebook</a></li>
					</ul>
				</li>
				<li><a href=''>Szerzői honlapok</a>
					<ul>
						<li><a href='http://villax.konyv.guru/' target='_blank'>Villax Richárd (<em>Fanyűvők. Nemzeti Jeti</em>)</a></li>
						<li><a href='http://sajtergizella.konyv.guru/' target='_blank'>Sajter Gizella (<em>Tudatelégtelenség</em>)</a></li>
						<li><a href='http://hegedusrita.konyv.guru/' target='_blank'>Hegedűs Rita (<em>Az Ember fia</em>)</a></li>
						<li><a href='http://jeneiandras.konyv.guru/' target='_blank'>Jenei András (<em>Nyeregben a Konstantin-kereszt</em>)</a></li>
						<li><a href='http://mestergyorgyi.konyv.guru/' target='_blank'>Mester Györgyi (<em>számos novelláskötet és mesekönyv</em>)</a></li>
						<li><a href='http://krencznora.konyv.guru/' target='_blank'>Krencz Nóra (<em>Megszámlálhatatlan</em>)</a></li>
						<li><a href='http://barczikaylilla.konyv.guru/' target='_blank'>Barczikay Lilla (<em>Bátyám könnyei</em>)</a></li>
						<li><a href='http://wanderer.konyv.guru/' target='_blank'>Wanderer János (<em>három novelláskötet</em>)</a></li>
						<li><a href='http://orsolyavkiss.konyv.guru/' target='_blank'>Kiss V. Orsolya (<em>A herceg fekete lovon érkezett</em>)</a></li>
						<li><a href='http://molnartoni.konyv.guru/' target='_blank'>Molnár Tóni (<em>Tépődések</em>)</a></li>
						<li><a href='http://naszvadijudith.konyv.guru/' target='_blank'>Naszvadi Judith (<em>A mi múzsánk</em>)</a></li>
						<li><a href='http://paueremanuel.konyv.guru/' target='_blank'>Pauer Emánuel (<em>Magamon kívül</em>)</a></li>
						<li><a href='http://szektorkronikai.konyv.guru/' target='_blank'>Grein&Decker (<em>A Szektor Krónikái</em>)</a></li>
					</ul>
				</li>
			</ul>
		</div>
	";	
/*				<li><a href='https://www.adlibrum.hu/konyvkiadas/'>Könyvkiadás</a>
					<ul>
					<li><a href='https://www.adlibrum.hu/konyvkiadas/konyvkiadas-sikerkereso-szerzoknek/'>Aktív Szerző kiadási program</a></li>
					<li><a href='https://www.adlibrum.hu/konyvkiadas/szepirodalom-kiadasa/'>Szépirodalmi kiadási program</a></li>
					<li><a href='https://www.adlibrum.hu/konyvkiadas/riportkonyv-irasi-palyazat/'>Riportkönyvírási pályázat</a></li>
					</ul>
				</li>
*/

	}

function callout() {
	return "
	<div class='callout callout-top clearfix'>
		<div class='grid'>
			<p style='font-size: 300%;margin-bottom:30px;'>Az Ad Librum kiadói csoport könyveinek katalógusa</h1>
			<p style='font-size: 150%;'><strong>Ad Librum, Expert Books, Személyes Történelem, Storming Brain, Könyv Guru</strong></p>
		</div>
	</div>
	";
	}
?>
