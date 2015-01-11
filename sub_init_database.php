<?php
	$serverhost="localhost";
        $db_user="somebody";
        $db_pass="eFQVMXuFfyNafJWm";
        $db_database="tv";
	$verbindung = mysql_connect ($serverhost,$db_user,$db_pass) or die ("keine Verbindung möglich. Benutzername oder Passwort sind falsch");

	mysql_select_db($db_database) or die ("Die Datenbank existiert nicht.");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET NAMES utf8");
	header("Content-type:text/html; charset=utf8");
?>
