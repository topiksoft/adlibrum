<?php


function statReportCircularLetter() {
	print "<h2>FOGYÁSI JELENTÉS KÜLDÉSE KÖRLEVÉL FORMÁBAN</h2>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=teszt' title='Fogyási jelentés próba'>0. Tesztlevél</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=pod1' title='Fogyási jelentés a POD kiadások szerzőinek 400-ig'>1. POD kiadás A</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=pod2' title='Fogyási jelentés a POD kiadások szerzőinek 400 felett'>1. POD kiadás B</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=ingyenes1' title='Fogyási jelentés az ingyenes kiadások szerzőinek'>2. Ingyenes kiadás A</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=ingyenes2' title='Fogyási jelentés az ingyenes kiadások szerzőinek'>2. Ingyenes kiadás B</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=elo' title='Fogyási jelentés az előfinanszírozott kiadások szerzőinek'>3. Előfinanszírozott kiadás A</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=elo300' title='Fogyási jelentés az előfinanszírozott kiadások szerzőinek'>3. Előfinanszírozott kiadás B</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=elo500' title='Fogyási jelentés az előfinanszírozott kiadások szerzőinek 500-as számtól'>3. Előfinanszírozott kiadás C</a></p>
		<p><a href='$fajlnev?feladat=statReportCircularLetterSend&q=11&group=ebook' title='Fogyási jelentés az e-book kiadások szerzőinek'>4. Digitális kiadás</a></p>
		";
	}

