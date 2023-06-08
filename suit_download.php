<?php
include 'connection.php';
// Set the appropriate headers for file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="suits_measurement"');

// Write the code to the output buffer
ob_start();
  $customerId = $_GET['id'];

$sqlCustomer = "SELECT * FROM customers WHERE id = $customerId";
$resultCustomer = $conn->query($sqlCustomer);
if ($resultCustomer->num_rows > 0) {
  $rowCustomer = $resultCustomer->fetch_assoc();
  $customerName = $rowCustomer['name'];
  $customerPhone = $rowCustomer['mobile'];
       echo $customerName;
       echo $customerPhone;
}


?>



  <?php
  // Retrieve the customer ID from the URL parameter
  $customerId = $_GET['id'];

  // Retrieve suits data from the database
  $sqlSuits = "SELECT * FROM suits WHERE customer_id = $customerId";
  $resultSuits = $conn->query($sqlSuits);

  if ($resultSuits->num_rows > 0) {
    while ($rowSuit = $resultSuits->fetch_assoc()) {
      ?>
      Suits measurements:
      
        Length: <?php echo $rowSuit['length'];
        ?>
        
        Shoulder: <?php echo $rowSuit['shoulder'];?>
        
        Sleeves:<?php echo $rowSuit['sleeves'];?>
        
        Chest:<?php echo $rowSuit['chest'];
        
        ?>
        
        Waist: <?php echo $rowSuit['waist'];
       
        ?>
        
        Hip: <?php echo $rowSuit['hip'];
       
        ?>
        
        Collar: <?php echo $rowSuit['collar'];
        
        ?>
        
        Note: <?php echo $rowSuit['note']; 
        
        ?>
        


<?php
}

// Get the contents of the output buffer
$content = ob_get_clean();

// Output the contents as a downloadable file
echo $content;
}
?>
