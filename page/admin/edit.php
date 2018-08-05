<?php

include "../../libs/config.php";
include "../../libs/db.php";
include "../../libs/btc.php";
include "../../libs/content.php";
include "../../libs/template.php";

if( ! array_key_exists( "id", $_GET ) )
{
	header( "Location: /admin/" );
	die();
}

if( preg_match( "/[^0-9]/", $_GET["id"] ) )
{
	header( "Location: /admin/" );
	die();
}

$id = $db->real_escape_string( $_GET["id"] );

$rows = $db->query( "SELECT * FROM sites WHERE id='$id'" );

$row = $rows->fetch_assoc();

$id = $row["id"];
$expires = $row["expires"];
$name = $row["name"];
$uuid = $row["uuid"];
$address = $row["address"];
$balance = $row["balance"];
$updated = $row["updated"];
$checked = $row["checked"];

$header = new Template( "./include/header.inc" );
$header->set( "title", "Editing " . $name );
$header->publish();

?>
		<div class="container">
			<h1>Editing <?php echo $name;?>.onekb.net</h1>

			<h2>Info</h2>

			<dl>
				<dt>ID</dt>
				<dd><?php echo $id;?></dd>
				<dt>UUID</dt>
				<dd><?php echo $uuid;?></dd>
				<dt>Name</dt>
				<dd><?php echo $name;?></dd>
				<dt>Size</dt>
				<dd><?php echo getcontentsize($uuid);?> bytes</dd>
				<dt>Address</dt>
				<dd><?php echo $address;?> (<?php echo (getbalance( $address )/100000000);?> BTC)</dd>
				<dt>Balance</dt>
				<dd><?php echo ($balance/100000000);?> BTC</dd>
				<dt>Checked</dt>
				<dd><?php echo $checked;?></dd>
				<dt>Expires</dt>
				<dd><?php echo $expires;?></dd>
				<dt>Updated</dt>
				<dd><?php echo $updated;?></dd>
			</dl>

			<h2>Quicklinks</h2>

			<p>
				<a href="/manage/<?php echo $uuid;?>"  target="_blank">Manage</a><br>
				<a href="http://<?php echo $name;?>.onekb.net/"  target="_blank">Visit</a>
			</p>

			<h2>Actions</h2>

			<form action="fakepay.php" method="POST" class="form-inline">
				<input type="text" name="id" hidden class="hide" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="Add hours" class="btn">
				<input type="text" name="amount" value="10000">
			</form>

			<form action="delete.php" method="POST" class="form-inline">
				<input type="text" name="id" hidden class="hide" value="<?php echo $id;?>">
				<input type="submit" name="submit" value="Delete" class="btn btn-danger">
			</form>

			</table>

		</div>
<?php

$footer = new Template( "./include/footer.inc" );
$footer->publish();

?>
