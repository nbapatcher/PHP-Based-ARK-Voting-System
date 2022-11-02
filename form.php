<?php
	/*
		The websites listed will display a 0, 1 or 2 based off of voting status according to their website.
		0 = No Registered Vote (See Note)
		1 = Registered Vote and Reward Pending
		2 = Vote was Registered and Reward Delivered
		* Status 2 will stay in effect until the status is changed to a 1 * 
		*/
	//Example if voting is displayed as a json
	if($site == "TopArkServers.com"){
		//The Account or Server API Key is provided by the voting website.
		$serverkey = "API Key";
		//This is a URL based off of the voting site's API. View the website's API documentation for more information.
		$topresponse = file_get_contents("https://toparkservers.com/api/rewards/" . $serverkey . "/" . $steamid . "/status");
		//This is a URL where players can vote for your server to eventually receive a reward for the claim. It is also used below. 
		$voteurl = 'https://toparkservers.com/server/IPAdress:Port';
		//Var used to decode json method response
		$result = json_decode($topresponse);
		//Var used for determing status of vote. i.e. 0, 1, 2
		$response = $result->rewardvalue;
	}
	//Example if voting is displayed as an INT
	elseif($site == "Ark-Servers.net"){
		$serverkey = "API Key"; 
		$response = file_get_contents("https://ark-servers.net/api/?object=votes&element=claim&key=" . $serverkey . "&steamid=" . $steamid);
		$voteurl = 'https://ark-servers.net/server/*SERVERID*/vote/';
	}
	//Another Example
	elseif($site == "TrackyServer.com") {
		$serverkey = "API Key";
		$response = file_get_contents("http://www.api.trackyserver.com/vote/?action=status&key=" . $serverkey . "&steamid=" . $steamid );
		$voteurl = 'https://www.trackyserver.com/server/*SERVERID*';
	}
	//Other Sites can be added as long as the $response provides a value
	else {
		echo "Server Site is invalid";
	}
	//All value will be pushed to a customizable display
	include 'template.php';
?>
