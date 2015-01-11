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
//	print_r($_GET);
	$ordner="/media/aufnahmen/";
	$dateitypen= array("mpg", "mkv");
	$serienID="-1";
	$serienName="";
	$serienDateiName="";
	$serienOrdner="";
	$rename="0";
	foreach ($_GET as $key => $value) {
		switch ($key) {
			case 'ordner':
				$ordner=$value;
				break;
			case 'serienID':
				$serienID=$value;
				$abfrage="SELECT serienDateiName, serien, serienOrdner FROM serien WHERE serienID=".$serienID;
				$ergebnis = mysql_query($abfrage);
				while($row = mysql_fetch_object($ergebnis)) {
					$serienDateiName=$row->serienDateiName;					
					$serienName=$row->serien;
					$serienOrdner=$row->serienOrdner;
				}				
				break;
			case 'rename':
				if ($value=="1") {
					$rename="1";
				}				
				break;
		}
	}
	if (substr($ordner,-1)!="/") {
		$ordner=$ordner."/";
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
	<section class="top-bar-section">
		<ul class="left">
			<a class="button secondary round" href="scanFiles.php" data-reveal-id="suchModal"><i class="fi-page-add"></i> Serie auswählen</a>
			executeCutListModal
			<?php
				echo "<a class=\"button secondary round\" href=\"scanFiles.php?ordner=".$ordner."&serienID=".$serienID."&rename=1\"><i class=\"fi-link\"></i> rename Files</a>";
				echo "<a class=\"button secondary round\" href=\"scanFiles.php?ordner=".$ordner."&serienID=".$serienID."\"><i class=\"fi-link\"></i> sicht aktualisieren</a>";
			?>
		</ul>
	</section>			
</nav>

<fieldset>
	<legend>Ordner</legend>
	<table>
		<thead>
			<tr>
				<th>Ordnername</th>
			</tr>
		</thead>				
		<body>
			<?php	
				$alledateien = scandir($ordner); //Ordner "files" auslesen
				// Ordner eintragen	
				foreach ($alledateien as $datei) { // Ausgabeschleife		
					if ($datei[0]!=".") {
						$dateiinfo = pathinfo($ordner.$datei);
						if (is_dir($ordner.$datei)){
							echo "<tr>";
								echo "<td><a href=\"scanFiles.php?ordner=".$ordner.$datei."&serienID=".$serienID."\">".$datei."</a></td>";
							echo "</tr>";
						}
					}
				};
				// Dateien eintragen
			?>
		</body>
	</table>
</fieldset>
<div class=\"row">
	<fieldset>
		<?php
		echo "<legend>",$serienName,"</legend>";
		?>
		<table>
			<thead>
				<tr>
					<th>Dateiname</th>
					<th>Serientitel</th>
					<th>neuer Dateiname</th>
				</tr>
			</thead>				
			<body>	
			<?php
				if ($serienID!="-1") {
					foreach ($alledateien as $datei) { // Ausgabeschleife
						if ($datei != "." AND $datei != "..") {
							$dateiinfo = pathinfo($ordner.$datei);
							if(in_array($dateiinfo['extension'],$dateitypen)) {						
								if (!is_dir($ordner.$datei)){
			//						echo "<td>",$datei,"</td>"; //Ausgabe Einzeldatei
									// How-I-Met-Your-Mother.2014-01-02.10-29.mkv
									$datum=explode(".",$datei);
									//print_r($datei);
			//						echo "<td>",$datum[1],"</td>";
			//						echo "<td>",$datum[2],"</td>";
									$datumStart=strtotime($datum[1]." ".str_replace("-", ":", $datum[2]));
									$datumStart=$datumStart-300;
									$datumEnde=$datumStart+600;
									$datumStart=date("o-m-d H:i", $datumStart); 
									$datumEnde=date("o-m-d H:i", $datumEnde);
									// Folge in der Datenbank suchen
									//abfrage= "STR_TO_DATE('".$datumX[1]."','%d.%m.%Y')";
									
									//$src_tz = new DateTimeZone('UTC');
									$src_tz = new DateTimeZone('Europe/Berlin');
									$dest_tz = new DateTimeZone('Europe/Berlin');
									
									$dt = new DateTime($datumStart, $src_tz);
									$dt->setTimeZone($dest_tz);
									$datumStart=$dt->format('Y-m-d H:i:s');
			
									$dt = new DateTime($datumEnde, $src_tz);
									$dt->setTimeZone($dest_tz);
									$datumEnde=$dt->format('Y-m-d H:i:s');
									
			//						echo "<td>",$datumStart,"</td>";
			//						echo "<td>",$datumEnde,"</td>";
									$abfrage="SELECT id, datumVon, datumBis, sender, serien, staffel, episode, titel FROM `DMS` WHERE datumVon>STR_TO_DATE('".$datumStart."','%Y-%m-%d %H:%i')";
									$abfrage=$abfrage." AND datumVon < STR_TO_DATE('".$datumEnde."','%Y-%m-%d %H:%i')";
									$abfrage=$abfrage." AND serien='".$serienID."' LIMIT 0,1";
									$ergebnis = mysql_query($abfrage);
									$serienName="";
									while($row = mysql_fetch_object($ergebnis)) {
										$serienName=$row->titel;
										$episode=$row->episode;
										$staffel=$row->staffel;
									}
									$episode=str_pad($episode, 2, "0", STR_PAD_LEFT);
									$staffel=str_pad($staffel, 2, "0", STR_PAD_LEFT);
									$dateiName=$serienDateiName."s".$staffel."e".$episode.".".$dateiinfo['extension'];
									$fileX=$serienOrdner."/".$dateiName;
									if ($serienName!="") {
										if ($rename=="1") {
											echo "<tr>";
												echo "<td>",$datei,"</td>";
												echo "<td>",$serienName,"</td>";
												echo "<td>",$dateiName,"</td>";
												echo "<td>";
												if (file_exists($fileX)==true) {													
													$fehlermeldung=rename($ordner.$datei, $ordner.$dateiName.".old2");													
													if ($fehlermeldung==FALSE) {
														echo "<div data-alert class=\"alert-box warning\">Die Datei existiert bereits im Serienordner konnte aber nicht mit der Dateiendung .old2 erweitert werden</div>";
													} else {
														echo "<div data-alert class=\"alert-box info\">Die Datei existiert bereits im Serienordner und wurde mit der Dateiendung .old2 erweitert</div>";
													}
												} else {
													$fehlermeldung=rename($ordner.$datei, $ordner.$dateiName);
													if ($fehlermeldung==FALSE) {
														echo "<div data-alert class=\"alert-box warning\">Fehler beim umbenennen!</div>";
													} else {
														echo "<div data-alert class=\"alert-box success\">erfolgreich umbenannt!</div>";
													}
												}
												echo "</td>";
											echo "</tr>";
										} else {
											echo "<tr>";
												echo "<td>",$datei,"</td>";
												echo "<td>",$serienName,"</td>";
												echo "<td>",$dateiName,"</td>";
												echo "<td>";			
												if (file_exists($fileX)==true) {													
														echo "<div data-alert class=\"alert-box warning\">Die Datei existiert bereits im Serienordner</div>";													
												} else {
													echo "<div data-alert class=\"alert-box success\">NEU</div>";
												}
												echo "</td>";
												echo "<td></td>";
											echo "</tr>";
										}								
									}
								}
							}
						}
					}
				} else {
					echo "<div data-alert class=\"alert-box warning\">Bitte eine Serie auswählen</div>";					
				}
			?>
			</body>
		</table>
	</fieldset>
</div>

<div id="suchModal" class="reveal-modal" data-reveal>
	<fieldset>
		<legend>TV-Programm aktualisieren</legend>
		<?php
			include("aufruf_scanFiles.php");
		?>		
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
  <script src="js/foundation.alert.js"></script>
  <script>$(document).foundation();</script>
    
</body>
