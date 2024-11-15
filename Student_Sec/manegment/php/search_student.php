<?php
// search_student.php

// Connect to the database
$servername = "localhost"; // Change this if necessary
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "hostel_management"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query from the request
$query = $_GET['query']; // assuming you are passing the search input via GET method

// Prepare SQL query to search students by ID, Name, or Room Number
$sql = "SELECT student_id, name, room_no, emergency_contact FROM students WHERE student_id LIKE ? OR name LIKE ? OR room_no LIKE ?";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters
$searchTerm = "%" . $query . "%"; // Wildcards for partial matches
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);

// Execute query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the results
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

// Return the results as JSON
echo json_encode($students);

// Close the connection
$stmt->close();
$conn->close();
?>
