<?php
include "../libs/config.php";
include "../libs/PiwikTracker.php";

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$tracker->setUrl( $url = "http://onekb.net/" );
$tracker->doTrackPageView( "onekb.net" );
?>
<!DOCTYPE html>
<html>
<head>
	<title>onekb.net</title>
	<meta charset="utf-8">
</head>
<body>
	<h1 style="font-size:10em;font-style:italic;font-family:sans-serif;margin:0;color:#f0f;">ONEKB.NET</h1>

	<p>
		Get one <b>KILOBYTE</b> of free* <b>WEBSPACE</b> for just 0.00000001 <a href="http://bitcoin.org/" target="_blank">bitcoin</a> per hour!<br>
		That's less than** one <i>CENT</i> per year!
	</p>

	<ul>
		<li>Free subdomain of your choice!</li>
		<li>Unlimited traffic!</li>
		<li>MORE!</li>
	</ul>

	<form action="create" method="POST">
		<input type="text" name="name" length="32" maxlength="32">.onekb.net
		<input type="submit" name="submit" value="Get it!?">
	</form>

	<p>
		<small>
			*Only "free" for the first 1024 minutes.<br>
			**Maybe more than.
		</small>
	</p>

	<p>
		<small>
			report abuse: <a href="mailto:takedown@onekb.net">takedown@onekb.net</a> |
			tell us how great we are: <a href="mailto:mail@onekb.net">mail@onekb.net</a> |
			<a href="http://www.reddit.com/r/onekb/" target="_blank">reddit.com/r/onekb</a> |
			<a href="/faq">FAQ</a>
		</small>
	</p>
</body>
</html>
