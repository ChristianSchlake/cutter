<?php
	include("sub_init_database.php");
	include("config.php");
?>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8"/>
	<meta name="viewport" content="width=device-width">

	<?php
		echo "<title>TV-Scraper</title>";
	?>

	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="icons/foundation-icons.css"/>
	<style>      
		.size-12 { font-size: 12px; }
		.size-14 { font-size: 14px; }
		.size-16 { font-size: 16px; }
		.size-18 { font-size: 18px; }
		.size-21 { font-size: 21px; }
		.size-24 { font-size: 24px; }
		.size-36 { font-size: 36px; }
		.size-48 { font-size: 48px; }
		.size-60 { font-size: 60px; }
		.size-72 { font-size: 72px; }
		.size-X { font-size: 26px; }
	</style>
</head>

<body>



<?php	
/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
/* Variablen eintragen */
//	print_r($_GET);
	$ordner="/media/aufnahmen/";
	$dateitypen= array("mpg", "mkv");
//	$serienID="-1";
//	$serienName="";
//	$serienDateiName="";
//	$rename="0";
	foreach ($_GET as $key => $value) {
		switch ($key) {
			case 'ordner':
				$ordner=$value;
				break;
		}
	}
	if (substr($ordner,-1)!="/") {
		$ordner=$ordner."/";
	}
?>
<nav class="top-bar" data-topbar data-options="is_hover:true">
	<ul class="title-area">
		<li class="name">
			<h1><a href="main.php"><i class="fi-refresh"></i> Video-Cutter</a></h1>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
		<ul class="left">
			<a class="button secondary round" href="listFiles.php" data-reveal-id="cutListModal"><i class="fi-list-bullet"></i> Schnittliste anzeigen</a>
			<?php			
			echo "<a class=\"button secondary round\" href=\"executeCutList.php?ordner=".$ordner."\"><i class=\"fi-crop\"></i> Schnitt starten</a>";
			?>
		</ul>
	</section>			
</nav>

<div class="row">
	<fieldset>
		<legend>aktuelle Aufnahmen (TVheadend Server)</legend>		
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Start</th>
					<th>Stop</th>
					<th>Status</th>
				</tr>
			</thead>				
			<body>
				<?php
					/*
					Status von TVheadend abfragen
					*/				
					$xmlFile = "http://".$TVheadendServer_IP.":".$TVheadendServer_PORT."/status.xml";
					
					if (($response_xml_data = file_get_contents($xmlFile))===false){
						echo "Error fetching XML\n";
					} else {
						libxml_use_internal_errors(true);
						$data = simplexml_load_string($response_xml_data);
						if (!$data) {
							echo "Error loading XML\n";
							foreach(libxml_get_errors() as $error) {
								echo "\t", $error->message;
							}
						} else {
							foreach ( $data->recordings as $recordings ) {
								foreach ( $recordings->recording as $recording) {
									echo "<tr>";
										echo "<td>".$recording->title."</td>";
										echo "<td>".$recording->start->date." - ".$recording->start->time."</td>";
										echo "<td>".$recording->stop->date." - ".$recording->stop->time."</td>";
										echo "<td>".$recording->status."</td>";
									echo "</tr>";
								}
							}
						}
					}
				?>
			</body>
		</table>
	</fieldset>
</div>


<div class="row">
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
					$ordner_vorgaenger = substr($ordner,0,strripos(substr($ordner,0,-1),"/"));				
					if(substr_count($ordner, "/") > 1) {						
						echo "<tr>";
							echo "<td><a href=\"listFiles.php?ordner=".$ordner_vorgaenger."\"><i class=\"fi-arrow-up\"></i></a></td>";
							
							//echo "<td><a href=\"listFiles.php?ordner=".$ordner_vorgaenger."\">..</a></td>";
						echo "</tr>";				
					}
					$alledateien = scandir($ordner); //Ordner "files" auslesen
					// Ordner eintragen	
					foreach ($alledateien as $datei) { // Ausgabeschleife		
						if ($datei[0]!=".") {
							$dateiinfo = pathinfo($ordner.$datei);
							if (is_dir($ordner.$datei)){
								echo "<tr>";
									echo "<td><a href=\"listFiles.php?ordner=".$ordner.$datei."\">".$datei."</a></td>";
								echo "</tr>";
							}
						}
					};
				?>
			</body>
		</table>
	</fieldset>
</div>
<div class="row">
	<fieldset>
		<?php
		echo "<legend>Dateien</legend>";
		echo "<form action=\"renameSeries.php\" method=\"POST\" class=\"custom\">";
			echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"serienordner\">";															
			echo "<td><button class=\"button small\" type=\"Submit\">Serien automatisiert umbenennen</button></td>";
		echo "</form>";
		?>
		
		<table>
			<thead>
				<tr>
					<th>Dateiname</th>
				</tr>
			</thead>				
			<body>	
			<?php
				$alledateien = scandir($ordner); //Ordner "files" auslesen
				foreach ($alledateien as $datei) { // Ausgabeschleife
					if ($datei[0] != "." ) {
						$dateiinfo = pathinfo($ordner.$datei);
						if(in_array($dateiinfo['extension'],$dateitypen)) {						
							if (!is_dir($ordner.$datei)){
								echo "<tr>";
									echo "<form action=\"player.php\" method=\"POST\" class=\"custom\">";
										echo "<input type=\"hidden\" value=\"".$ordner.$datei."\" name=\"datei\">";
										echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";
										echo "<td>".$datei."</td>";																			
										echo "<td><button class=\"button small\" type=\"Submit\"><i class=\"step fi-play-video size-48\"></i></button></td>";
									echo "</form>";
					
									echo "<form action=\"renameFiles.php\" method=\"GET\" class=\"custom\">";
										echo "<input type=\"hidden\" value=\"".$ordner.$datei."\" name=\"datei\">";
										echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";															
										echo "<td><button class=\"button small\" type=\"Submit\"><i class=\"step fi-page-edit size-48\"></i></button></td>";
									echo "</form>";
																		
								echo "</tr>";
							}
						}
					}
				}
			?>
			</body>
		</table>
	</fieldset>
</div>

<div id="cutListModal" class="reveal-modal" data-reveal>
	<fieldset>
	<legend>Schnittliste</legend>
		<?php
			$showEdit=0;
			include("cutList.php");
		?>		
	</fieldset>
</div>

<?php
	mysqli_close($verbindung);
?>


  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script src="js/foundation.alert.js"></script>
  <script>$(document).foundation();</script>  

</body>
