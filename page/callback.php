<?php
include "../libs/config.php";
include "../libs/db.php";
include "../libs/btc.php";


if( ! array_key_exists( "secret", $_GET ) )
	exit( "*ok*" );

if( $_GET["secret"] != $btc_secret )
{
	exit( "secret" );
}

$address = $db->real_escape_string( $_GET["address"] );

$rows = $db->query( "SELECT id FROM sites WHERE address='$address'" );

if( $rows->num_rows == 0 )
{
	exit( "address" );
}
else
{
	$row = $rows->fetch_assoc();
	$id = $row["id"];

	$db->query( "UPDATE sites SET checked=DATE_SUB(NOW(), INTERVAL 1 YEAR) WHERE id='$id'" );
}

echo "*ok*"

?>
