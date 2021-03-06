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
		include("functions.php");
	?>

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
				case 'serienordner':
					$serienordner=$value;
					break;				
			}
		}
		if (substr($ordner,-1)!="/") {
			$ordner=$ordner."/";
		}
		$dateiNeu=$ordner.$dateiNeu;
		if ( (file_exists($dateiAlt)==true) AND (file_exists($dateiNeu)==false) ) {
			rename($dateiAlt, $dateiNeu);
			echo "<div class=\"row\">";
				echo "<fieldset>";
					echo "<legend>Datei erfolgreich umbenannt</legend>";
					echo "<div class=\"row\">";
						echo "<div class=\"small-12 large-12 columns\">";
							echo "Originalname: ".$dateiAlt."<br>";
							echo "neuer Name: ".$dateiNeu."<br>";
						echo "</div>";
					echo "</div>";
					echo "<div class=\"row\">";
						echo "<div class=\"small-5 large-5 columns\">";
							echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
						echo "</div>";
						echo "<div class=\"small-5 large-5 columns\">";
							echo "<a class=\"button expand\" href=\"del_file.php?dateiNeu=".$dateiNeu."&ordner=".$ordner."\"><i class=\"fi-x-circle\"></i> Datei löschen</a>";
						echo "</div>";
						echo "<div class=\"small-2 large-2 columns\">";
							echo "<form action=\"player.php\" method=\"POST\" class=\"custom\">";
								echo "<input type=\"hidden\" value=\"".$dateiNeu."\" name=\"datei\">";
								echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";
								echo "<button class=\"button expand\" type=\"Submit\"><i class=\"step fi-page-edit\"></i></button>";
							echo "</form>";
						echo "</div>";
					echo "</div>";
				echo "</fieldset>";
			echo "</div>";
		} else {
			echo "<div class=\"row\">";
				echo "<fieldset>";
					echo "<legend>Fehler beim umbenennen der Datei</legend>";
					echo "<div class=\"row\">";
						echo "<div class=\"small-12 large-12 columns\">";
							echo "Originalname: ".$dateiAlt."<br>";
							echo "neuer Name: ".$dateiNeu."<br>";
						echo "</div>";
					echo "</div>";
					echo "<div class=\"row\">";
						echo "<div class=\"small-5 large-5 columns\">";
							echo "<a class=\"button expand\" href=\"listFiles.php?ordner=".$ordner."\"><i class=\"step fi-arrow-left\"></i> zurück</a>";
						echo "</div>";
						echo "<div class=\"small-5 large-5 columns\">";
							echo "<a class=\"button expand\" href=\"del_file.php?dateiNeu=".$dateiNeu."&ordner=".$ordner."\"><i class=\"fi-x-circle\"></i> Datei löschen</a>";
						echo "</div>";
						echo "<div class=\"small-2 large-2 columns\">";
							echo "<form action=\"player.php\" method=\"POST\" class=\"custom\">";
								echo "<input type=\"hidden\" value=\"".$dateiNeu."\" name=\"datei\">";
								echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";
								echo "<button class=\"button expand\" type=\"Submit\"><i class=\"step fi-page-edit\"></i></button>";
							echo "</form>";
						echo "</div>";
					echo "</div>";
				echo "</fieldset>";
			echo "</div>";
		}
		if (isset($serienordner)==False) {
			$serienordner="filme";
		}
		$array_items = directoryToArray($serienordner, true);
		$arrPercentage = array();
		foreach ($array_items as $key => $fileX) {
			$bName1=basename($fileX);
			$bName2=basename($dateiNeu);
			similar_text($bName1, $bName2, $percentage);
			$arrPercentage[$key]=$percentage;
		}
		array_multisort($arrPercentage,SORT_NUMERIC, SORT_DESC , $array_items, SORT_ASC);
	?>
	<div class="row">
		<table>
			<thead>
				<tr>
					<th>Dateiname</th>
					<th>Ähnlichkeit</th>
				</tr>
			</thead>
			<tbody>
				<?php				
					foreach ($array_items as $key => $fileX) {
						$dateiinfo = pathinfo($fileX);
						if(in_array($dateiinfo['extension'],$dateitypen)) {
							$bName=basename($fileX);
							echo "<tr>";
							echo "<td>".basename($fileX)."</td>";
							$perc=explode(".",$arrPercentage[$key]);
							echo "<td>".$perc[0]."%</td>";
							echo "<tr>";
						}

					}
				?>
			</tbody>
		</table>
	</row>


	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation/foundation.js"></script>
	<script src="js/foundation/foundation.topbar.js"></script>
	<script src="js/foundation/foundation.dropdown.js"></script>
	<script src="js/foundation/foundation.reveal.js"></script>
	<script src="js/foundation.alert.js"></script>
	<script>$(document).foundation();</script>  
</body>
