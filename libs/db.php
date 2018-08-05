<?php

$db = new mysqli( $mysql_host, $mysql_username, $mysql_password, $mysql_database );
if( $db->connect_errno )
{
	die( "Failed to connect to database: " . $mysqli->connect_error );
}

?>
