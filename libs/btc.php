<?php

function getaccountbalance()
{
	global $btc_password, $btc_apiroot, $btc_guid;

	$parameters = "password=" . urlencode( $btc_password );
	$response = file_get_contents( $btc_apiroot . $btc_guid .'/balance?' . $parameters );
	$data = json_decode( $response );

	return $data->balance;
}

function getbalance( $address )
{
	global $btc_password, $btc_apiroot, $btc_guid;

	$parameters = "password=" . urlencode( $btc_password ) . "&address=" . urlencode( $address );
	$response = file_get_contents( $btc_apiroot . $btc_guid .'/address_balance?' . $parameters );
	$data = json_decode( $response );

	return $data->total_received;
}

function createaddress( $label )
{
	global $btc_password, $btc_apiroot, $btc_guid;

	$parameters = "password=" . urlencode( $btc_password ) . "&label=" . urlencode( $label );
	$response = file_get_contents( $btc_apiroot . $btc_guid .'/new_address?' . $parameters );
	$data = json_decode( $response );

	return $data->address;
}

?>
