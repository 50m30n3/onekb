<?php

include "../libs/config.php";
include "../libs/db.php";
include "../libs/error.php";
include "../libs/uuid.php";
include "../libs/content.php";
include "../libs/btc.php";
include "../libs/flood.php";
include "../libs/PiwikTracker.php";

if( $_SERVER['HTTP_REFERER'] != "http://onekb.net/" )
	error( "NICE TRY!" );

if( ! array_key_exists( "name", $_POST ) )
	error( "THIS DOES NOT WORK THAT WAY!" );

if( strlen( $_POST["name"] ) > 32 )
	error( "YOU BROKE IT YOU IDIOT!" );

if( strlen( $_POST["name"] ) < 1 )
	error( "YOU NEED TO ACTUALLY PUT IN A NAME!" );

if( preg_match( "/[^0-9a-z-]/", $_POST["name"] ) )
	error( "YOU CAN'T USE ANYTHING EXCEPT 0-9 and a-z. - IS FINE TOO." );

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$name = $db->real_escape_string( $_POST["name"] );

$tracker->setUrl( $url = "http://onekb.net/create/" . $name );
$tracker->doTrackPageView( "Create " . $name );
$tracker->doTrackGoal( $idGoal = 1 );

$rows = $db->query( "SELECT id, expires, uuid FROM sites WHERE name='$name'" );

if( $rows->num_rows == 0 )
{
	flood();

	$uuid = makeuuid();
	$address = createaddress( $name );

	if( ! $address )
		error( "LOOKS LIKE SOMETHING WENT WRONG! <small>sorry...</small>" );

	$db->query( "INSERT INTO sites ( uuid, address, name, expires ) VALUES ( '$uuid','$address','$name', DATE_ADD(NOW(), INTERVAL 1024 MINUTE) )" );

	header( "Location: /manage/" . $uuid );
}
else
{
	$row = $rows->fetch_assoc();
	$id = $row["id"];
	$uuid = $row["uuid"];
	$expires = strtotime( $row["expires"] );

	if( $expires <= time() )
	{
		flood();

		if( $uuid )
			deletecontent( $uuid );

		$uuid = makeuuid();
		$db->query( "UPDATE sites SET expires=DATE_ADD(NOW(), INTERVAL 1024 MINUTE),uuid='$uuid',updated=NOW() WHERE id='$id'" );

		header( "Location: /manage/" . $uuid );
	}
	else
	{
		if( ! $uuid )
			error( "THIS PAGE HAS BEEN BLOCKED!" );
		else
			error( "THAT PAGE IS ALREADY CLAIMED BY SOMEBODY ELSE!" );
	}
}

?>
