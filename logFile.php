<?php
	$datei = file("cutListOutput.txt");
?>
<div class="row">
	<?php
		echo end($datei);
	?>
</div>
