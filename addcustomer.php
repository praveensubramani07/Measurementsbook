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

    .add-customer-form {
      width: 400px;
      padding: 20px;
      background: #abbaab;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, #ffffff, #abbaab);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, #ffffff, #abbaab); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-left: 20px;
      margin-right: 20px;
    }

    .add-customer-form h2 {
      text-align: center;
      margin-top: 0;
    }

    .add-customer-form input[type="text"],
    .add-customer-form input[type="tel"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .add-customer-form button {
      width: 100%;
      margin-top: 20px;
      margin-bottom: 20px;
      padding: 15px;
      background-image: linear-gradient( 95.2deg, rgba(173, 252, 234, 1) 26.8%, rgba(192, 229, 246, 1) 64%);
      color: black;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["addCustomer"])) {
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Insert the customer data into the database
    $sql = "INSERT INTO customers (name, mobile, image1, image2) VALUES ('$name', '$phone', '', '')";
    if ($conn->query($sql) === TRUE) {
      // Customer data inserted successfully, get the customer ID
      $customerId = $conn->insert_id;

      // Insert customer ID into measurements table with empty values
     // $sqlMeasurements = "INSERT INTO measurements (customer_id) VALUES ('$customerId')";
     $sqlMeasurements="INSERT INTO `measurements`(`customer_id`, `height`, `weight`, `slength`, `sshoulder`, `ssleeves`, `schest`, `swaist`, `ship`, `scollar`, `snote`, `plength`, `pinseem`, `pwaist`, `phip`, `pthigh`, `ptk`, `pknee`, `pbottom`, `pnote`, `shlength`, `shshoulder`, `shsleeves`, `shloos`, `shwrist`, `shwaist`, `shhip`, `shcollar`, `shnote`) VALUES ('$customerId','','','','','','','','','','','','','','','','','','','','','','','','','','','','')";
      if ($conn->query($sqlMeasurements) === TRUE) {
        // Measurements inserted successfully
       // ob_start(); // Start output buffering
     //   header("Location: customerpage.php?id=$customerId");
    //    ob_end_flush(); // Flush the output buffer and send the headers
?>
<script>
 
  location.replace("https://jobandtalentfinder.000webhostapp.com/customerpage.php?id=<?php echo $customerId; ?>")
  // location.replace("https://www.w3schools.com")

</script>
<?php
     //   exit();
      } else {
        // Error inserting measurements data into the database
        echo "Error: " . $sqlMeasurements . "<br>" . $conn->error;
      }
    } else {
      // Error inserting data into the database
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Close the database connection
$conn->close();
?>

<div class="add-customer-form">
  <h2>Add Customer</h2>
  <form method="POST" action="">
    <input type="text" placeholder="Name" name="name">
    <input type="tel" placeholder="Phone Number" name="phone">
    <button type="submit" name="addCustomer">Add Customer</button>
  </form>
</div>

</body>
</html>
