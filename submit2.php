<?php
require 'vendor/autoload.php'; // Assuming you've installed the MongoDB PHP Library via Composer

// Connect to MongoDB
//$client = new MongoDB\Driver\Manager("mongodb://localhost:27017");
//$collection = $client->demo->users; // "demo" is the database name and "users" is the collection

try {
    // Establish database connection
    $client = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    // Create a query to retrieve documents
    $dbname = 'ugc';
    $collection = 'Users';
    $query = new MongoDB\Driver\Query([]);
    
    // Execute the query
    $cursor = $client->executeQuery("$dbname.$collection", $query);

} catch (MongoDB\Driver\Exception\Exception $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$_id = $_POST['_id'];
    $email = $_POST['email'];
	$ftname = $_POST['ftname'];
	$ltname = $_POST['ltname'];
	$tel = $_POST['tel'];
	$role = 'Agent';
	$gender = $_POST['gender'];
	$password = $_POST['password'];

    if (!empty($email) && !empty($ftname)) {
	
	// Create a new bulk write object	
	$bulk = new MongoDB\Driver\BulkWrite;

    // Insert a new document
    //$bulk->insert(['name' => 'Alice', 'age' => 25, 'email' => 'alice25@yahoo.com']);
	$bulk->insert(['email' => $email, 'ftname' => $ftname, 'ltname' => $ltname, 'password' => $password, 'gender' => $gender, 'tel' => $tel, 'role' => $role]);

    // Execute the bulk write
    $client->executeBulkWrite("$dbname.$collection", $bulk);
		
		
     /*   $insertOneResult = $collection->insertOne([
            'name' => $name,
            'email' => $email,
        ]); */
        //echo "Inserted with Object ID '{$insertOneResult->getInsertedId()}'";
		echo "New Details Successfully Inputted into Mongo Database";
    } else {
        echo "Both fields are required!";
    }
}
?>
