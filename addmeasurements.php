<?php
include "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the input values
  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $customerid = $_POST['customerid'];

  // Check if measurements already exist for the customer ID
  $sqlCheck = "SELECT * FROM measurements WHERE customer_id = '$customerid'";
  $resultCheck = $conn->query($sqlCheck);

  if ($resultCheck) {
    if ($resultCheck->num_rows > 0) {
      // Measurements exist, update the existing data
      $sqlUpdate = "UPDATE measurements SET height = '$height', weight = '$weight' WHERE customer_id = '$customerid'";
      if ($conn->query($sqlUpdate) === TRUE) {
        header("Location: customerpage.php?id=$customerid");
        exit();
      } else {
        echo "Error updating measurements: " . $conn->error;
        exit();
      }
    } else {
      // Measurements don't exist, insert the new measurements
      $sqlInsert = "INSERT INTO measurements (customer_id, height, weight, slength) VALUES ('$customerid', '$height', '$weight', '')";
      if ($conn->query($sqlInsert) === TRUE) {
        header("Location: customerpage.php?id=$customerid");
        exit();
      } else {
        echo "Error adding measurements: " . $conn->error;
        exit();
      }
    }
  } else {
    echo "Error checking measurements: " . $conn->error;
    exit();
  }
}

// Retrieve the customer ID from the URL
$customerId = $_GET['id'];

// Retrieve existing measurements from the database
$sqlSelect = "SELECT * FROM measurements WHERE customer_id = '$customerId'";
$resultSelect = $conn->query($sqlSelect);

// Retrieve the existing values
$existingHeight = "";
$existingWeight = "";
if ($resultSelect->num_rows > 0) {
  $row = $resultSelect->fetch_assoc();
  $existingHeight = $row['height'];
  $existingWeight = $row['weight'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Global styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Form styles */
    .form-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-input {
      margin-bottom: 10px;
    }

    .form-input label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-input input[type="text"] {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-submit {
      text-align: center;
      margin-top: 10px;
    }

    .form-submit input[type="submit"] {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="form-container">
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $customerId; ?>">
    <div class="form-input">
      <label for="customerId">Customer ID:</label>
      <input type="text" name="customerid" id="customerId" value="<?php echo $customerId; ?>" readonly>
    </div>
    <div class="form-input">
      <label for="height">Height:</label>
      <input type="text" name="height" id="height" value="<?php echo $existingHeight; ?>" required>
    </div>
    <div class="form-input">
      <label for="weight">Weight:</label>
      <input type="text" name="weight" id="weight" value="<?php echo $existingWeight; ?>" required>
    </div>

    <div class="form-submit">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>

</body>
</html>
