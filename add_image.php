<?php
include "connection.php";

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve customer ID from the form submission
  $customerId = $_POST['customer_id']; // Assuming you pass the customer ID through a hidden field or form input
  
  // Retrieve customer data and perform validation checks
  $sql = "SELECT * FROM customers WHERE id = $customerId";
  $result = $conn->query($sql);
  
  if ($result && $result->num_rows > 0) {
    // Customer found, proceed with image upload
    $row = $result->fetch_assoc();
    
    // Delete old image files
    $targetDirectory = "images/";
    $image1Old = $row['image1'];
    $image2Old = $row['image2'];
    
    if (!empty($image1Old)) {
      $image1Path = $targetDirectory . $image1Old;
      if (file_exists($image1Path)) {
        unlink($image1Path);
      }
    }
    
    if (!empty($image2Old)) {
      $image2Path = $targetDirectory . $image2Old;
      if (file_exists($image2Path)) {
        unlink($image2Path);
      }
    }
    
    // Image upload code here
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    
    // Check if new images were selected for upload
    if (!empty($image1)) {
      $targetFile1 = $targetDirectory . basename($image1);
      if (move_uploaded_file($_FILES['image1']['tmp_name'], $targetFile1)) {
        // Image 1 uploaded successfully, update the database
        $sqlUpdateImage1 = "UPDATE customers SET image1 = '$image1' WHERE id = $customerId";
        $conn->query($sqlUpdateImage1);
      }
    }

    if (!empty($image2)) {
      $targetFile2 = $targetDirectory . basename($image2);
      if (move_uploaded_file($_FILES['image2']['tmp_name'], $targetFile2)) {
        // Image 2 uploaded successfully, update the database
        $sqlUpdateImage2 = "UPDATE customers SET image2 = '$image2' WHERE id = $customerId";
        $conn->query($sqlUpdateImage2);
      }
    }

    // Redirect or display success message
    // Adjust the redirect URL or success message as per your requirements
    header("Location: customerpage.php?id=$customerId");
    exit();
  } else {
    die("Customer not found.");
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Images</title>
  <style>
    .add-image-form {
      margin: 20px;
    }

    .add-image-form label {
      display: block;
      margin-bottom: 10px;
    }

    .add-image-form input[type="file"] {
      margin-bottom: 10px;
    }

    .add-image-form input[type="submit"] {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="add-image-form">
    <h2>Add Images</h2>
    <form method="POST" enctype="multipart/form-data">
      <label for="image1">Image 1:</label>
      <input type="file" name="image1" id="image1">
      <br>
      <label for="image2">Image 2:</label>
      <input type="file" name="image2" id="image2">
      <br>
      <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']; ?>">
      <input type="submit" value="Upload Images">
    </form>
  </div>
</body>
</html>
