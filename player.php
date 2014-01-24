<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8"/>
	<meta name="viewport" content="width=device-width">
	<title>VLC-Cutter</title>
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
/*-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -*/
/* Variablen eintragen */
	foreach ($_POST as $key => $value) {
		switch ($key) {
			case 'datei':
				$datei=$value;
				break;
			case 'ordner':
				$ordner=$value;
				break;
		}
	}
?>

<nav class="top-bar" data-topbar data-options="is_hover:true">
	<ul class="title-area">
		<li class="name">
			<?php
				echo "<h1><a href=\"listFiles.php?ordner=".$ordner."\"><i class=\"fi-refresh\"></i> VLC Cutter</a></h1>";
			?>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
		<ul class="left">
			<a class="button secondary round" href="player.php" data-reveal-id="cutListModal"><i class="fi-list-bullet"></i> Schnittliste anzeigen</a>
			<!--a class="button secondary round" href="main.php" data-reveal-id="suchModal"><i class="fi-page-add"></i> TV-Programm aktualisieren</a>
			<a class="button secondary round" href="//192.168.2.111/tv"><i class="fi-link"></i> TV-Programm</a>
			<a class="button secondary round" href="scanFiles.php"><i class="fi-page-edit"></i> Dateinamen setzen</a-->
		</ul>
	</section>
</nav>

<div class="row">
	<?php
		echo "<span class=\"label secondary\" id=\"dateiName\">".$datei."</span>";
	?>
</div>

<div class="row">
	<div>
		<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" version="VideoLAN.VLCPlugin.2" toolbar="false" width="640" height="480" id="vlc"></embed>
	</div>
</div>
<div class="row">
	<span class="label" id="zeitAngabe"></span>
</div>
<div class="row">
	<canvas id="canvas" width="640" height="30"></canvas>	
</div>

