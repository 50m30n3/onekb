<?php

include "../../libs/config.php";
include "../../libs/db.php";

if( ! array_key_exists( "id", $_POST ) )
{
	header( "Location: /admin/" );
	die();
}

if( ! array_key_exists( "amount", $_POST ) )
{
	header( "Location: /admin/" );
	die();
}

$id = $db->real_escape_string( $_POST["id"] );
$amount = $db->real_escape_string( $_POST["amount"] );

$rows = $db->query( "SELECT expires FROM sites WHERE id='$id'" );

if( $rows->num_rows == 0 )
{
	header( "Location: /admin/" );
}
else
{
	$row = $rows->fetch_assoc();
	$expires = strtotime( $row["expires"] );

	if( $expires <= time() )
	{
		$db->query( "UPDATE sites SET expires=DATE_ADD(NOW(), INTERVAL $amount HOUR) WHERE id='$id'" );
	}
	else
	{
		$db->query( "UPDATE sites SET expires=DATE_ADD(expires, INTERVAL $amount HOUR) WHERE id='$id'" );
	}
}

header( "Location: /admin/edit.php?id=$id" );

?>

