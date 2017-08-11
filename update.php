<?php
echo "hi";


require( dirname(__FILE__).'/wp-load.php' );

$name = $_POST['name'];

$sql = "INSERT INTO wp_my_analysis (name) VALUES ($name)";
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)) {
    echo $row['name'];
}