<?php

function error( $str )
{
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
		<h1>ERROR</h1>
		<p><?php echo $str; ?></p>
		<p><small>
			<a href="http://onekb.net/">onekb.net</a>
		</small></p>
	</body>
</html>
<?php
	die();
}

?>
