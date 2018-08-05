<?php
include "../libs/config.php";
include "../libs/PiwikTracker.php";

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$tracker->setUrl( $url = "http://onekb.net/404/" . $_SERVER["REQUEST_URI"] );
$tracker->doTrackPageView( "404 " . $_SERVER["REQUEST_URI"] );
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ERROR</title>
		<meta charset="utf-8">
		<style type="text/css">
			@keyframes blink
			{
				0% { color: red; }
				100% { color: black; }
			}

			@-webkit-keyframes blink
			{
				0% { color: red; }
				100% { color: black; }
			}

			h1
			{
				font-size: 10em;
				font-style: italic;
				font-family: sans-serif;
				margin: 0;
				color:#f0f;
				-webkit-animation: blink 0.5s linear infinite;
				-moz-animation: blink 0.5s linear infinite;
				-ms-animation: blink 0.5s linear infinite;
				-o-animation: blink 0.5s linear infinite;
				animation: blink 0.5s linear infinite;
			}

			body
			{
				text-align: center;
			}
	</style>
	</head>
	<body>
		<h1>404</h1>
		<p>PAGE NOT FOUND!</p>
		<p><small>
			<a href="http://onekb.net/">onekb.net</a>
		</small></p>
	</body>
</html>
