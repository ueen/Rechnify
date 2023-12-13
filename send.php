<?php
	$vorlage = json_decode(file_get_contents("vorlage.json"), true); 

	$name = $_POST['name'];
	$pw = $_POST['pw'];
	$verifypw = ($vorlage["pw_protect"]) ? password_verify($pw, $vorlage["pw_hash_bcrypt"]) : true;
	if (isset($name) && $verifypw) {
		$wo = $_POST['wo']; 
		$iban = $_POST['iban'];
		$was = $_POST['was']; //array
		$wieviel = $_POST['wieviel'];
		$wann = $_POST['wann'];
		$note = $_POST['note']; //optional

		$wannDaysInYear = date('z', strtotime($wann));
		$quartal = intval($wannDaysInYear / (365/4)) + 1;

		$filename = "names/namesQ".$quartal."_".date("Y").".txt";

		$nameHash = hash("md5", $name); 
		file_put_contents($filename, $nameHash."\n", FILE_APPEND);

		$namesArch = file_get_contents($filename);

		$countInQuartal = substr_count($namesArch, $nameHash);
		$rechnungsNr = $countInQuartal."/".date("Y");

		$nl = "\n";

		//generate Rechnung
		$noteFormat = !empty($note) ? $nl.$note.$nl : '';
		$rechnung = "An".$nl.$vorlage["an"].$nl.$vorlage["empfaenger_adresse"].$nl.$nl."Von".$nl.$name.$nl.$wo.$nl.$nl."Rechnung ".$rechnungsNr.";   am ".date("d.m.Y").$nl.$vorlage["anschreiben"].$nl.$nl.join($nl,$was).$nl."------------".$nl.$wieviel."€".$nl.$nl."IBAN: ".$iban.$nl.$noteFormat.$nl.$vorlage["gruss"].$nl.$name.$nl.$nl.$vorlage["digitalsign"];

		//E-mail oder soo
		mail($vorlage["empfaenger_email"],"Rechnung ".$name." ".$rechnungsNr,$rechnung);

		echo "Gesendet! Du kannst die Seite verlassen :)";
	} else {
		echo "Ups - da ist was schiefgelaufen :(";
	}
?>
