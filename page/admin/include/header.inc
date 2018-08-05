<?php
	$links = array(
		array( "title" => "Admin",		"url" => "" ),
		array( "title" => "Search",		"url" => "search.php" ),
	);

	if( ! isset( $this->title ) )
	{
		$title = "Admin";
	}
	else
	{
		$title = $this->title;
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>onekb.net - <?php echo $title ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
	</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner">
				<a class="brand" href="/">onekb.net</a>
				<ul class="nav">
<?php

	foreach( $links as $i => $link )
	{
		$navtitle = $link["title"];
		$navurl = $link["url"];

		if( $navtitle != $title )
			echo "\t\t\t\t<li><a href=\"/admin/" . $navurl ."\">" . $navtitle . "</a></li>\n";
		else
			echo "\t\t\t\t<li class=\"active\"><a href=\"/admin/" . $navurl ."\">" . $navtitle . "</a></li>\n";
	}
?>
				</ul>
			</div>
		</div>

		<div class="container">
