<?php
	session_start();
	include("functions.php");
	include("conf_Series.php");
?>

<?php
	$dateitypen= array("mpg", "mkv");
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
		function directoryToArray($directory, $recursive) {
			$array_items = array();
			if ($handle = opendir($directory)) {
				while (false !== ($file = readdir($handle))) {
				    if ($file != "." && $file != ".." && $file[0] != ".") {
				        if (is_dir($directory. "/" . $file)) {
				            if($recursive) {
				                $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
				            }
				            $file = $directory . "/" . $file;
				            $array_items[] = preg_replace("/\/\//si", "/", $file);
				        } else {
				            $file = $directory . "/" . $file;
				            $array_items[] = preg_replace("/\/\//si", "/", $file);
				        }
				    }
				}
				closedir($handle);
			}
			return $array_items;
		}
	?>

	<?php
	/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
	/* Variablen eintragen */
		foreach ($_POST as $key => $value) {
			switch ($key) {
				case 'serienordner':
					$serienordner=$value;
					break;				
			}
		}
		if (substr($serienordner,-1)!="/") {
			$serienordner=$serienordner."/";
		}

		/*
		Ordner nach Serien durchsuchen und die Serie finden
		*/
		if (isset($serienordner)==True) {
			$array_items = directoryToArray($serienordner, true);				
			echo "<table>";
				echo "<tr>";
					echo "<th>Alter Dateiname</th>";
					echo "<th>Neuer Dateiname</th>";
					echo "<th>Status</th>";
				echo "</tr>";

				foreach ($array_items as $key => $fileX) {				
					$fileNewBasename=str_replace("-","_",basename($fileX));								
					/*
					Prüfen ob es sich um eine Serie handelt
					*/
					foreach($confSeries as $key => $value) {
						if (strpos(basename($fileX), $value)!=false) {
							/*
							es handelt sich um eine Serie
							*/
							$search_seriesID=$confSeriesID[$key];
							$fileNewBasename=extractStringBetween(".", ",_Sitcom", $fileNewBasename);								
							$newName=get_seriesByName($fileNewBasename, $search_seriesID);
							$fileNewBasename=$confSeriesFileName[$key]."_".$newName[0]."-".$newName[1];
							$fileNewBasename=remove_sonderzeichen($fileNewBasename);
							$fileNewBasename=$fileNewBasename.".mkv";
							$fileNewBasename=$serienordner.$fileNewBasename;						

							if ( (file_exists($fileX)==true) AND (file_exists($fileNewBasename)==false) ) {
								rename($fileX, $fileNewBasename);
								echo "<tr>";
									echo "<td>".$fileX."</td>";
									echo "<td>".$fileNewBasename."</td>";
									echo "<td>erfolgreich kopiert</td>";
								echo "</tr>";
							} else {
								$fileNewBasename=$fileNewBasename.".bak";
								rename($fileX, $fileNewBasename);
								echo "<tr>";
									echo "<td>".$fileX."</td>";
									echo "<td>".$fileNewBasename."</td>";
									echo "<td>Datei umbenannt mit Endung '.bak'</td>";
								echo "</tr>";
							}						
						}
					}
				}
				echo "</table>";
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
