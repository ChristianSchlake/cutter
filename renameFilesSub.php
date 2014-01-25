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
		foreach ($_POST as $key => $value) {
			switch ($key) {
				case 'dateiAlt':
					$dateiAlt=$value;
					break;
				case 'dateiNeu':
					$dateiNeu=$value;
					break;
				case 'ordner':
					$ordner=$value;
					break;
			}
		}
		if (substr($ordner,-1)!="/") {
			$ordner=$ordner."/";
		}
		$dateiNeu=$ordner.$dateiNeu;
		if ( (file_exists($dateiAlt)==true) AND (file_exists($dateiNeu)==false) ) {
			rename($dateiAlt, $dateiNeu);
			header("Location: listFiles.php?ordner=".$ordner);
		} else {
			echo "<div class=\"row\">";
				echo "<fieldset>";
					echo "<legend>Fehler beim umbenennen der Datei</legend>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "Originalname: ".$dateiAlt."<br>";
						echo "neuer Name: ".$dateiNeu."<br>";
					echo "<div>";
					echo "<div class=\"small-12 large-12 columns\">";
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					echo "<div>";
				echo "</fieldset>";
			echo "<div>";
		}
	?>


	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation.alert.js"></script>
	<script>$(document).foundation();</script>  
</body>
