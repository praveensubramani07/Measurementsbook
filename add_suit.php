<?php
include "connection.php";

// Check if customer ID is provided in the URL
if(isset($_GET['id'])) {
  $customerId = $_GET['id'];

  // Check if the customer exists in the database
  $customerQuery = "SELECT * FROM customers WHERE id = '$customerId'";
  $customerResult = $conn->query($customerQuery);

  if ($customerResult->num_rows > 0) {
    // Customer exists, check if there is an existing suit record
    $suitQuery = "SELECT * FROM suits WHERE customer_id = '$customerId'";
    $suitResult = $conn->query($suitQuery);

    if ($suitResult->num_rows > 0) {
      // Existing suit record found, retrieve the values
      $suitData = $suitResult->fetch_assoc();
      $length = $suitData['length'];
      $shoulder = $suitData['shoulder'];
      $sleeves = $suitData['sleeves'];
      $chest = $suitData['chest'];
      $waist = $suitData['waist'];
      $hip = $suitData['hip'];
      $collar = $suitData['collar'];
      $note = $suitData['note'];
    } else {
      // No existing suit record, initialize the values
      $length = '';
      $shoulder = '';
      $sleeves = '';
      $chest = '';
      $waist = '';
      $hip = '';
      $collar = '';
      $note = '';
    }

    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $length = $_POST["length"];
      $shoulder = $_POST["shoulder"];
      $sleeves = $_POST["sleeves"];
      $chest = $_POST["chest"];
      $waist = $_POST["waist"];
      $hip = $_POST["hip"];
      $collar = $_POST["collar"];
      $note = $_POST["note"];

      if ($suitResult->num_rows > 0) {
        // Update the existing suit record
        $updateQuery = "UPDATE suits SET length='$length', shoulder='$shoulder', sleeves='$sleeves', chest='$chest', waist='$waist', hip='$hip', collar='$collar', note='$note' WHERE customer_id='$customerId'";
        if ($conn->query($updateQuery) === TRUE) {
          // Suit record updated successfully
          header("Location: customerpage.php?id=$customerId");
          exit();
        } else {
          // Error updating suit record
          echo "Error updating suit: " . $conn->error;
        }
      } else {
        // Insert a new suit record
        $insertQuery = "INSERT INTO suits (customer_id, length, shoulder, sleeves, chest, waist, hip, collar, note) VALUES ('$customerId', '$length', '$shoulder', '$sleeves', '$chest', '$waist', '$hip', '$collar', '$note')";
        if ($conn->query($insertQuery) === TRUE) {
          // Suit record inserted successfully
          header("Location: customerpage.php?id=$customerId");
          exit();
        } else {
          // Error inserting suit record
          echo "Error inserting suit: " . $conn->error;
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

    .add-suit-form {
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

    .add-suit-form h2 {
      text-align: center;
      margin-top: 0;
    }

    .add-suit-form input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .add-suit-form button {
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

<div class="add-suit-form">
  <h2>Suit Measurements</h2>
  <form method="POST" action="">
    <input type="text" placeholder="Length" name="length" value="<?php echo $length; ?>">
    <input type="text" placeholder="Shoulder" name="shoulder" value="<?php echo $shoulder; ?>">
    <input type="text" placeholder="Sleeves" name="sleeves" value="<?php echo $sleeves; ?>">
    <input type="text" placeholder="Chest" name="chest" value="<?php echo $chest; ?>">
    <input type="text" placeholder="Waist" name="waist" value="<?php echo $waist; ?>">
    <input type="text" placeholder="Hip" name="hip" value="<?php echo $hip; ?>">
    <input type="text" placeholder="Collar" name="collar" value="<?php echo $collar; ?>">
    <input type="text" placeholder="Note" name="note" value="<?php echo $note; ?>">
    <button type="submit">Save</button>
  </form>
</div>

</body>
</html>
