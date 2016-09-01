<?php
	function get_seriesByName($search_series, $search_seriesID ) {
		/*
		Die Funktion sucht nach dem übergebenen Seriennamen und gibt die Serie im Array zurück.
		Beispiel:
		Array ( [0] => S02E08 [1] => Friede, Freude, Eierkuchen )  
		*/

		/*		
		cURL Initialisieren
		*/
		if (!function_exists('curl_init')){
			die('Sorry cURL is not installed!');
		}
		/*
		prüfen ob der token von theTVdb.com bereits geholt wurde. Wenn nicht token holen. 
		*/
		if (isset($_SESSION["token"])==false) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.thetvdb.com/login");
			curl_setopt($ch, CURLOPT_POST, "true");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Accept: application/json")); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"apikey\": \"30DD9AF8FDDBB3E6\"}");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);			
			curl_close($ch);
			$data = json_decode($output, true);
			$token=$data["token"];
			$_SESSION["token"]=$token;
		} else {
			$token=$_SESSION["token"];
		}
		
		/*
		Serieninformationen holen
		*/			
		$next=1;
		while (is_null($next)==false) {				
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.thetvdb.com/series/".$search_seriesID."/episodes?page=".$next);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$token,"Accept: application/json", "Accept-Language: DE")); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);				
			$data = json_decode($output, true);
			$next=$data["links"]["next"];
			
			/*
			Nummern von Episode und Serie sowie Seriennamen holen
			Serienname mit dem gesuchten Namen vergleichen und in ein array aufnehmen
			*/					
			foreach($data["data"] as $key => $val) {
				$episodeName=$data["data"][$key]["episodeName"];
				/*
				array sortieren
				Name der Serie in arrNames speichern...
				*/
				similar_text($episodeName, $search_series, $percentage);
				$episodeName="S".sprintf("%02d", $data["data"][$key]["airedSeason"]);
				$episodeName=$episodeName."E".sprintf("%02d", $data["data"][$key]["airedEpisodeNumber"]);															
				$arrPercentage[$episodeName]=$percentage;
				$arrNames[$episodeName]=$data["data"][$key]["episodeName"];;
			}
		}			
		array_multisort($arrPercentage,SORT_NUMERIC, SORT_DESC);
		/*
		den ersten Key ermitteln und ausgeben
		zum key den Seriennamen ausgeben.
		*/		
		$keys = array_keys($arrPercentage);
		$seriesID = $keys[0];		
		$seriesNewName=$arrNames[$seriesID];
		
		return array($seriesID, $seriesNewName);
		//echo $seriesID." - ".$seriesNewName;
	}
	
	function extractStringBetween($FirstString, $SecondString, $sString)
	{
		$startPos=strpos($sString, $FirstString);		
		$startPos2=strpos($sString, $SecondString);
		return substr($sString, $startPos+1, $startPos2-$startPos-1);
	}
	function remove_sonderzeichen($sString) {
		$sRes="";
		$arr = preg_split('//u', $sString, -1, PREG_SPLIT_NO_EMPTY);
//		print_r($arr); 
		foreach ($arr as $v) {
			if ( (ord($v)>47 AND ord($v)<58) OR (ord($v)>64 AND ord($v)<91) OR (ord($v)>96 AND ord($v)<128))  {
				$sRes=$sRes.$v;
			} else {
				$sRes=$sRes."_";
			}
		}
		return $sRes;
	}	
?>
