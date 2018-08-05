<?php

function makeuuid()
{
	return bin2hex( openssl_random_pseudo_bytes( 20 ) );
}

?>
