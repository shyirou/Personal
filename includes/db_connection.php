<?php
$host = 'https://ivptfdcevuwebxwkxlud.supabase.co';
$db = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';
$port = '6543';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<?php   
// Define the server name where the database is hosted
// $servername = "localhost";
// Define the username for database access
// $username = "root";
// Define the password for the database user
// $password = "";
// Define the name of the database to connect to
// $dbname = "motion_graphic";

// Create a new mysqli object to establish a connection to the database
// $conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful; if not, terminate the script and display an error message
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
?>