<script language="Javascript">
	var strgStatus
	var shiftStatus
	var id
	var schnittmarken
	var nextStep
	
	function VLCstop() {
		var vlc = document.getElementById("vlc");
		vlc.playlist.stop();
		vlc.playlist.clear();
	}
	function VLCtoggleMute () {
		var vlc = document.getElementById("vlc");
		vlc.audio.toggleMute();
	}
	function VLCtogglePause () {
		var vlc = document.getElementById("vlc");
		vlc.playlist.togglePause();
	}
	function VLCadditem() {
		var vlc = document.getElementById("vlc");
		var playButton = document.getElementById("playbutton");
		if (vlc.playlist.items.count==0){			
			var dateiName = document.getElementById("dateiName").innerHTML;
			var options = new Array(":aspect-ratio=4:3", "--rtsp-tcp");
			var id = vlc.playlist.add(dateiName, "fancy name", options);		
			schnittmarken="";
			nextStep="dateiAnfang";
			vlc.playlist.playItem(id);		
			registerVLCEvent('MediaPlayerTimeChanged', createCutList);
			document.getElementById("schnittmarken").value = (schnittmarken);						
		} else {
			vlc.playlist.togglePause();			
		}
		displayPauseState();
	}
	function displayPauseState() {
		var vlc = document.getElementById("vlc");
		var playButton = document.getElementById("playbutton");		
		switch(vlc.playlist.isPlaying) {
			case false:
		  		playButton.setAttribute("class", "step fi-play size-48");
		  		break;
			case true:
				playButton.setAttribute("class", "step fi-pause size-48");
				break;
		}	
	}	
	function navigateKeyDown(event) {
		var keyCode = ('which' in event) ? event.which : event.keyCode;
		if (keyCode == 17) {
			strgStatus=1;
		}
		if (keyCode == 16) {
			shiftStatus=1;
		}
		if (keyCode == 13) {
			schnittmarken = document.getElementById("schnittmarken").value;
			var positionD = Math.floor(vlc.input.time/1000);
			var positionS = positionD.toString();
			switch(nextStep) {
				case "dateiAnfang":
			  		schnittmarken=positionS;
			  		nextStep="schnittmarkenAnfang";
			  		break;
				case "schnittmarkenAnfang":
					schnittmarken=schnittmarken + "," + positionS;
					nextStep="schnittmarkenAnfang";
					break;
			}
			document.getElementById("schnittmarken").value = (schnittmarken);
			createCutList();
		}
	}

	function nextCut(richtung) {
		var vlc = document.getElementById("vlc");
		var timeCode = document.getElementById("schnittmarken").value;
		var zeiten=timeCode.split(",");
		var lastPos;
		var zeitX = vlc.input.time/1000;
		if (richtung > 0) {
			// rückwärts springen
			lastPos = zeiten[0];
			for (var i=0; i<zeiten.length; i++) {				
				if (zeiten[i]<=zeitX-2) {
					lastPos = zeiten[i];
				}
			}
		} else {
			// vorwärts springen
			for (var i=zeiten.length; i>0; i--) {			
				if (zeiten[i]>zeitX) { 
					lastPos = zeiten[i];
				}
			}
		}
		vlc.input.time = lastPos*1000;
	}
	function createCutList() {
		var canvas = document.getElementById('canvas');
		var ctx		
		var vlc = document.getElementById("vlc");
		var timeCode = document.getElementById("schnittmarken").value;
		var timeCodeArr = timeCode.split(",");
		var time1;
		var time2;
		var runde = 1;
		var numberBlocks;
		var oldEnd=0;
		var breite;
		var zeitX = vlc.input.time/1000;
		var gesZeit=0;		
		if (canvas && canvas.getContext) {
			ctx = canvas.getContext("2d");
			breite = ctx.canvas.width;
			for (var i=0; i<timeCodeArr.length; i=i+2)
			{
				time1=parseFloat(timeCodeArr[i]);
				time2=parseFloat(timeCodeArr[i+1]);
				xTime1 = breite/vlc.input.length*time1*1000;
				xTime2 = breite/vlc.input.length*time2*1000;
				if (ctx) {
					if (time2>0) {
						gesZeit=gesZeit+time2-time1;
					} else {
						gesZeit=gesZeit+zeitX-time1;					
					}
	  				ctx.fillStyle = "#c60f13";
					ctx.fillRect(oldEnd,0,xTime1,30);
					oldEnd=xTime2;
	  				ctx.fillStyle = "#2ba6cb";
					ctx.fillRect(xTime1,0,xTime2 - xTime1,30);
	  				ctx.fillStyle = "#c60f13";
					ctx.fillRect(oldEnd,0,breite - oldEnd,30);					
				}
			}
			xTime1 = breite/vlc.input.length*vlc.input.time;
			xTime2 = xTime1 + 3
			xTime1 = xTime1 - 3
			ctx.fillStyle = "#000000";
			ctx.fillRect(xTime1,5,xTime2 - xTime1,20);		
		}
		document.getElementById("zeitAngabe").innerHTML = (zeitformat(gesZeit) + " - " + zeitformat(zeitX));
	}
	function zeitformat($Sekundenzahl) {
		var h=0;
		var m=0;
		var s=0;
		h = Math.floor($Sekundenzahl / 3600 );
 		m = Math.floor((($Sekundenzahl - h*3600) / 60 ));
 		s = Math.floor(($Sekundenzahl - h*3600 - m*60));
 		h = zwei(h);
 		m = zwei(m);
 		s = zwei(s);
 		return h + ":" + m + "." + s;
	}
	function zwei(s) {
		if (s.toString().length==1) {
 			s="0"+s;
 		}
		return s;	
	}  
    function navigateKeyUp(event) {
	    var keyCode = ('which' in event) ? event.which : event.keyCode;
	    document.getElementById("label").innerHTML = (keyCode);
	    document.getElementById("navigationsfeld").value = ("");
	    // STRG
	    if (keyCode == 17) {
	    	strgStatus=0;
	    }
	    // SHIFT
	    if (keyCode == 16) {
	    	shiftStatus=0;
	    }
	    if (keyCode == 32) {
	    	shiftStatus=0;
	    	VLCtogglePause ();
	    }
		// >
		if (keyCode == 39 && shiftStatus == 1) {
	    	var vlc = document.getElementById("vlc");
			VLCpause();
	    	vlc.input.time = vlc.input.time + 1000;
	    	showSeekBar();
	    }
	    // <
	    if (keyCode == 37 && shiftStatus == 1) {
	    	var vlc = document.getElementById("vlc");
			VLCpause();
	    	vlc.input.time = vlc.input.time - 1000;
	    	showSeekBar();
	    }
	    // >>
	    if (keyCode == 39 && strgStatus == 1) {
	    	var vlc = document.getElementById("vlc");
	    	vlc.input.time = vlc.input.time + 60000;
	    	showSeekBar();
	    }
	    // <<
	    if (keyCode == 37 && strgStatus == 1) {
	    	var vlc = document.getElementById("vlc");
	    	vlc.input.time = vlc.input.time - 60000;
	    	showSeekBar();
	    }
	    // >>>>
	    if (keyCode == 38 && strgStatus == 1) {
	    	var vlc = document.getElementById("vlc");
	    	vlc.input.time = vlc.input.time + 600000;
	    	showSeekBar();
	    }
	    // >>>>
	    if (keyCode == 40 && strgStatus == 1) {
	    	var vlc = document.getElementById("vlc");
	    	vlc.input.time = vlc.input.time - 600000;
	    	showSeekBar();
	    }
	    // Pause
	    if (keyCode == 32) {
	    	var vlc = document.getElementById("vlc");
	    	vlc.Pause;
	    	displayPauseState();
	    }
	}
    function VLCpause() {
		var vlc = document.getElementById("vlc");
		if (vlc.input.state==3) {
			vlc.playlist.togglePause();
		}     	
    }
	function registerVLCEvent(event, handler) {
		var vlc = document.getElementById("vlc");
		if (vlc) {
			if (vlc.attachEvent) {
				// Microsoft
				vlc.attachEvent (event, handler);
        	} else if (vlc.addEventListener) {
	            // Mozilla: DOM level 2
            	vlc.addEventListener (event, handler, false);
        	} else {
	            // DOM level 0
            	vlc["on" + event] = handler;
        	}
    	}
	}
	function unregisterVLCEvent(event, handler) {
		var vlc = getVLC("vlc");
		if (vlc) {
			if (vlc.detachEvent) {
				// Microsoft				
				vlc.detachEvent (event, handler);
			} else if (vlc.removeEventListener) {
				// Mozilla: DOM level 2				
				vlc.removeEventListener (event, handler, false);
			} else {
				// DOM level 0				
				vlc["on" + event] = null;
			}
		}
	}
	function handleEvents(event) {
		if (!event) {
			event = window.event; // IE			
		}
		if (event.target) {
			// Netscape based browser			
			targ = event.target;
		} else if (event.srcElement) {
			// ActiveX			
			targ = event.srcElement;
		} else {
			// No event object, just the value		
			alert("Event value" + event );
			return;
		}
		if (targ.nodeType == 3) // defeat Safari bug
			targ = targ.parentNode;			
			alert("Event " + event.type + " has fired from " + targ );
		}
	function handleMouseGrab(event,X,Y) {
		if (!event) {
			event = window.event; // IE			
			alert("new position (" + X + "," + Y + ")");
		}
	}
