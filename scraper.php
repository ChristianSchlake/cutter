<?php
	include("sub_init_database.php");
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8"/>
	<meta name="viewport" content="width=device-width">

	<?php
		echo "<title>TV-Scraper</title>";
	?>

	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="icons/foundation-icons.css"/>
</head>

<body>



<?php	
/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
/* Variablen eintragen */
	$anzahlSeitenZurueck=1;
//	print_r($_GET);
	$ausfuehren="1";
	foreach ($_GET as $key => $value) {
		switch ($key) {
			case 'anzahlSeitenZurueck':
				$anzahlSeitenZurueck=$value;
				break;
			case 'serienID':
				$serienID=$value;
				$abfrage="SELECT serienURL, serien FROM serien WHERE serienID=".$serienID;
				$ergebnis = mysql_query($abfrage);
				while($row = mysql_fetch_object($ergebnis)) {
					$serienURL=$row->serienURL;
					$serienName=$row->serien;
				}
				break;
			case 'ausfuehren':
				$ausfuehren=$value;
		}
	}
?>
<!--?php
	echo "<br> SerienID: ",$serienID;
	echo "<br> URL: ", $serienURL;
	echo "<br> Seiten: ", $anzahlSeitenZurueck;
	echo "<br> ausführen: ", $ausfuehren;
?-->

<nav class="top-bar" data-topbar data-options="is_hover:true">
	<ul class="title-area">
		<li class="name">
			<h1><a href="main.php"><i class="fi-refresh"></i> TV-Scraper</a></h1>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
</nav>

<div class=\"row">
	<fieldset>
		<?php
		echo "<legend>",$serienName,"</legend>";
		?>
		<table>
			<thead>
				<tr>
					<th>Sendetermin</th>
					<th>Uhrzeit</th>
					<th>Sender</th>
					<th>Staffel</th>
					<th>Episode</th>
					<th>Titel</th>
					<th></th>
				</tr>
			</thead>
			<body>
				<?php
					$anzahlNEU=0;
					$anzahlSeiten=0;
					$anzahlEintraege=0;
					for ($x = $anzahlSeitenZurueck; $x >= 1; $x--) {
						$MaxDateVon=mysql_query("SELECT MAX(datumVon) FROM DMS WHERE serien=\"".$serienID."\"");
						$MaxDateVon=mysql_fetch_array($MaxDateVon, MYSQL_BOTH);
						$MaxDateVon=$MaxDateVon[0];	
						$MaxDateVon=strtotime($MaxDateVon);
						$data=$serienURL."-".$x;
						$dom = new DomDocument;
						$dom->preserveWhiteSpace = FALSE;
						$dom->loadHTMLFile($data);
						$zeilen = $dom->getElementsByTagName('tr');
						$anzahlSeiten++;
						if (!is_null($zeilen)) {
							$z=0;
							foreach ($zeilen as $zeile) {
								$z++;
								$spalten = $zeile->getElementsByTagName('td');
								$i=0;
								$anzahlSpalten=$spalten->length;
								if ($anzahlSpalten>8 AND $z>1) {
									$anzahlEintraege++;							
									echo "<tr>";
									if (!is_null($spalten)) {
										
										foreach ($spalten as $spalte) {
											$i++;
											switch ($i) {
												case "2":
													//Sendetermin
													echo "<td>",$spalte->nodeValue,"</td>";
													$sendetermin=$spalte->nodeValue;
													break;
												case "3":
													//Uhrzeit
													echo "<td>",$spalte->nodeValue,"</td>";
													$sendeZeit=$spalte->nodeValue."'";
													break;
												case "4":
													//Sender
													echo "<td>",$spalte->nodeValue,"</td>";
													$insertStr=$insertStr.",'".$spalte->nodeValue."'";
													break;
												case "8":
													//Staffel
													echo "<td>",$spalte->nodeValue,"</td>";
													$insertStr=$insertStr.",'".str_replace(".","",$spalte->nodeValue)."'";
													break;
												case "9":
													// Episode
													echo "<td>",$spalte->nodeValue,"</td>";
													$insertStr=$insertStr.",'".$spalte->nodeValue."'";
													break;
												case "11":
													// Titel
													echo "<td>",$spalte->nodeValue,"</td>";
													$folge=$spalte->nodeValue;
													$insertStr=$insertStr.",'".$folge."'";
													break;
											}
										}
									}
									$sendeZeit=explode("–", str_replace(" ","–",$sendeZeit));
									$insertStr=$insertStr.",STR_TO_DATE('".$sendetermin."_".$sendeZeit[0]."','%d.%m.%Y_%H:%i')";
									$insertStr=$insertStr.",STR_TO_DATE('".$sendetermin."_".$sendeZeit[1]."','%d.%m.%Y_%H:%i')";
									$insertStr=$insertStr.",".$serienID;
									$insertStr=substr($insertStr, 1);
									$abfrage="INSERT INTO DMS (sender, staffel, episode, titel, datumVon, datumBis, serien) VALUES (".$insertStr.")";
									$DateVon=$sendetermin." ".$sendeZeit[0];
									$DateVon=strtotime($DateVon);
									if ($DateVon>$MaxDateVon) {								
		/*								echo "<br>--------------------------------";
										echo "<br> neu: ",$anzahlSpalten;
										echo "<br> neu: ",$folge;
										echo "<br> VON ",date("d.m.Y H:i",$DateVon);
										echo "<br> MAX ",date("d.m.Y H:i",$MaxDateVon);
										echo "<br>".$abfrage;
										echo "<br>--------------------------------";
		*/
										$anzahlNEU++;										
										echo "<td>NEU</td>";
										if ($ausfuehren=="1") {
											$eintragen = mysql_query($abfrage);	
										}
										
									} else {
										echo "<td></td>";
									}
									$abfrage="";
									$insertStr="";
									echo "</tr>";
								}
							}			
						}
					}
				?>
			</tbody>
		</table>
	</fieldset>
</div>
<div class=\"row">
	<fieldset>
		<legend>Statistik</legend>
		<table>
			<body>
				<tr>
					<td>Anzahl der Seiten</td>
					<?php
						echo "<td>",$anzahlSeiten,"</td>";
					?>
				</tr>
				<tr>
					<td>Anzahl der Folgen</td>
					<?php
						echo "<td>",$anzahlEintraege,"</td>";
					?>
				</tr>
				</tr>
					<td>Folgen pro Seite</td>
					<?php
						echo "<td>",$anzahlEintraege / $anzahlSeiten,"</td>";
					?>
				</tr>
				</tr>
					<td>Anzahl der neuen Folgen</td>
					<?php
						echo "<td>",$anzahlNEU,"</td>";
					?>
				</tr>				
			</body>
		</table>
	</fieldset>		
</div>
<?php
	mysql_close($verbindung);
?>


  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script>$(document).foundation();</script>  

</body>