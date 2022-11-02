Logged in as 
<?php 
	//Displays the account's name based off of Steam Auth by xPaw
	echo $steamprofile['personaname']."<br>";

	//Sets the account's SteamID based off of Steam Auth by xPaw
	$steamid = $steamprofile['steamid'];

	//Displays voting infomation based off of website response
	$site = "TopArkServers.com";
	include 'form.php';

	//This provides support for additional websites
	$site = "Ark-Servers.net";
	include 'form.php';
?>