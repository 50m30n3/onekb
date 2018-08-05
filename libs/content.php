<?php

function getcontent( $uuid )
{
	global $data_path;

	if( ( strlen( $uuid ) != 40 ) || ( preg_match( "/[^0-9a-f]/", $uuid ) ) )
		return "";

	$dir1 = substr( $uuid, 0, 2 );
	$dir2 = substr( $uuid, 2, 2 );
	$filename = $data_path . "/" . $dir1 . "/" . $dir2 . "/" . $uuid;

	if( ! file_exists ( $filename ) )
		return "";
	else
		return file_get_contents( $filename );
}

function getcontentsize( $uuid )
{
	global $data_path;

	if( ( strlen( $uuid ) != 40 ) || ( preg_match( "/[^0-9a-f]/", $uuid ) ) )
		return 0;

	$dir1 = substr( $uuid, 0, 2 );
	$dir2 = substr( $uuid, 2, 2 );
	$filename = $data_path . "/" . $dir1 . "/" . $dir2 . "/" . $uuid;

	if( ! file_exists ( $filename ) )
		return 0;
	else
		return filesize( $filename );
}

function setcontent( $uuid, $content )
{
	global $data_path;

	if( ( strlen( $uuid ) != 40 ) || ( preg_match( "/[^0-9a-f]/", $uuid ) ) )
		return;

	$dir1 = substr( $uuid, 0, 2 );
	$dir2 = substr( $uuid, 2, 2 );
	$dirname = $data_path . "/" . $dir1 . "/" . $dir2 . "/" ;
	$filename = $dirname . $uuid;

	if( ! file_exists ( $dirname ) )
		mkdir( $dirname, 0755, true );

	file_put_contents( $data_path . "/" . $dir1 . "/" . $dir2 . "/" . $uuid, $content );
}

function deletecontent( $uuid )
{
	global $data_path;

	if( ( strlen( $uuid ) != 40 ) || ( preg_match( "/[^0-9a-f]/", $uuid ) ) )
		return;

	$dir1 = substr( $uuid, 0, 2 );
	$dir2 = substr( $uuid, 2, 2 );
	$filename = $data_path . "/" . $dir1 . "/" . $dir2 . "/" . $uuid;

	if( file_exists ( $filename ) )
		unlink( $filename );
}

?>
