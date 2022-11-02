<?php
    /*Due to this information being posted through a form data can be manipulated before posting server side, because of this the response for the website will be re-checked.
    */
    //Sets Var Based off of post.
    $steamid = $_POST['steamid'];

    //Sets Var for posted website 
    $site = $_POST['site'];

    //This will re-process the status of voting incase form was manipulated through inspect or other browser manipulation.
    if($site == "TopArkServers.com"){
        $serverkey = "c1AHtDb7ARK183551853kfr0VrXM";
        $topresponse = file_get_contents("https://toparkservers.com/api/rewards/" . $serverkey . "/" . $steamid . "/status");
        $result = json_decode($topresponse);
        $response = $result->rewardvalue;
    }
    elseif($site == "Ark-Servers.net"){
        $serverkey = "zkaxMw3pILemkpFpR6ZXXDBVHrcfPhOO8Pl"; 
        $response = file_get_contents("https://ark-servers.net/api/?action=post&object=votes&element=claim&key=" . $serverkey . "&steamid=" . $steamid);
    }
    elseif($site == "TrackyServer.com") {
        $serverkey = "4890b51340d2ac6f0d95f0f741900333";
        $response = file_get_contents("http://www.api.trackyserver.com/vote/?action=claim&key=" . $serverkey . "&steamid=" . $steamid );
    }
    else {
        echo "Server Site is invalid";
    }

    //We handle the response//
    //If 0 according to the API we will do this...
    if ($response == '0') {
        //No action will be performed due to no vote status
    }
    /*
        The vote is registered and is pending a reward.
        This section will process the reward and report 
        back to the voting website's API to place the vote 
        status to a 0 or 2. This will prevent unlimited claims.
    */
    elseif ($response == '1') {
        if ($site == "Ark-Servers.net"){
            //Processes reward
            require 'process.php';
            //This var serves to only query the voting websites API to set the vote status as claimed
            $post = file_get_contents("https://ark-servers.net/api/?action=post&object=votes&element=claim&key=" . $serverkey . "&steamid=" . $steamid );
        }
        elseif ($site == "TopArkServers.com"){
            require 'process.php';
            $post = file_get_contents("https://toparkservers.com/api/rewards/" . $serverkey . "/" . $steamid . "/claim");
        }
        elseif ($site == "TrackyServer.com"){
            require 'process.php';
            $post = file_get_contents("http://www.api.trackyserver.com/vote/?action=claim&key=" . $serverkey . "&steamid=" . $steamid);
        }     
        else {
          //A 
        }
    }
    /* The Vote has been registered and reward has been processed */
    elseif ($response == '2') {
        //To be used to display claimed status using an echo.
    }
    else {
        //invalid $response//perform nothing//
    }
?>