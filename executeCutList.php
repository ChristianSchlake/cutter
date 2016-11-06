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
		<fieldset>	
		<legend>cutList</legend>
			<?php
				$showEdit=1;
				include("cutList.php");
			?>
		</fieldset>
	</div>
		
	
	
	
	<div class="row">
		<fieldset>
			<legend>Schnittprogramm</legend>
			<?php
				$pid="";
				$file = file("cutListOutput.pid");
				$pid = $file[0];
				$status = "";
				if ($pid!="") {
					$status = exec('ps h '.$pid,$rWert);
				}
				if ($status!="") {
					echo "<span class=\"alert label\">Das Schnittprogramm läuft bereits</span>";
				} else {
					if ($fileExistsBool==false) {
						$pid = exec('sh cutList.sh >> cutListOutput.txt 2>&1 & echo $!',$rWert);
						$fp = fopen("cutListOutput.pid","w");
						fwrite($fp, $pid);
						fclose($fp);
						echo "<span class=\"success label\">Das Schnittprogramm wurde gestartet</span>";
					} else {
						echo "<span class=\"alert label\">es existieren schon einige Zieldateien. Bitte die cutList editieren!</span>";
					}
				}
				echo "<br><a href=\"listFiles.php?ordner=".$_GET["ordner"]."\" class=\"button\"><i class=\"fi-arrow-left\"></i> zurück</a>";
			?>			
		</fieldset>
	</div>

	<div class="row">
		<fieldset>
			<legend>Logfile - letzte Zeile</legend>
			<?php
				include("logFile.php");
			?>
		</fieldset>
	</div>
		
		

  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script src="js/foundation.alert.js"></script>
  <script>$(document).foundation();</script>  	
</body>
