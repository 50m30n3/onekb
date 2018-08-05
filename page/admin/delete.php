<?php

include "../../libs/config.php";
include "../../libs/db.php";
include "../../libs/uuid.php";
include "../../libs/content.php";

if( ! array_key_exists( "id", $_POST ) )
{
	header( "Location: /admin/" );
	die();
}

$id = $db->real_escape_string( $_POST["id"] );

$rows = $db->query( "SELECT uuid FROM sites WHERE id='$id'" );

if( $rows->num_rows == 0 )
{
	header( "Location: /admin/" );
}
else
{
	$row = $rows->fetch_assoc();
	$uuid = $row["uuid"];

	if( $uuid )
		deletecontent( $uuid );

	$db->query( "UPDATE sites SET expires=DATE_ADD(NOW(), INTERVAL 1 MONTH),uuid='' WHERE id='$id'" );
}

header( "Location: /admin/edit.php?id=$id" );

?>

