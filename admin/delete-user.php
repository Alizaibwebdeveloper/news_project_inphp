<?php
include "config.php";

$userid = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = '$userid'";

if(mysqli_query($conn, $sql)){
    mysqli_close($conn); // Close the database connection
    
    header("Location: {$hostname}/admin/users.php");
    exit(); // Ensure no further output is sent
} else {
    mysqli_close($conn); // Close the database connection
    
    echo "<p style='color: red; text-align: center; margin: 10px 0; font-size: 16px; font-weight: bold;'>Cannot delete record!</p>";
}
?>
