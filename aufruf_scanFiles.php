<form action="scanFiles.php" method="get">
	<div class="row collapse">
		<div class="small-12 large-12 columns">
			<?php
				$abfrage="SELECT serienID, serien, serienURL FROM serien ORDER BY serien";
				$ergebnis = mysql_query($abfrage);
			?>
			<label>Serie</label>				
			<select class="medium" name="serienID">
				<?php			
					while($row = mysql_fetch_object($ergebnis)) {						
						echo "<option value=".$row->serienID.">",$row->serien,"</option>";						
					}
				?>
			</select>
		</div>
	</div>
	
	<div class="row collapse">
		<div class="small-12 large-12 columns">
			<button class="button expand" type="Submit">Serie setzen</button>
		</div>
	</div>
	<?php
		echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";	
	?>
</form>