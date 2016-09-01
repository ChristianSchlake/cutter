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
	<div class="row">
		<div class="small-12 columns"><h1>löschen !!!</h1></div>
		<?php
		
			/*
			Daten aus $_GET verarbeiten
			*/
			if (!empty($_GET)) {
				$dateiNeu=$_GET["dateiNeu"];
				$ordner=$_GET["ordner"];			
			}
			echo $dateiNeu;
			
			if (isset($dateiNeu) AND isset($ordner)) {
				if (unlink($dateiNeu)==True) {
					echo "<div class=\"small-12 columns\">";
						echo "<span class=\"round success label\">Datei --> \"".$dateiNeu."\" erfolgreich gelöscht</span>";
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					echo "</div>";									
				} else {
					echo "<div class=\"small-12 columns\">";
						echo "<span class=\"Round Alert Label\">Datei --> \"".$dateiNeu."\" konnte nicht gelöscht werden!</span>";
						echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
					echo "</div>";
				}
			}
		?>
	</div>

	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation.alert.js"></script>
	<script>$(document).foundation();</script>  
</body>