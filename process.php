<?php
	/* 
		The reward will be processed while gaming servers are online.
		
		The work flow is as followed:
		1 - Check to see if delivery server is online and port is available.
		2 - Deliver reward to steam id.
		3 (optional) - Track processed reward.
		4 - Redirect to a result page
	*/	
//Settings// 

    //Set Minimum Points that will be given per vote.
    $minpoints = 1000;
    //Set Maximum Points that will be given per vote.
    $maxpoints = 2000;

    //Multiplier of the base amount of points to be used if running a special
    $multiplier = 1;

    //Sets amount based off of a random number.
    $points = rand($minpoints,$maxpoints)*$multiplier;

    //RCON information
	$rcon = array(
		//IP Address of Delivery Server
		'hostname' => '127.0.0.1',
		//RCON Port of the Delivery Server
		'port' => '28000',
		//Admin Password of the Delivery Server
		'password' => 'vrejuioawofvapod',
	);

	//Check to see if server is online
	$checkconn = @fsockopen($rcon['hostname'], $rcon['port'], $errno, $errstr, 5);
	//Server is offline. Displays error message.
	if(!$checkconn) {
		echo 'Delivery Server is Offline';
	}
	//Server is online and reward is processed.
	else {

		//Pulls in xPaw Library
		require_once __DIR__ . '/../SourceQuery/bootstrap.php';

		//Uses SourceQuery within the xPaw Library
		use xPaw\SourceQuery\SourceQuery;
		
		//Establishes new Query
		$Query = new SourceQuery( );

		//Attempts to Deliver reward to steam id
		try
		{
			//View xPaw Documentation for reference
			$Query->Connect( 
				//Delivery Server IP
				$rcon['hostname'], 
				//Delivery Server Port
				$rcon['port'], 
				//Number of seconds to wait for connection attempt
				5, 
				//Engine through xPaw Library
				SourceQuery::SOURCE
			);
			//Once connection is established this will set the RCON/Admin password for the query
			$Query->SetRconPassword( $rcon['password'] );
			/*
				This is an RCON command from the ARK Shop plugin used in the ARK Server API
				For this example we are processing points as an reward, but anything can be processed as long as it is an available RCON command that can be delivered to the server.
			*/
			$Query->Rcon( 'AddPoints ' . $steamid . ' ' . $points);
			
		}
		//Will echo an error message if reward wasn't processed properly.
		catch( Exception $e )
		{
			echo $e->getMessage( );
		}
		//Closes Connection
		finally
		{
			$Query->Disconnect( );
		}	
	}

    /* This is an example to post data to a database for tracking purposes

	$data=array(
		'hostname' => '127.0.0.1',
		'username' => 'username',
		'password' => 'password123',
		'table' => 'vote'
	)
	
   	$conn = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['vote']);
	$date = date('Y-m-d H:i:s');
	$statement = $conn->prepare('INSERT INTO `votes` (ddate, steamid, reward, site) VALUES(?, ?, ?, ?)');
	$statement->bind_param(
		'ssis',
		$date,
		$steamid,
		$points,
		$site
	);
	$statement->execute();
	$statement->close();	

	*/
	header("Location: results.php" );
?>