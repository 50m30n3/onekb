<?php

function flood()
{
	global $db;

	$db->query( "DELETE FROM flood WHERE time<DATE_SUB(NOW(), INTERVAL 20 MINUTE)" );

	$event = md5( $_SERVER["REMOTE_ADDR"] . __FILE__ );

	$db->query( "INSERT INTO flood ( event ) VALUES ('$event')" );

	$rows = $db->query( "SELECT id FROM flood WHERE event='$event'" );
	if( $rows->num_rows > 5 )
	{
		error( "STOP DOING THAT!" );
	}
}

?>
