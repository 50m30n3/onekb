<?php

include "../libs/config.php";
include "../libs/db.php";
include "../libs/error.php";
include "../libs/btc.php";
include "../libs/content.php";
include "../libs/PiwikTracker.php";

if( ! array_key_exists( "id", $_GET ) )
	error( "THIS DOES NOT WORK THAT WAY!" );

if( strlen( $_GET["id"] ) != 40 )
	error( "DON'T TRY ANY FUNNY GAMES HERE, BOY!" );

if( preg_match( "/[^0-9a-f]/", $_GET["id"] ) )
	error( "ENOUGH WITH THE FUNNY STUFF!" );

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$uuid = $db->real_escape_string( $_GET["id"] );

$rows = $db->query( "SELECT * FROM sites WHERE uuid='$uuid'" );

if( $rows->num_rows == 0 )
{
	error( "THAT PAGE DOES NOT EXIST!" );
}
else
{
	$row = $rows->fetch_assoc();
	$id = $row["id"];
	$expires = strtotime( $row["expires"] );
	$address = $row["address"];
	$name = $row["name"];
	$balance = $row["balance"];
	$checked = strtotime( $row["checked"] );

	$tracker->setUrl( $url = "http://onekb.net/manage/" . $uuid );
	$tracker->doTrackPageView( "Manage " . $name );

	$checktime = 60*60;

	$amount = 0;

	if( time() - $checked  > $checktime )
	{
		$db->query( "UPDATE sites SET checked=NOW() WHERE id='$id'" );

		$currbalance = getbalance( $address );

		if( $currbalance > $balance )
		{
			$amount = $currbalance - $balance;

			if( $expires <= time() )
			{
				$db->query( "UPDATE sites SET expires=DATE_ADD(NOW(), INTERVAL $amount HOUR),balance='$currbalance' WHERE id='$id'" );
			}
			else
			{
				$db->query( "UPDATE sites SET expires=DATE_ADD(expires, INTERVAL $amount HOUR),balance='$currbalance' WHERE id='$id'" );
			}

			$expires += $amount*60*60;

			$tracker->doTrackGoal( $idGoal = 2, $revenue = $amount );
		}
	}

	$content = htmlentities( getcontent( $uuid ) );
}

?>
<!DOCTYPE html>
<html>

	<head>
		<title><?php echo $name;?>.onekb.net</title>
		<meta charset="utf-8">
	</head>

	<body>
		<h1><?php echo $name;?>.onekb.net</h1>

		<p>
<?php
	if( $expires >= time() )
	{
		echo "\t\t\tYour site is claimed until " . date( "l jS \of F Y h:i:s A", $expires ) . "<br>\n";
	}
	else
	{
		echo "\t\t\t<em>Your claim to this site has expired!</em><br>\n";
	}
?>
			<small>
				Pay any amount to <a href="bitcoin:<?php echo $address;?>?amount=0.0001&label=<?php echo $name;?>.onekb.net"><?php echo $address;?></a> to extend your claim.
				Just 0.00000001 <a href="http://bitcoin.org/" target="_blank">bitcoin</a> per hour!
			</small>
		</p>

		<p>
			<b><i>ATTENTION:</i> You need to bookmark this page, otherwise you will not be able to edit it later!</b>
		</p>

		<p>
			Visit your site: <a href="http://<?php echo $name;?>.onekb.net/" target="_blank"><?php echo $name;?>.onekb.net</a>
		</p>

		<form action="/update" method="POST" enctype="multipart/form-data">
			<p>
				Insert data here: (Currently using <?php echo getcontentsize($uuid);?> of 1024 bytes!)<br>
				<textarea name="content" rows="25" cols="80" maxlength="1024"><?php echo $content;?></textarea>
			</p>
			<input type="hidden" name="id" value="<?php echo $uuid;?>">
			<input type="submit" name="submit" value="Update!">
		</form>

		<p>
			<small>
				<a href="http://onekb.net/">onekb.net</a> |
				Proud of your work? Post it on <a href="http://www.reddit.com/r/onekb/" target="_blank">reddit.com/r/onekb</a>!
			</small>
		</p>
	</body>

</html>
