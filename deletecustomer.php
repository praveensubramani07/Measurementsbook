<?php
ob_start(); // Start output buffering

include "connection.php";

// Check if the customer ID is provided in the URL
if (isset($_GET['id'])) {
  $customerId = $_GET['id'];

  // Delete the customer from the database
  $sqlDelete = "DELETE FROM customers WHERE id = '$customerId'";
  if ($conn->query($sqlDelete) === TRUE) {
    echo "Customer deleted successfully.";
  } else {
    echo "Error deleting customer: " . $conn->error;
  }
} else {
  echo "Invalid customer ID.";
}

// Clear the output buffer
ob_end_clean();

// Redirect back to the customer page
header("Location: customer.php");
exit();
?>
