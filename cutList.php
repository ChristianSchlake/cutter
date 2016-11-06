<?php
	$datei = file("cutList.sh");
	$fileExistsBool=false
?>
<div class="row">
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Schnitte</th>
				<th>Zieldatei</th>
				<th>status</th>				
			</tr>
		</thead>
		<tbody>
			<?php
				$i=0;				
				foreach($datei AS $zeile) {
					$i++;
					$s=explode("\"", $zeile);
					$s2=explode(":", $s[2]);
					$s2=explode(" -o", $s2[1]);
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$s2[0]."</td>";
					echo "<td>".basename($s[3])."</td>";
					if (file_exists($s[3])==true) {
						echo "<td><i class=\"fi-check\"></i></td>";
						$fileExistsBool=true;						
					} else {
						echo "<td><i class=\"fi-x\"></i></td>";						
					};					
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
<?php
	echo "<div class= \"row\">";
		if ($showEdit==0) {
			$file = file("cutList.sh");
			echo "<form action=\"changeCutList.php\" method=\"post\">";
				echo "<textarea Name=\"update\" placeholder=\"es sind keine Schnittmarken eingetragen\" wrap=\"off\">";
				foreach($file as $text) {
					echo $text;
				} 
				echo "</textarea>";
				echo "<input name=\"Submit\" type=\"submit\" value=\"Update\" />\n";
				echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">"; 
			echo "</form>";
		}
	echo "</div>";
?>
