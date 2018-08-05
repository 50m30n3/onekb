<?php
include "../libs/config.php";
include "../libs/PiwikTracker.php";

$tracker = new PiwikTracker( $idSite = $piwik_site, $piwik_url );
$tracker->setTokenAuth( $piwik_token );
$tracker->setIp( $_SERVER["REMOTE_ADDR"] );
$tracker->enableCookies( $domain = $piwik_domain );

$tracker->setUrl( $url = "http://onekb.net/faq" );
$tracker->doTrackPageView( "FAQ" );
?>
<!DOCTYPE html>
<html>
<head>
	<title>onekb.net</title>
	<meta charset="utf-8">
</head>
<body>
	<h1 style="font-size:10em;font-style:italic;font-family:sans-serif;margin:0;color:#f0f;">FAQ</h1>

	<dl>

		<dt>
			Why?
		</dt>
		<dd>
			Why not?
		</dd>

		<dt>
			You realize this is actually really expensive?
		</dt>
		<dd>
			Yes.
		</dd>

		<dt>
			I did the calculations and it actually costs 4 cent per year.
		</dt>
		<dd>
			Thats not a question.
		</dd>

		<dt>
			Can you guarantee that my site stays online for the time I payed for?
		</dt>
		<dd>
			No.
		</dd>

		<dt>
			Thsi sucks, can I get a refund?
		</dt>
		<dd>
			Nope. No backsies.
		</dd>

	</dl>

	<p><small>
		<a href="http://onekb.net/">onekb.net</a>
	</small></p>
</body>
</html>
