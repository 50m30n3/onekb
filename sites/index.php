<?php

include "../libs/config.php";
include "../libs/db.php";
include "../libs/error.php";
include "../libs/content.php";
include "../libs/PiwikTracker.php";

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$nameparts = explode( '.', $_SERVER["SERVER_NAME"] );

$nameparts = array_slice( $nameparts, -3, 1 );
$name = $nameparts[0];
$name = strtolower( $name );

$name = preg_replace( "/[^0-9a-z-]/", "", $name );

$name = $db->real_escape_string( $name );

$rows = $db->query( "SELECT uuid FROM sites WHERE name='$name'" );

if( $rows->num_rows == 0 )
{
	error( "NO PAGE HERE!" );
}
else
{
	$tracker->setUrl( $url = "http://onekb.net/view/" . $name );
	$tracker->doTrackPageView( $name . ".onekb.net" );

	$row = $rows->fetch_assoc();
	$uuid = $row["uuid"];

	if( ! $uuid )
		error( "THIS PAGE HAS BEEN DELETED!" );

	$content = getcontent( $uuid );

	if( $content )
		echo $content;
	else
		error( "NO PAGE HERE!" );
}

?>

