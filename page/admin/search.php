<?php

include "../../libs/config.php";
include "../../libs/db.php";
include "../../libs/template.php";

if( array_key_exists( "q", $_GET ) )
{
	$q = $db->real_escape_string( $_GET["q"] );
	$rows = $db->query( "SELECT * FROM sites WHERE id='$q' OR name LIKE '%$q%' OR uuid LIKE '$q%' OR address LIKE '$q%' ORDER BY updated DESC LIMIT 100" );
}

$header = new Template( "./include/header.inc" );
$header->set( "title", "Search" );
$header->publish();

?>
			<h1>Search</h1>

			<form action="search.php" method="GET" class="form-inline">
				<input type="text" name="q" length="64">
				<input type="submit" name="submit" value="Search" class="btn">
			</form>

<?php
			if( array_key_exists( "q", $_GET ) )
			{
?>

			<h2>Results</h2>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>UUID</th>
						<th>Address</th>
						<th>Balance</th>
						<th>Expires</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
<?php

					while( $row = $rows->fetch_assoc() )
					{
						$id = $row["id"];
						$expires = strtotime( $row["expires"] );
						$name = $row["name"];
						$uuid = $row["uuid"];
						$suuid = substr( $row["uuid"], 0, 20 );
						$address = $row["address"];
						$balance = $row["balance"]/100000000;
						$saddress = substr( $row["address"], 0, 20 );

						echo "\t\t\t\t\t<tr>\n";

						echo "\t\t\t\t\t\t<td>$id</td>\n";
						echo "\t\t\t\t\t\t<td>$name</td>\n";
						echo "\t\t\t\t\t\t<td>$suuid...</td>\n";
						echo "\t\t\t\t\t\t<td>$saddress...</td>\n";
						echo "\t\t\t\t\t\t<td>$balance BTC</td>\n";
						echo "\t\t\t\t\t\t<td>" . date( "Y-m-d", $expires ) . "</td>\n";

						echo "\t\t\t\t\t\t<td><a href=\"edit.php?id=$id\"><i class=\"icon-edit\"></i></a> <a href=\"/manage/$uuid\" target=\"_blank\"><i class=\"icon-pencil\"></i></a> <a href=\"http://$name.onekb.net/\" target=\"_blank\"><i class=\"icon-share-alt\"></i></a></td>\n";

						echo "\t\t\t\t\t</tr>\n";
					}

?>
				</tbody>

			</table>
<?php
			}

$footer = new Template( "./include/footer.inc" );
$footer->publish();

?>
