<?php

$host = "ep-tiny-wildflower-a1zcicy3.ap-southeast-1.aws.neon.tech";
$port = "5432";
$db = "porfolio";
$user = "porfolio_owner";
$password = "ds5efRBEOQD1";
$endpoint = "ep-tiny-wildflower-a1zcicy3";

$connection_string = "host=" . $host . " port=" . $port . " dbname=" . $db . " user=" . $user . " password=" . $password . " options='endpoint=" . $endpoint . "' sslmode=require";

$conn = pg_connect($connection_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>