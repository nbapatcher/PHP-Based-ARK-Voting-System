<div style="border: 1px solid #fff;border-radius: 15px;background-color: #3c3c3c;margin:15px;padding: 15px;flex: 40%">
<h3><?php echo $site; ?></h3>
<?php
	//This will build a claim button.
	if($response == 1){
		echo '<form action="claim.php" method="post">
       		<input type="hidden" name="steamid" value="'. $steamid . '">
       		<input type="hidden" name="site" value="'. $site . '">
			<input type="submit" value="Claim Reward">
    	</form>';
	}
	//Displays Status that a client has already voted.
	elseif($response == 2){
		echo 'Reward Claimed/Vote Again';
	}
	//Will display a URL redirecting client to the voting website.
		echo '<a href="' . $voteurl . '">Vote Now</a>';
	}
?>
</div>