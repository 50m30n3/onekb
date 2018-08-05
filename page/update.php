<?php

include "../libs/config.php";
include "../libs/db.php";
include "../libs/error.php";
include "../libs/content.php";
include "../libs/PiwikTracker.php";

if( ! array_key_exists( "id", $_POST ) )
	error( "THIS DOES NOT WORK THAT WAY!" );

if( strlen( $_POST["id"] ) != 40 )
	error( "DON'T TRY ANY FUNNY GAMES HERE, BOY!" );

if( preg_match( "/[^0-9a-f]/", $_POST["id"] ) )
	error( "ENOUGH WITH THE FUNNY STUFF!" );

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$uuid = $db->real_escape_string( $_POST["id"] );

$rows = $db->query( "SELECT name FROM sites WHERE uuid='$uuid'" );

if( $rows->num_rows == 0 )
{
	error( "SMARTASS HUH?" );
}
else
{
	$row = $rows->fetch_assoc();
	$name = $row["name"];

	$tracker->setUrl( $url = "http://onekb.net/update/" . $name );
	$tracker->doTrackPageView( "Update " . $name );
	$tracker->doTrackGoal( $idGoal = 3 );

	$content = $_POST["content"];

	if( strlen( $content ) > 1024 )
	{
		error( "ITS CALLED <b>ONE</b> KB FOR A REASON!" );
	}

	setcontent( $uuid, $content );

	header( "Location: /manage/" . $uuid );
//	header( ' ', false, 204 );
}

?>
