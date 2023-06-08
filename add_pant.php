<?php
include "connection.php";

// Check if customer ID is provided in the URL
if(isset($_GET['id'])) {
  $customerId = $_GET['id'];

  // Check if the customer exists in the database
  $customerQuery = "SELECT * FROM customers WHERE id = '$customerId'";
  $customerResult = $conn->query($customerQuery);

  if ($customerResult->num_rows > 0) {
    // Customer exists, check if there is an existing pant record
    $pantQuery = "SELECT * FROM pant WHERE customer_id = '$customerId'";
    $pantResult = $conn->query($pantQuery);

    if ($pantResult->num_rows > 0) {
      // Existing pant record found, retrieve the values
      $pantData = $pantResult->fetch_assoc();
      $length = $pantData['length'];
      $inseem = $pantData['inseem'];
      $waist = $pantData['waist'];
      $hip = $pantData['hip'];
      $thigh = $pantData['thigh'];
      $t_k = $pantData['t_k'];
      $knee = $pantData['knee'];
      $bottom = $pantData['bottom'];
      $note = $pantData['note'];
    } else {
      // No existing pant record, initialize the values
      $length = '';
      $inseem = '';
      $waist = '';
      $hip = '';
      $thigh = '';
      $t_k = '';
      $knee = '';
      $bottom = '';
      $note = '';
    }

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $length = $_POST["length"];
      $inseem = $_POST["inseem"];
      $waist = $_POST["waist"];
      $hip = $_POST["hip"];
      $thigh = $_POST["thigh"];
      $t_k = $_POST["t_k"];
      $knee = $_POST["knee"];
      $bottom = $_POST["bottom"];
      $note = $_POST["note"];

      if ($pantResult->num_rows > 0) {
        // Update the existing pant record
        $updateQuery = "UPDATE pant SET length='$length', inseem='$inseem', waist='$waist', hip='$hip', thigh='$thigh', t_k='$t_k', knee='$knee', bottom='$bottom', note='$note' WHERE customer_id='$customerId'";
        if ($conn->query($updateQuery) === TRUE) {
          // Pant record updated successfully
          header("Location: customerpage.php?id=$customerId");
          exit();
        } else {
          // Error updating pant record
          echo "Error updating pant: " . $conn->error;
        }
      } else {
        // Insert a new pant record
        $insertQuery = "INSERT INTO pant (customer_id, length, inseem, waist, hip, thigh, t_k, knee, bottom, note) VALUES ('$customerId', '$length', '$inseem', '$waist', '$hip', '$thigh', '$t_k', '$knee', '$bottom', '$note')";
        if ($conn->query($insertQuery) === TRUE) {
          // Pant record inserted successfully
          header("Location: customerpage.php?id=$customerId");
          exit();
        } else {
          // Error inserting pant record
          echo "Error inserting pant: " . $conn->error;
        }
      }
    }
  } else {
    // Customer not found in the database
    echo "Customer not found.";
  }
} else {
  // Customer ID not provided in the URL
  echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Styles for the form */
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background-color: #f8f8f8;
    }

    .add-pant-form {
      width: 400px;
      padding: 20px;
      background: #abbaab;
      background: -webkit-linear-gradient(to right, #ffffff, #abbaab);
      background: linear-gradient(to right, #ffffff, #abbaab);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-left: 20px;
      margin-right: 20px;
    }

    .add-pant-form h2 {
      text-align: center;
      margin-top: 0;
    }

    .add-pant-form input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .add-pant-form button {
      width: 100%;
      margin-top: 20px;
      margin-bottom: 20px;
      padding: 15px;
      background-image: linear-gradient(95.2deg, rgba(173, 252, 234, 1) 26.8%, rgba(192, 229, 246, 1) 64%);
      color: black;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="add-pant-form">
  <h2>Pant Measurements</h2>
  <form method="POST" action="">
    <input type="text" placeholder="Length" name="length" value="<?php echo $length; ?>">
    <input type="text" placeholder="Inseem" name="inseem" value="<?php echo $inseem; ?>">
    <input type="text" placeholder="Waist" name="waist" value="<?php echo $waist; ?>">
    <input type="text" placeholder="Hip" name="hip" value="<?php echo $hip; ?>">
    <input type="text" placeholder="Thigh" name="thigh" value="<?php echo $thigh; ?>">
    <input type="text" placeholder="T_K" name="t_k" value="<?php echo $t_k; ?>">
    <input type="text" placeholder="Knee" name="knee" value="<?php echo $knee; ?>">
    <input type="text" placeholder="Bottom" name="bottom" value="<?php echo $bottom; ?>">
    <input type="text" placeholder="Note" name="note" value="<?php echo $note; ?>">
    <button type="submit">Save</button>
  </form>
</div>

</body>
</html>
