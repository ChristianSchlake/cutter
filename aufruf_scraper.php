<form action="scraper.php" method="get">
	<div class="row collapse">
		<div class="small-12 large-8 columns">
			<?php
				$abfrage="SELECT serienID, serien, serienURL FROM serien ORDER BY serien";
				$ergebnis = mysqli_query($verbindung, $abfrage);
			?>
			<label>Serie</label>				
			<select class="medium" name="serienID">
				<?php			
					while($row = mysqli_fetch_object($ergebnis)) {						
						echo "<option value=".$row->serienID.">",$row->serien,"</option>";
					}
				?>
			</select>
		</div>
		<div class="small-12 large-4 columns">			
			<label>Seiten</label>
			<input type="text" placeholder="Seiten" value="2" name="anzahlSeitenZurueck">
		</div>
	</div>
	
	<div class="row collapse">
		<div class="large-6 columns">
			<input type="radio" name="ausfuehren" value="0" id="0"><label for="0">Testsystem</label>
			<br>
			<input type="radio" name="ausfuehren" value="1" id="1"><label for="1">Livesystem</label>
		</div>

		<div class="small-12 large-12 columns">
			<button class="button expand" type="Submit">Scraper starten</button>
		</div>
	</div>
</form>