function statReportCircularLetterSend() {
	global $db;
	global $datem;
	switch ($_GET['group']) {
		case "teszt": $kiadasimod="teszt"; $sql="select * from books where (idbook=1 or idbook=16)"; break;
		case "pod1": $kiadasimod="POD 400-as sorszámig"; $sql="select * from books where (idbook<=400 and sponsor=5 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "pod2": $kiadasimod="POD 400 sorszám felett"; $sql="select * from books where (idbook>400 and sponsor=5 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "ingyenes1": $kiadasimod="ingyenes";  $sql="select * from books where (idbook<=143 and sponsor=2 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "ingyenes2": $kiadasimod="ingyenes";  $sql="select * from books where (idbook>143 and sponsor=2 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "elo": $kiadasimod="előfinanszírozott 300-as sorszámig";  $sql="select * from books where (idbook<=300 and sponsor=1 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "elo300": $kiadasimod="előfinanszírozott 301-500-as sorszámmal";  $sql="select * from books where (idbook>300 and idbook<=500 and sponsor=1 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "elo500": $kiadasimod="előfinanszírozott 500-as sorszámtól";  $sql="select * from books where (idbook>500 and sponsor=1 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))"; break;
		case "ebook": $kiadasimod="digitális"; $sql="select * from books where (sponsor=6 and reported=1 and status=3 and (datepuby<2017 or datepubm<$datem))";
		}
	print "<h2>FOGYÁSI JELENTÉS KÜLDÉSE $kiadasimod KIADÁSÚ KÖNYVEK SZERZŐINEK</h2>";
	$mailreport=statReportMailreport($sql);
	foreach ($mailreport as $mail) {
		$to = $mail['emailaddress'];
		$idbook=$mail['idbook'];
		$idbook_formatted=sprintf("%03d",$idbook);
		print "<p><b><a href='$fajlnev?feladat=26&idbook=$idbook' title='Leltár szerkesztése'>$idbook_formatted</a> ";
		print "<a href='$fajlnev?feladat=13&idbook=$idbook' title='Könyvadatok szerkesztése'>".$mail['book']."</a></b></p>";
#az alábbi két sor kikommentelhető, ha nem látszik az oldal alján a gomb
		print "<p>".$mail['emailaddress']."</p>";
		print $mail['letter']."<hr/>";
		}
	print "
		<br/><p>
		<form action='books.php' method='post' >
			<input type='hidden' name='task' value='statReportCircularLetterSending' />
			<input type='hidden' name='sql' value='$sql' />
			<input type='submit' value='Értesítő levél küldése (NEM VISSZAVONHATÓ!)' />
		</form>
		</p>";
	}

function statReportMailreport($sql) {
	global $db;
	$booklist=sqlquery($db,$sql);
	while ($sor=$booklist->fetch(PDO::FETCH_ASSOC) ) {
		$idbook=$sor['idbook'];
		$t=inventorySum($db,$idbook,"0");
		$s=costsData($db,$idbook);
		$web="www.adlibrum.hu/".$sor['link_website'];
		$letter="<p class='center'><img src='adlibrumlogo_black_125x47.png'/></p>
			<h1>Kedves Szerzőnk!</h1>".
			"<p>Megújítottuk a <a href='http://www.adlibrum.hu/konyvkiadas/pod/' target='_blank'>POD kiadási programunkat</a>. A terjesztési módok a kiadói közvetlen terjesztésen kívül kiterjednek a Bookline-ra és a könyvtárellátóra is.</p>".
			"<p>Továbbra is fut az <a href='http://www.adlibrum.hu/konyvkiadas/konyvkiadas-sikerkereso-szerzoknek/' target='_blank'>Aktív Szerző könyvkiadási programunk</a>. Februárban megjelent Takács Hajnal <i><a href='http://www.konyvesbolt.online/Takacs-Hajnal-Bantalmazottak-igazsaga' target='_blank'>Bántalmazottak igazsága</a></i> című kötete. Kiadás alatt állnak a következők:</p>
			<p><ol>
				<li>K. Grein &amp; A. Decker: A Szektor krónikái - Felbukkanás. (március)</li>
				<li>Böhönyey Márta –Tóth Melinda: Mira. Így váltsd meg a világod! (sématerápia a gyakorlatban, április)</li>
				<li>Pauer Emánuel: Magamon kívül (április)</li>
				<li>Naszvadi Judith: A mi múzsánk. (május)</li>
				<li>Mikos Ákos: Esküvő Tour – Így éld meg jól az esküvődet! (június)</li>
				<li>Gelsei Bernadett: Társas hármas. A megcsalt, a hűtlen és a szerető pszichológiája. (szeptember)</li>
			</ol></p>".
			"<p>Az alábbiakban küldjük a könyve eddigi forgalmával kapcsolatos adatokat. Az adatok a kiadói eladások esetén naprakészek, a bizományosi forgalom esetén pedig a kereskedők által leadott utolsó fogyási jelentésekben közölteket tartalmazzák.</p>".
			/*
			"<p>Szeretnénk felhívni a figyelmét a <a href='http://www.adlibrum.hu/konyvkiadas/riportkonyv-irasi-palyazat/'>riportkönyvírási pályázatunkra</a>, amelyre piacképes könyvterveket, vagy akár kész kéziratokat várunk a társadalmat megosztó, esetleg kellő módon nem tudatosult problémákról és olyan szubkultúrákról, foglalkozási csoportokról, amelyek belső élete sok érdekességet tartogat a kívülállóknak.</p>".
			"<p>Szeretnénk felhívni a figyelmét az <a href='http://www.adlibrum.hu/konyvkiadas/konyvkiadas-sikerkereso-szerzoknek/'>Aktív szerző könyvkiadási programra</a>, amely piacképes kézirattal rendelkező agilis szerzőknek ad lehetőséget.</p>".
			"<p>Az Ad Librum kiadóinak novemberi megjelenései:</p>
			<p><a title='Kattintson ide a könyv bővebb leírásáért!' href='http://www.adlibrum.hu/katalogus/cedula/?id=643'>Pintér Zoltán: Vetkőző lelkek (Expert Books)</a></p>
			<p><a title='Kattintson ide a könyv bővebb leírásáért!' href='http://www.adlibrum.hu/katalogus/cedula/?id=536'>Bárdos Erika: Az önismeret a harmonikus élet kulcsa. Asztrológiai kézikönyv (Ad Librum Kiadó)</a></p>
			<p><a title='Kattintson ide a könyv bővebb leírásáért!' href='http://www.adlibrum.hu/katalogus/cedula/?id=649'>Mester Györgyi: Felnőttmesék. Kifestőkönyv (Ad Librum Kiadó)</a></p>".
			"<p>Az alábbiakban küldjük a könyve eddigi forgalmával kapcsolatos adatokat. Az adatok a kiadói eladások esetén naprakészek, a bizományosi forgalom esetén pedig a kereskedők által leadott utolsó fogyási jelentésekben közölteket tartalmazzák.</p>".
			"<p>Kánikula ide vagy oda, az Ad Librum már a karácsonyra készül, hogy az új kötetei az év legfontosabb könyvkereskedelmi szezonja kezdetén jelenjenek meg. Aktuális kiadási akciónk, a <a href='http://www.adlibrum.hu/konyvkiadas/120-oldalas-konyvek-kiadasa/'>120 oldalas program</a> sok jelentkezőt vonzott, többet be is fogadtunk. A program hivatalosan ma véget ért, de a korábbi szerzőinktől pár napig még fogadunk jelentkezéseket.</p>".
			"<p>Hamarosan új kiadási akcióval jelentkezünk, amiről értesülhetnek a hírlevelünkből vagy a kiadó Facebook oldalán (<a href='https://www.facebook.com/adlibrum/'>fb.com/adlibrum</a>). Az akcióhoz kapcsolódik a <a href='https://www.facebook.com/szemelyestortenelem/'>Személyes történelem</a> Facebook oldalunk is, amely az élettörténetek és családi emlékek megírásával foglalkozik (<a href='https://www.facebook.com/szemelyestortenelem/'>fb.com/szemelyestortenelem</a>).</p>".
			"<p><a href='http://konyv.guru/szemelyes-guru/orokitse-meg-csaladja-tortenetet-10-ora-alatt/'>Itt</a> pedig kiderül, hogyan örökítheti meg személyes vagy családi emlékeit 10 óra alatt.</p>".
			"<p>Az Ad Librum Kft. standja idén <strong>a 21-es pavilonban lesz a könyvhéten a Vörösmarty téren 2016. június 9. és 13. között</strong> (jövő csütörtök-hétfő). <a href='http://www.adlibrum.hu/ad-librum-dedikalasok-a-konyvheten/'>Kilenc szerzőnk fog dedikálni</a>.</p>".
			"<p>A könyvhétre több olvasmánnyal jelentkezik az Ad Librum Kiadó <a href='http://adlibrum.hu/cedula.php?id=550'>Villax Richárd hungarohorrorjától</a> <a href='http://adlibrum.hu/cedula.php?id=552'>Wanderer János</a> és <a href='http://adlibrum.hu/cedula.php?id=575'>Rinyai László</a> történetein át <a href='http://adlibrum.hu/cedula.php?id=537'>Barczikay Lilla ifjúsági fantasyjáig</a>. A nyelvtanulóknak kínál lehetőséget <a href='http://adlibrum.hu/cedula.php?id=576'>Mester Györgyi kétnyelvű mesekönyve</a>. Szintén a könyvhétre jelenik meg <a href='http://adlibrum.hu/cedula.php?id=578'>Dr. Babós Lajos történelmi dokumentumgyűjteménye</a> az első 48-49-es vértanúról.</p>".
			"<p>Az Ad Librum Kft. új kiadója, az Expert Books a közeli napokban jelenteti meg <a href='http://adlibrum.hu/cedula.php?id=538'>Tarajosvilág</a> címen a kezdőknek és profiknak is hasznos baromfitenyésztési szakkönyvét. Ezzel egyidejűleg elindult a <a href='http://kisallattenyesztes.hu/'>Kisállattenyésztés.hu</a>, amely tanácsokkal látja el a hobbinyúl, baromfi és víziszárnyas tenyésztőket.</p>".
			"<p><strong>Szeretnénk felhívni a figyelmét a Könyv Guru portál <a href='http://konyv.guru/konyv-guru-novellapalyazatot-hirdet/'>novellapályázatára</a>, amelyen a legjobb írások értékelést és nyilvánosságot kapnak.</strong></p>".
			"<p>Szintén Könyv Guru szervezi a kerekasztalt a könyvhéten június 12. vasárnap 13 órától, amely a memoárírásról lesz <a href='https://www.facebook.com/events/560696140778654/'><em>Közkinccsé tett magántörténelem</em></a> címmel.</p>".
			"<p><strong><a href='https://app.mailerlite.com/webforms/landing/s1r6b8'>Iratkozzon fel a hírlevelünkre a rendszeres kiadói hírekért és könyvkiadási ajánlatokért!</a></strong></p>".
			"<p>Ebben a hónapban kiadtuk Robin O'Wrightly <a href='http://adlibrum.hu/cedula.php?id=574'>kemény történeteit</a> (az egyik folytatásokban olvasható a <a href='http://konyv.guru/regenyujsag-alomtalanitas-1-resz/'>Könyv Gurun</a>), egy <a href='http://adlibrum.hu/cedula.php?id=572'>amerikai antológiát</a>, a Fülöp lovag <a href='http://adlibrum.hu/cedula.php?id=570'>folytatását</a> és Mester Györgyi <a href='http://adlibrum.hu/cedula.php?id=573'>hatodik novelláskötetét</a>.".
			"<p>Könyv Guru <a href='http://konyv.guru/category/konyvkiadasi_tanacsok/konyviras/'>számos újabb érdekességet</a> ajánl az írók számára</a> <a href='http://konyv.guru/krisz-otletei-agatha-christie-12-titka-infografikan/'>Agatha Christie írástechnikájától</a> az <a href='http://konyv.guru/irokepzo-muhelyek-mezey-katalin-tanacsai-tollforgatoknak/'>Íróiskola bemutatásán</a> át a <a href='http://konyv.guru/10-ok-amiert-mindenkinek-meg-kellene-irnia-a-memoarjat/'>memoárírás motivációjáig</a>.".
			"<p>Az alábbi partnerboltjainkban ez évtől folyamatosan megtalálható az Ad Librum kiadásában megjelent könyvekből 20-40 fajta:</p>
			<ul>
				<li><em>Polihisztor Könyvesbolt</em> 1053 Budapest, Múzeum krt 29. (A Nemzeti Múzeummal szemben)</li>
				<li><em>Universitas – SZTE Jegyzetbolt</em> 6722 Szeged, Ady tér 10. (A Szegedi Tudományegyetem Kongresszusi Központjának épületében)</li>
				<li><em>Sziget Könyvesbolt</em> 4032 Debrecen, Egyetem tér 1.</li>
				<li><em>Alternatív Könyvesbolt</em> 4025 Debrecen, Hatvan u. 1/a. (A Déry Múzeum és a Hittudományi Egyetem közelében)</li>
				<li><em>Lyra Könyvesház Kft.</em> 2600 Vác, Piac u. 1.</li>
			</ul>
			<p>A következő hónapokban újabb boltokkal szerződünk a kiadó könyveinek nagykereskedői forgalmazástól független terjesztése érdekében.</p>
			<p>A kiadói iroda ügyfélfogadási ideje: minden munkanap 9 és 13 óra között. Címünk: 19. ker. Klapka u. 26. (számlázási és postacím is).</p>".
			*/
			//"<p>Az alábbiakban küldjük a könyve forgalmával kapcsolatos adatokat, amely a viszonteladói forgalom 2014. december 31-i állapotát tükrözi.</p>".
			// ellenőrizni: Bóta G., Kiss Sarolta
			#"<p><a href='http://impakt.hu'>Impakt</a> néven különálló, specializált könyvmarketing szolgáltatást hoztunk létre, amely a következő hónapokban számos lehetőséget kínál majd a könyvek megismertetésére. Bevezetésként október 30-ig <a href='http://impakt.hu/jekyll/update/2015/09/30/kis_marketing_csomag.html'>az első csomagot</a> a korábbi szerzőinknek 50%-os kedvezménnyel kínáljuk, amelyet akár három részletben (3x25.000 Ft) is ki lehet egyenlíteni. A kedvezményt a régebben és nem az Ad Librumnál megjelent könyvekre is lehet érvényesíteni. A jelentkezéshez vagy érdeklődéshez egyszerűen válaszoljon erre az emailre.</p>".
			/*
			"<p><em>Írd helyesen az idegen neveket, mint például azt, hogy Beaudelaire, Roosewelt, Niecse és így tovább.</em></p>
			<p>Ez <a href='http://konyv.guru/hogyan-kell-jol-irni-umberto-eco-tanacsai/' target='_blank'>Umberto Eco egyik vidám könyvírási tanácsa</a>, amelyet Könyv Guru idézett fel az egyik e havi posztjában. Amelyet számos másik követett a <a href='http://konyv.guru/hogy-dolgoztak-a-nagyok-hires-irok-napi-penzuma/' target='_blank'>híres írók napi írásmennyiségéről</a> és <a href='http://konyv.guru/igy-irnak-ok-klasszikusok-napirendje/' target='_blank'>időbeosztásáról</a>, a <a href='http://konyv.guru/krisz-otletei-irjunk-meg-konyvcimet/' target='_blank'>könyvcím</a> és <a href='http://konyv.guru/krisz-otletei-irjunk-fulszoveget/' target='_blank'>fülszövegírás titkairól</a> és a <a href='http://konyv.guru/a-hatasos-recenziok-titka-10-egyszeru-lepesben/' target='_blank'>hatásos recenziók írásáról</a>. Mester Györgyi, az Ad Librum szerzője pedig a saját <a href='http://konyv.guru/nem-torom-a-fejem-hogy-feltetlenul-kipasszirozzak-magambol-valamit/' target='_blank'>írási módszereiről beszélt</a>. Érdemes figyelni a Könyv Guru portál cikkeit, esetleg <a href='http://konyv.guru/mit_kell_tudni_konyv_gururol/hirlevel/' target='_blank'>feliratkozni a hírlevelére</a>. Köszönettel továbbítjuk, ha Ön is hozzá tudna járulni egy írással a könyves portálhoz.</p>
			<p>Szintén a Könyv Guru portálon jelenik meg 13 részben az Álomtalanítás című regény, amelyet az Ad Librum március első felében <a href='http://www.konyvesbolt.online/Robin-OWrightly-Alomtalanitas-Ad-Librum-2016' target='_blank'>jelentet meg nyomtatásban</a>. Ha Ön is szeretné egy korábban megjelent (vagy eddig nem is publikált) regényét vagy ismeretterjesztő könyvét ily módon közkinccsé tenni, jelezze egy válaszlevélben! Kiváló alkalom a sorozatban íróknak, hogy felhívják a figyelmet a többi kötetükre, és azoknak is jó lehetőség, akik könyve nyomtatásban már kifutott.</p>".
			"<p>Szeretnénk ismételten jelezni, hogy az Ad Librum könyvesboltja ezentúl a <a href='http://www.konyvesbolt.online/' target='_blank'>Könyvesbolt.Online</a> címen található.</p>".
			"<p>Felhívjuk figyelmét a <a href='http://konyv.guru' target='_blank'>Könyv Guru</a> könyves portálra, amely naponta közöl érdekes és hasznos információkat a könyvek világából. Januárban egyik sokkönyves szerzőnkkel, Mester Györgyivel készült itt interjú, amelynek <a href='http://konyv.guru/interju_mester_gyorgyi_novellairo/' target='_blank'>szöveges változata</a> is megjelent, valamint a hanganyaga a portál  <a href='https://www.youtube.com/channel/UC8kcGNeMeSr6uPJOTVJAu4w' target='_blank'>YouTube csatornáján</a> meghallgatható. A portálon ezen túl az írókat érdeklő egyéb cikkek is megjelentek a <a href='http://konyv.guru/5-tanacs-szerzoknek-a-konyvborito-tervezesehez/' target='_blank'>borítókészítéssel kapcsolatos tanácsokról</a>, a <a href='http://konyv.guru/7_szorakoztato_modszer_az_iroi_valsag_lekuzdesehez/' target='_blank'>fehérpapírgörcs leküzdéséről</a> és az <a href='http://konyv.guru/a_bestseller_szerzok_es_a_tobbiek/' target='_blank'>írók jövedelméről</a>. Érdemes a Könyv Guru hírlevélre feliratkozni.</p>
			<p>A tudományos könyvek kiadását 2016-tól <a href='http://stormingbrain.hu' target='_blank'>StormingBrain</a> név alatt folytatjuk szabad hozzáférésű (open access) modellben.</p>
			<p>Az Ad Librum könyvei a <a href='http://konyvesbolt.online' target='_blank'>Könyvesbolt.online</a> webboltban vásárolhatóak meg.</p>".
			"<p>Az alábbiakban küldjük a könyve eddigi forgalmával kapcsolatos adatokat. Az adatok a kiadói eladások esetén naprakészek, a bizományosi forgalom esetén pedig a kereskedők által leadott utolsó fogyási jelentésekben (általában az előző hónap utolsó napjáig tartó fogyás) közölteket tartalmazzák.</p>".
			/*
			"<p>Állandó nagykereskedelmi partnerünk, a Líra nagyker közreműködése számos előnyt biztosít. Mindazonáltal a könyveink elhelyezésére kevés befolyásunk van, így nehezen követhető, melyik boltba kerülnek, és nem tudunk hatást gyakorolni arra sem, meddig maradnak a polcokon. Ezért kezdtünk kiépíteni egy saját partnerbolt-hálózatot, ahol minden új és néhány régi könyvünk garantáltan elérhető lesz. A megmaradt kevés független könyvesboltból sikerült már szerződni szegedi, győri, debreceni és váci partnerrel, és reményeink szerint a jövő év elején az egész országot le tudjuk fedni.</p>
			<p>Néhány éve próbálkoztunk a könyveink terjesztésével ebook formában. Akkor a magyarországi e-könyv kereskedelem túlságosan éretlennek bizonyult. Most új lendületet veszünk, és lehetővé tesszük, hogy a jelenlegi legfontosabb ebook kereskedőknél az Ad Librum kiadványok elérhetőek legyenek. A tervezett terjesztők listáján szerepel a Google Play Books, az iTunes, a Buchhandlung, a Libri, a Multimédiaplaza, a Bookline, a Digitalbooks, a Scribd és a Kobo. A következő hónapokban folyamatosan fogjuk keresni azokat a szerzőinket, akik könyveinek terjesztését ilyen módon is gondoljuk megszervezni. Kérjük, hogy akit máris érdekel a lehetőség, írjon nekünk emailt!</p>
			<p>A kiadó újjászervezésének része a raktárak összevonása és teljes felleltárazása. A jobb raktározásnak egyik sajnálatos mellékhatása, hogy többet kell fizetnünk érte. Kezdeményezzük ezért az előfinanszírozott kiadásból nálunk maradt és régóta nem mozduló könyvek visszaadását a tulajdonosoknak. Egyenként keressük ez ügyben az érintett szerzőket. Van lehetőség további bérraktározásra is, de sajnos nem díjmentesen.</p>"
			"<p>Új könyveink:
			<ul>
			<li><a href='http://adlibrum.hu/new/index.php?task=pageDetails&id=527'>Chris Iveson, Evan George, Harvey Ratner: Brief Coaching</a></li>
			<li><a href='http://adlibrum.hu/new/index.php?task=pageDetails&id=522'>Jóba Katalin: Cinegemese</a></li>
			<li><a href='http://adlibrum.hu/new/index.php?task=pageDetails&id=521'>Bárdosi Attila és Reglődi Dóra: Válaszok a válaszokra</a></li>
			<li><a href='http://adlibrum.hu/new/index.php?task=pageDetails&id=525'>Frank Karsten és Karel Beckman: Túl a demokrácián</a></li>
			<li><a href='http://adlibrum.hu/new/index.php?task=pageDetails&id=524'>P. Tarator: Széllel szemben</a></li>
			<li>Gábor Kerekes: Literatur diesseits und jenseits des Rennweg. Studien zur österreichischen Literatur</li>
			<li>Gábor Kerekes: Bewahrte Traditionen und neue Horizonte</li>
			</ul></p>".
			*/
			//"<p>A korábbi webboltunkat (shop.adlibrum.hu) megszüntettük, az <a href='http://adlibrum.hu/new/index.php?task=shop'>új weboldalunkon</a> egységes felületen lehet keresni, informálódni és vásárolni. A régi információs honlapot is hamarosan lekapcsoljuk, és csak az <a href='http://adlibrum.hu/new/index.php?task=about'>új</a> lesz látható. Remélhetőleg ezzel az elérési problémák is megoldódnak.</p>".
			//"<p>Újra ajánljuk az <a href='http://adlibrum.hu/new/index.php?task=postfinanced'>ingyenes kiadási programunkat</a>, egyelőre kiadói terjesztésben. További információk <a href='http://adlibrum.hu/new/index.php?task=postfinanced'>honlapunkon</a>.</p>".
			//"<p>Január folyamán többször érkezett panasz, hogy az <a href='http://adlibrum.hu/new'>adlibrum.hu</a> nem volt elérhető. A hiba sajnos teljesen rendszertelenül jelentkezett, így a szolgáltatónk felé nehéz volt bizonyítani. Kérjük, hogy ha ilyet tapasztal, jelezze nekünk (esetleg képernyőképpel) az <a href='mailto:info@adlibrum.hu'>info@adlibrum.hu</a> címen!</p>".
			//"<p>Felhívjuk azok figyelmét, akik előfinanszírozott kiadásban leárazták a könyvüket, hogy a rendszer továbbra is az eredeti fogyasztói árból számolja a részesedésüket, így nem pontos az erre vonatkozó összesítés.</p>".
			//"<p>A postacímünk az iroda címe (1191 Budapest, Bethlen G. u. 32.), kérjük, közvetlenül ide címezzék leveleiket.</p>".
			#"<p>Az Ad Librum irodája a XIX. kerület, Bethlen Gábor u. 32. címen (<a href='http://goo.gl/maps/p116b'>térkép</a>) található, ugyanez a postacímünk is. A számlákon és szerződéseken azonban továbbra is az 1107 Budapest, Mázsa tér 2-6. címet kell szerepeltetni.</p>".
			/*
			"<p>Mindenekelőtt sikerekben gazdag, boldog új évet kívánunk!</p>".
			"<p>Irodánk január 23-ig éves szabadság miatt zárva tart. Ez alatt a személyes könyvkiadás szünetel, a postázás pedig a könyveink egy körére szorítkozik. A legsürgősebb ügyekben e-mailen lehet választ kérni.</p>".
			"<p>Az Ad Librum irodája a X. kerületi Mázsa térről a november folyamán átköltözött a XIX. kerület, Bethlen Gábor u. 32. címre (<a href='http://goo.gl/maps/p116b'>térkép</a>).
			Az új iroda a Köki Terminál közelében van, a Kőbánya-Kispest metró- és vasútállomástól pár perc gyaloglásra. A postacímünk az iroda címe (1191 Budapest, Bethlen G. u. 32.) lett,
				a székhely- és számlázási címünk azonban továbbra is a régi (1107 Budapest, Mázsa tér 2-6.).</p>".
			 */
			#<hr/>
			"<h2>KÖNYVADATOK</h2>".
		"<p>SZERZŐ: ".$sor['author']."</p>".
		"<p>CÍM: ".$sor['title']."</p>".
		"<p>KÖNYVÁR: ".$sor['price']." Ft</p>".
		"<p>WEBOLDAL: <a href='http://$web'>$web</a></p>\n".
		//"<p>WEBBOLT: ".$sor['link_webshop']."</p>".
		"<h2>FORGALOM</h2><table>".
		"<tr><td>A kiadóból eladott könyvek száma:</td><td>".$t['soldweb'].
		" példány, amiből a megrendelők már kifizettek ".$t['soldwebpaid']." példányt.</td></tr>".
		"<tr><td>Viszonteladón keresztül eladott könyvek száma:</td><td>".$t['soldreseller'].
		" példány, amiből a kereskedők már kifizettek ".$t['soldresellerpaid']." példányt.</td></tr>";
		if ($t['sponsor']==1 or $t['sponsor']==4) {
			$letter .= "<tr><td>Szerzőnek:</td><td>".$t['soldauthor']." példány</td></tr>".
				"<tr><td>Egyéb (köteles-, marketing-, tiszteletpéldányok):</td><td>".($t['freecopy']+$t['tolibraries'])." példány</td></tr>".
				"<tr><td>Eddigi teljes forgalom:</td><td>".$t['totalsold']." példány</td></tr>";
		} else {
			$letter .= "<tr><td>Szerzőnek:</td><td>".$t['soldauthor']." példány, amiből már kifizetve ".$t['soldauthorpaid']." példány</td></tr>".
				"<tr><td>Egyéb (köteles-, marketing-, tiszteletpéldányok):</td><td>".($t['freecopy']+$t['tolibraries'])." példány</td></tr>".
				"<tr><td>Eddigi teljes forgalom:</td><td>".$t['totalsold']." példány (ebből a kiadónak már kifizetve ".$t['totalsoldpaid']." példány)</td></tr>";
		}
		$letter .= "</table>\n";
		$royalty=round($t['royaltyresellersumpaid']+$t['royaltywebshopsumpaid']);
		$royaltyexpected=round($t['royaltyresellersum']+$t['royaltywebshopsum']);
		$royaltyremained=$royalty-$s['royaltypaid'];
		$royaltyremainedexpected=$royaltyexpected-$s['royaltypaid'];
		$totalin=$t['fromprinter']+$t['toconsignment'];
		$invreseller=$t['toreseller']-$t['fromreseller']-$t['soldreseller'];
		$invpublisher=$totalin-$t['toreseller']+$t['fromreseller']-$t['soldweb']-$t['soldauthor']-$t['tolibraries']-$t['freecopy'];
		$invtotal=$invreseller+$invpublisher-$t['tounknown'];
		if ($t['sponsor']==1 or $t['sponsor']==4) {
			$letter .= "<h2>BIZOMÁNYOSI RÉSZESEDÉS (áfa nélküli összegek)</h2><table>".
			"<tr><td>A kiadóból eladott könyvek:</td><td>".round($t['royaltywebshopsumpaid']).
				" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)</td></tr>".
			"<tr><td>A viszonteladón keresztül eladott könyvek:</td><td>".
				round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)</td></tr>".
			"<tr><td>Összes részesedés:</td><td>$royalty Ft (várhatóan: $royaltyexpected Ft)</td></tr>".
			"<tr><td>Eddig kifizetett/levont részesedés:</td><td>".$s['royaltypaid']." Ft</td></tr>".
			"<tr><td>Összegyűlt részesedés:</td><td>$royaltyremained Ft (várhatóan: $royaltyremainedexpected Ft)</td></tr>".
			"<tr><td>Még bizományos kezelésben az Ad Librumnál:</td><td>$invtotal példány</td></tr>".
			"</table>\n";
		} else {
			$royalty=$t['royaltyresellersumpaid']+$t['royaltywebshopsumpaid'];
			$royaltyexpected=$t['royaltyresellersum']+$t['royaltywebshopsum'];
			$royaltyremained=$royalty-$s['royaltypaid'];
			$royaltyremainedexpected=$royaltyexpected-$s['royaltypaid'];
			$letter .= "<h2>JOGDÍJ (áfa nélküli és adózás előtti összegek)</h2><table>".
			"<tr><td>A kiadóból eladott könyvek:</td><td>".round($t['royaltywebshopsumpaid']).
				" Ft (várhatóan: ".round($t['royaltywebshopsum'])." Ft)</td></tr>".
			"<tr><td>A viszonteladón keresztül eladott könyvek:</td><td>".
				round($t['royaltyresellersumpaid'])." Ft (várhatóan: ".round($t['royaltyresellersum'])." Ft)</td></tr>".
			"<tr><td>Eddigi összes jogdíjjogosultság:</td><td>$royalty Ft (várhatóan: $royaltyexpected Ft)</td></tr>".
			"<tr><td>Eddig kifizetett/levont jogdíj:</td><td>".$s['royaltypaid']." Ft</td></tr>".
			"<tr><td>Jelenlegi jogdíjjogosultság:</td><td>$royaltyremained Ft (várhatóan: $royaltyremainedexpected Ft)</td></tr>";
			if ($royaltyremained>10000) {
				$taxable=$royaltyremained*100/127;
				$taxable=round($taxable*.1+$taxable*.9*.84);
				$taxableexpected=round($royaltyremainedexpected*100/127);
				$taxableexpected=round($taxableexpected*.1+$taxableexpected*.9*.84);
				$letter .= "<tr><td>Adó- és járuléklevonás utáni, kifizethető nettó jogdíj:\n\t$taxable Ft (várhatóan: $taxableexpected Ft)</td></tr>";
				}
			$letter .= "</table>\n";
		}
		if ($t['sponsor'] == 2) {
			$p=array("- -","Havi","Negyedévi","Félév+negyedév","Elővásárlás+félévi","Letét+félévi");
			$contracttype=$sor['contracttype'];
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
			if ($expected>$t['contracted']) {$expected=$t['contracted'];}
			if ($t['datepuby']<2016) {$sofar=$t['totalsold'];} else {$sofar=$t['soldweb']+$t['soldreseller']+$t['soldauthor'];}
			$expectedpurchase=$expected-$sofar;
			if ($expectedpurchase>0) {
					$ep="$expectedpurchase példány";
					if ($t['datepuby']==2016) {
						//a 2016-os, 70%-os elvárt árú kiadások
						$expectedpurchaseprice=$expectedpurchase*$t['price']*.7;
						$epp="$expectedpurchaseprice Ft ($expectedpurchase pld. x ".$t['price']." Ft x 70%)";
					} else {
						//a régebbi, 50%-os elvárt árú kiadások
						$expectedpurchaseprice=$expectedpurchase*$t['price']*.5;
						$epp="$expectedpurchaseprice Ft ($expectedpurchase pld. x ".$t['price']." Ft x 50%)";
					}
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
			$letter .= "<h2>ELVÁRT FORGALOM</h2><table>".
				"<tr><td>Vállalt forgalom</td><td>".$t['contracted']." példány</td></tr>".
				"<tr><td>Szerződéstípus</td><td>".$p[$contracttype]." elszámolás az elvárt forgalomról</td></tr>".
				"<tr><td>Eddig eltelt idő:</td><td>$months teljes hónap / $quarters teljes negyedév</td></tr>".
				"<tr><td>Eddigi elvárt forgalom:</td><td>$expected példány</td></tr>".
				"<tr><td>Eddigi tényleges forgalom:</td><td>$sofar példány</td></tr>".
				"<tr><td>Az elvárt forgalomhoz szükséges szerzői vásárlás:</td><td>$ep</td></tr>".
				"<tr><td>Az elvárt forgalomhoz szükséges szerzői vásárlás teljes összege:</td><td>$epp</td></tr>".
				"<tr><td>A szerzői jogdíjról való lemondás esetén a tartozás:</td><td>$eppp</td></tr>".
				"</table>";
		}
		$letter .= "<h2>MEGJEGYZÉSEK</h2>";
		if ($expectedpurchase>0) {
			$letter .= "<ol>
				<li>Kérjük jelezzen vissza, hogy a példányokat hova postázzuk!</li>".
/*				"<li>Amennyiben a forgalom alakulása alapján úgy ítéli meg, hogy elővásárlással akarja elkerülni az elvárt forgalomhoz szükséges jövőbeni vásárlásokat vagy egy lépésben le szeretné zárni a kötelezettségeit, kérjen tőlünk ajánlatot! (Az egyben megvett példányokat kérésre bizományba vesszük, és tovább forgalmazzuk 40%-os visszatérítéssel.)</li>".
				"<li>Ha a szerző az összegyűlt jogdíjáról lemond, az elvárt forgalomhoz szükséges szerzői vásárlás összege a jogdíjnak megfelelő összeggel csökkenthető. Ebben az esetben jogdíjba a kiadónak még ki sem fizetett értékesítéseket is beleszámoljuk, vagyis a maximális lehetséges jogdíjat. Egyes esetekben ez szerződésmódosítást igényelhet, amiről külön értesítjük.</li>".
				*/
				"<li>A kiadás hónapjára nem számolunk elvárt forgalmat, csak az azt követő teljes hónaptól. Csak teljes periódusokra (hónapok vagy negyedévek) számoljuk a forgalmi elvárást.</li>".
				 "<li>A jogdíjból lehetnek előre egyeztetett levonások (pl. postaköltség, korrektúra költsége, könyvheti reklám).</li>".
				 "</ol>";
		} else {
				if ($t['sponsor'] == 2) {$letter .= "<p>Önnek nincs az elvárt forgalommal kapcsolatos kötelezettsége. A jogdíjból lehetnek előre egyeztetett levonások (pl. postaköltség, korrektúra költsége, könyvheti reklám).</p>";}
				if ($t['sponsor'] == 1) {$letter .="<p>A példányok az Ön tulajdonát képezik, az Ad Librumnál levő példányok bizományosi kezelésben vannak. A fenti adatok az Ad Librum kezelésébe vett példányok forgalmáról szólnak, előre jelezve a kereskedők által már lejelentett, de még ki nem fizetett példányokat is. A ténylegesen befolyt részesedését ($royaltyremained forintot) kérésére egy megállapodás keretében fizetjük ki, amennyiben a szerződési feltételek lehetővé teszik (függhet pl. a kiadás kezdetétől eltelt időtől és vagy meghatározott minimumösszeg elérésétől). Ha a kiadási szerződést  cég vagy vállalkozó kötötte, (5%-os áfa hozzáadásával) számlát várunk.</p>";}
		}
		$letter .= "<p>Előfordulhat, hogy a könyvéről több fogyási jelentést is kap. Egyrészt a digitális (ebook) kiadást külön könyvként kezeljük, másrészt - az eltérő jogdíjelszámolás miatt - külön leltárt vezetünk azokra a példányokra, amelyeket a szerző a kiadói (POD vagy ingyenes) példányok megvétele után bizományos forgalmazásra ad nekünk.</p>";
		if ($sor['overdue']==1) {$letter .= "<p class='threat'>LEJÁRT TARTOZÁSA VAN! KÉRJÜK, A LEHETŐ LEGHAMARABB EGYENLÍTSE KI, MERT HAMAROSAN FIZETÉSI MEGHAGYÁST ÉS VÉGREHAJTÁST KEZDEMÉNYEZÜNK!</p>";}
		$letter .= "<hr/><p class='small'>
				Ad Librum Kft.<br/>
				Cím: <a href='https://goo.gl/maps/aGjKj'>1193 Budapest, Klapka u. 26.</a> (székhely-, posta-, irodai és számlázási cím is)<br/>
				Cégjegyzékszám: 01-09-888596<br/>
				Adószám: 14093818-3-42<br/>
				Bankszámlaszám: 10400157-00020656-00000005<br/>
				www.adlibrum.hu</p>";
		$letter2=$letter;
		$letter2=str_replace("é","e",$letter2);
		$letter2=str_replace("á","a",$letter2);
		$letter2=str_replace("ö","o",$letter2);
		$letter2=str_replace("ó","o",$letter2);
		$letter2=str_replace("ő","o",$letter2);
		$letter2=str_replace("ü","u",$letter2);
		$letter2=str_replace("ű","u",$letter2);
		$letter2=str_replace("ú","u",$letter2);
		$letter2=str_replace("í","i",$letter2);
		$letter2=str_replace("É","E",$letter2);
		$letter2=str_replace("Á","A",$letter2);
		$letter2=str_replace("Ö","O",$letter2);
		$letter2=str_replace("Ó","O",$letter2);
		$letter2=str_replace("Ő","O",$letter2);
		$letter2=str_replace("Ű","U",$letter2);
		$letter2=str_replace("Ü","U",$letter2);
		$letter2=str_replace("Ú","U",$letter2);
		$letter2=str_replace("Í","I",$letter2);

		$mailreport[$idbook]['letter']="<p class='small'>[Ha rosszul latszanak az ekezetes betuk, irjon nekunk egy e-mailt (info@adlibrum.hu)!]</p>\n".$letter;//."\n\n====================\n\n".$letter2;
		$mailreport[$idbook]['book']=$sor['author'].": ".$sor['title'];
		$mailreport[$idbook]['author']=$sor['author'];
		$mailreport[$idbook]['emailaddress']=$sor['author_email'];
		$mailreport[$idbook]['idbook']=$idbook;
		#print "<pre>".$mailreport[$idbook]."</pre>";
		}
	return $mailreport;
}

function statReportCircularLetterSending() {
	print "<h1>LEVELEK KÜLDÉSE</h1>";
	global $db;
	$sql=$_POST['sql'];
	$mailreport=statReportMailreport($sql);
	global $datem;
	// Always set content-type when sending HTML email
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
	// More headers
	$headers .= "From: <info@adlibrum.hu>" . "\n";
	$headers .= "Cc: info@adlibrum.hu" . "\n";
/*
	$headers = "
		MIME-Version: 1.0\n
		Content-type:text/html;charset=utf-8\n
		From: <info@adlibrum.hu>\n
		Cc: info@adlibrum.hu\n";
*/

require 'phpmailer/PHPMailerAutoload.php';

	foreach ($mailreport as $mail) {
		print "<p><b>".$mail['book']."</b></p>";
		print "<p>".$subject."</p>";
		$idbook=$mail['idbook'];
		$to = $mail['emailaddress'];
		$author = $mail['author'];
		#$subject = iconv("UTF-8", "ISO-8859-2","Ad Librum fogyási jelentés 2017. ".bookParameters("months",$datem)." [#".$idbook."]");
		$subject = "Ad Librum fogyási jelentés 2017. ".bookParameters("months",$datem)." [#".$idbook."]";
		//$subject = "Ad Librum fogyási jelentés [#".$idbook."]";
		//$subject = "Ad Librum fogyási jelentés 2015. ".bookParameters("months",$datem)." [#".$idbook."]";
		$body = $mail['letter'];
		$message = "
			<html>
			<head>
				<title>Fogyási jelentés</title>
				<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />
				<style type='text/css'>
					h1 { color: darkgreen; }
					h2 { color: darkgreen; }
					table { padding: 5pt; }
					.small { font-size: small; color: grey; }
					.center { align: center; }
					.threat { color: darkred; }
				</style>
			</head>
			<body>
				$body
			</body>
			</html>";

			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();
			//$mail->SMTPDebug = 2;
			//$mail->Debugoutput = 'html';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = "info@adlibrum.hu";
			$mail->Password = "alex.Is";
			$mail->setFrom("info@adlibrum.hu", "Ad Librum kiadók");
			$mail->addReplyTo("info@adlibrum.hu", "Ad Librum kiadók");
			$mail->addAddress($to, $author);
			$mail->addAddress("info@adlibrum.hu", "irattár"); //így működik
//			$mail->addCustomHeader("BCC: soos.gabor@adlibrum.hu");
			$mail->Subject = $subject;
			$mail->msgHTML($body);
			if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<p>A fogyási jelentés sikeresen elküldve a $to címre!</p>";
}

		//mail($to,$subject,$message,$headers) or die("Nem sikerült a levél kiküldése $to-nak!");
		//print "<p>A fogyási jelentés sikeresen elküldve a $to címre!</p>";
	}
}

?>