</script>

<div class="row">
	<ul class="button-group">
		<li><a href="#" class="button" onclick="VLCadditem();"><i id="playbutton" class="step fi-play size-48"></i></a></li>
		<!--li><a href="#" class="button" onclick="VLCtogglePause();"><i class="step fi-pause size-48"></i></a></li-->
		<li><a href="#" class="button" onclick="VLCtoggleMute();"><i class="step fi-volume-strike size-48"></i></a></li>
		<li><a href="#" class="button" onclick="nextCut(1);"><i class="step fi-previous size-48"></i></a></li>		
		<li><a href="#" class="button" onclick="nextCut(-1);"><i class="step fi-next size-48"></i></a></li>		
	</ul>
</div>


<div class="row">
	 <input type="text" placeholder="Bitte hier zur Navigation den Fokus setzen" id="navigationsfeld" onkeydown="navigateKeyDown (event);" onkeyup="navigateKeyUp (event);"/>	 
</div>

<div class="row">
	<form action="saveCutList.php" method="POST" class="custom">
		<input type="text" name="schnittmarken" id="schnittmarken" placeholder="hier erscheinen die Schnittmarken" />
		<?php
			echo "<input type=\"hidden\" value=\"".$datei."\" name=\"datei\">";
			echo "<input type=\"hidden\" value=\"".$ordner."\" name=\"ordner\">";
		?>		
		<button class="button expand" type="Submit"><i class="step fi-save size-48"></i></button>
	</form>
</div>

<div class="row">
	<span class="label" id="label"></span>
</div>



<div id="cutListModal" class="reveal-modal" data-reveal>
	<fieldset>
	<legend>Schnittliste</legend>
		<?php
			include("cutList.php");
		?>		
	</fieldset>
</div>


  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation/foundation.js"></script>
  <script src="js/foundation/foundation.topbar.js"></script>
  <script src="js/foundation/foundation.dropdown.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script>$(document).foundation();</script>  


</body>
</html>