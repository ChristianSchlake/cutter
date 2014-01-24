<?php
	$datei = file("cutList.sh");
?>

<div class="row">
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Zieldatei</th>
				<th>Schnitte</th>
			</tr>
		</thead>
		<tbody>			
			<?php
				$i=0;				
				foreach($datei AS $zeile) {
					$i++;
					$s=split("\"", $zeile);
					$s2=split(":", $s[2]);
					$s2=split(" -o", $s2[1]);
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".basename($s[3])."</td>";
					echo "<td>".$s2[0]."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>

<div class="row">
	<?php
		$file = file("cutList.sh");
		echo "<form action=\"changeCutList.php\" method=\"post\">";
			echo "<textarea Name=\"update\" placeholder=\"small-12.columns\" wrap=\"off\">";
			foreach($file as $text) {
				echo $text;
			} 
			echo "</textarea>";
			echo "<input name=\"Submit\" type=\"submit\" value=\"Update\" />\n"; 
		echo "</form>";
	?>
</div>