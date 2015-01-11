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
				case 'datei':
					$datei=$value;
					break;
			}
		}
		if (substr($ordner,-1)!="/") {
			$ordner=$ordner."/";
		}
	?>

	<form action="renameFilesSub.php" method="POST" class="custom">									
		<div class="row">
			<fieldset>
				<legend>Datei umbenennen</legend>
				<div class="small-12 large-12 columns">
					<?php
						echo "<label>".$ordner."</label><br>";
						echo "<label>".basename($datei)."</label><br>";
						echo "<input type=\"hidden\" value=\"".$datei."\" name=\"dateiAlt\">";
						echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";
					?>
				</div>
				<div class="small-12 large-12 columns">
					<?php
						echo "<input type=\"text\" placeholder=\"".str_replace("-","_",basename($datei))."\" value=\"".str_replace("-","_",basename($datei))."\" name=\"dateiNeu\"/>";
					?>
				</div>
				<div class="small-12 large-12 columns">
					<button class="button expand" type="Submit"><i class="step fi-page-edit"></i> Datei umbenennen</button>
				</div>
				<div class="small-12 large-12 columns">
					<?php
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					?>
				</div>
			</fieldset>
		</div>
	</form>

	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation.alert.js"></script>
	<script>$(document).foundation();</script>  
</body>
