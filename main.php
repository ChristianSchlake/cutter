<?php
	include("sub_init_database.php");
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

<nav class="top-bar" data-topbar data-options="is_hover:true">
	<ul class="title-area">
		<li class="name">
			<h1><a href="main.php"><i class="fi-refresh"></i> TV-Scraper</a></h1>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
		<ul class="left">
			<a class="button secondary round" href="main.php" data-reveal-id="suchModal"><i class="fi-page-add"></i> TV-Programm aktualisieren</a>
			<a class="button secondary round" href="scanFiles.php"><i class="fi-page-edit"></i> Dateinamen setzen</a>
			<a class="button secondary round" href="listFiles.php?ordner=aufnahmen"><i class="fi-play-video"></i> Video schneiden</a>
		</ul>
	</section>
</nav>



<div id="suchModal" class="reveal-modal" data-reveal>
	<fieldset>
		<legend>TV-Programm aktualisieren</legend>
		<?php
			include("aufruf_scraper.php");
		?>		
	</fieldset>
</div>







<?php
	mysql_close($verbindung);
?>


  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script>$(document).foundation();</script>  

</body>