<?php
include "connection.php";

// Retrieve customer data from the database
$customerId = $_GET['id']; // Assuming you pass the customer ID through the URL parameter
$sql = "SELECT * FROM customers WHERE id = $customerId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $name = $row['name'];
  $phone = $row['mobile'];
  $id = $row['id'];
} else {
  die("Customer not found.");
}

// Retrieve measurements data from the database
$sqlMeasurements = "SELECT * FROM measurements WHERE customer_id = $customerId";
$resultMeasurements = $conn->query($sqlMeasurements);
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
      background: #ECE9E6;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, #FFFFFF, #ECE9E6);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, #FFFFFF, #ECE9E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    /* Navbar styles */
    .navbar {
      background-color: black;
      padding: 10px;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar-logo {
      color: #fff;
      font-size: 30px;
      font-weight: bold;
      text-decoration: none;
      padding: 20px;
    }

    /* Customer page styles */
    .profile-info {
      margin: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      background: #abbaab;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, #ffffff, #abbaab);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, #ffffff, #abbaab); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      position: relative;
    }

    .profile-info h1 {
      margin-top: 0;
      font-size: 24px;
      padding: 10px;
    }

    .profile-info p {
      margin: 0px;
      font-size: 16px;
      padding-bottom: 10px;
      padding-left: 10px;
    }

    .edit-customer {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .edit-customer a {
      color: #000;
      background-color: #f1f1f1;
      padding: 5px 10px;
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .delete-customer {
      position: absolute;
      top: 10px;
      right: 40px;
    }

    .delete-customer a {
      color: #fff;
      background-color: #ff0000;
      padding: 5px 10px;
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .measurements {
      margin: 20px;
    }

    .measurements h2 {
      font-size: 20px;
      margin-top: 0;
    }

    .measurement-item {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      position: relative;
      background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);
    }

    .edit-measurement {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .edit-measurement a {
      color: #000;
      background-color: #f1f1f1;
      padding: 5px 10px;
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .add-measurement {
      margin-bottom: 20px;
      text-align: center;
    }

    .add-measurement a {
      color: black;
      background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);
      padding: 20px 20px;
      text-decoration: none;
      border-radius: 5px;
      width: 80%;
      display: block;
      margin: 0 auto;
    }

    .add-measurement a:hover {
      background-color: #0056b3;
    }

    .image-section {
      margin: 20px;
    }

    .image-section h2 {
      font-size: 20px;
      margin-top: 0;
    }

    .image-item {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      position: relative;
      background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);
    }

    .edit-image {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .edit-image a {
      color: #000;
      background-color: #f1f1f1;
      padding: 5px 10px;
      text-decoration: none;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .add-image {
      margin-bottom: 20px;
      text-align: center;
    }

    .add-image a {
      color: black;
      background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);
      padding: 20px 20px;
      text-decoration: none;
      border-radius: 5px;
      width: 80%;
      display: block;
      margin: 0 auto;
    }

    .add-image a:hover {
      background-color: #0056b3;
    }

    h2 {
      
    }
.suits {
  margin: 20px;
}

.suits h2 {
  font-size: 20px;
  margin-top: 0;
}

.suit-item {
  margin-bottom: 10px;
  padding: 10px;
background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);

  border: 1px solid #ccc;
  border-radius: 5px;
}

.edit-suit {
  margin-top: 10px;
}

.edit-suit a {
  color: #000;
  background-color: #f1f1f1;
  padding: 5px 10px;
  text-decoration: none;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.add-suit {
  margin-bottom: 20px;
  text-align: center;
}

.add-suit a {
  color: #000;
  background-color: #f1f1f1;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
}

.add-suit a:hover {
  background-color: #007bff;
  color: #fff;
}

.shirts {
  margin: 20px;
}

.shirts h2 {
  font-size: 20px;
  margin-top: 0;
}

.shirt-item {
  margin-bottom: 10px;
  padding: 10px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.edit-shirt {
  margin-top: 10px;
}

.edit-shirt a {
  color: #000;
  background-color: #f1f1f1;
  padding: 5px 10px;
  text-decoration: none;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.add-shirt {
  margin-bottom: 20px;
  text-align: center;
}

.add-shirt a {
  color: #000;
  background-color: #f1f1f1;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
}

.add-shirt a:hover {
  background-color: #007bff;
  color: #fff;
}

.pants {
  margin: 20px;
}

.pants h2 {
  font-size: 20px;
  margin-top: 0;
}

.pant-item {
  margin-bottom: 10px;
  padding: 10px;
  background-image: linear-gradient(95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64%);
  border: 1px solid #ccc;
  border-radius: 5px;
}

.edit-pant {
  margin-top: 10px;
}

.edit-pant a {
  color: #000;
  background-color: #f1f1f1;
  padding: 5px 10px;
  text-decoration: none;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.add-pant {
  margin-bottom: 20px;
  text-align: center;
}

.add-pant a {
  color: #000;
  background-color: #f1f1f1;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
}

.add-pant a:hover {
  background-color: #007bff;
  color: #fff;
}
p a
{
    text-decoration:none;
    color:orange;
}

  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <a href="customer.php" class="navbar-logo">Apt Custom tailoring</a>
</div>

<!-- Customer Profile -->
<div class="profile-info">
  <h1><?php echo $name; ?></h1>
  
  <p><strong>Phone:</strong>
  <a href="tel:<?php echo $phone; ?>">
  <?php echo $phone; ?></a></p>

  <div class="edit-customer">
    <a href="edit_customer.php?id=<?php echo $id; ?>">Edit</a>
  </div>

  <div class="delete-customer">
    <a href="deletecustomer.php?id=<?php echo $id; ?>">Delete</a>
  </div>
</div>

<!-- Measurements -->
<div class="measurements">
  <h2>Measurements</h2>
<!-- Suits -->
<div class="suits">
    
  <h2>Suit</h2>

  <?php
  // Retrieve suits data from the database
  $sqlSuits = "SELECT * FROM suits WHERE customer_id = $customerId";
  $resultSuits = $conn->query($sqlSuits);

  if ($resultSuits->num_rows > 0) {
    while ($rowSuit = $resultSuits->fetch_assoc()) {
      ?>
      <div class="suit-item">
        <p><strong>Length:</strong> <?php echo $rowSuit['length']; ?></p>
        <p><strong>Shoulder:</strong> <?php echo $rowSuit['shoulder']; ?></p>
        <p><strong>Sleeves:</strong> <?php echo $rowSuit['sleeves']; ?></p>
        <p><strong>Chest:</strong> <?php echo $rowSuit['chest']; ?></p>
        <p><strong>Waist:</strong> <?php echo $rowSuit['waist']; ?></p>
        <p><strong>Hip:</strong> <?php echo $rowSuit['hip']; ?></p>
        <p><strong>Collar:</strong> <?php echo $rowSuit['collar']; ?></p>
        <p><strong>Note:</strong> <?php echo $rowSuit['note']; ?></p>
        <div class="edit-suit">
          <a href="add_suit.php?id=<?php echo $customerId; ?>">Edit</a>
        </div>
         <div class="edit-suit">
          <a href="suit_download.php?id=<?php echo $customerId; ?>">download</a>
        </div>
      </div>
      <?php
    }
  } else {
    echo '<div class="add-measurement"><a href="add_suit.php?id=' . $customerId. '">Add Suit measurements</a></div>';
  }
  ?>
</div>


<!-- Pants -->
<div class="pants">

  <h2>Pant</h2>

  <?php
  // Retrieve pant data from the database
  $sqlPants = "SELECT * FROM pant WHERE customer_id = $customerId";
  $resultPants = $conn->query($sqlPants);

  if ($resultPants->num_rows > 0) {
    while ($rowPant = $resultPants->fetch_assoc()) {
      ?>
      <div class="pant-item">
        <p><strong>Length:</strong> <?php echo $rowPant['length']; ?></p>
        <p><strong>Inseem:</strong> <?php echo $rowPant['inseem']; ?></p>
        <p><strong>Waist:</strong> <?php echo $rowPant['waist']; ?></p>
        <p><strong>Hip:</strong> <?php echo $rowPant['hip']; ?></p>
        <p><strong>Thigh:</strong> <?php echo $rowPant['thigh']; ?></p>
        <p><strong>T_K:</strong> <?php echo $rowPant['t_k']; ?></p>
        <p><strong>Knee:</strong> <?php echo $rowPant['knee']; ?></p>
        <p><strong>Bottom:</strong> <?php echo $rowPant['bottom']; ?></p>
        <p><strong>Note:</strong> <?php echo $rowPant['note']; ?></p>
        <div class="edit-pant">
          <a href="add_pant.php?id=<?php echo $customerId; ?>">Edit</a>
        </div>
        <div class="edit-pant">
          <a href="pant_download.php?id=<?php echo $customerId; ?>">Download</a>
        </div>
      </div>
      <?php
    }
  } else {
    echo '<div class="add-measurement"><a href="add_pant.php?id=' . $customerId . '">Add Pant measurements</a></div>';
  }
  ?>
</div>


<!-- Shirts -->
<div class="shirts">
  <h2>Shirt</h2>

  <?php
  // Retrieve shirts data from the database
  $sqlShirts = "SELECT * FROM measurements WHERE customer_id = $customerId";
  $resultShirts = $conn->query($sqlShirts);

  if ($resultShirts->num_rows > 0) {
    while ($rowShirt = $resultShirts->fetch_assoc()) {
      ?>
      <div class="shirt-item">
        <p><strong>Size:</strong> <?php echo $rowShirt['shlength']; ?></p>
        <p><strong>Color:</strong> <?php echo $rowShirt['shshoulder']; ?></p>
        <div class="edit-shirt">
          <a href="edit_shirt.php?id=<?php echo $rowShirt['id']; ?>">Edit</a>
        </div>
      </div>
      <?php
    }
  } else {
    echo '<div class="add-shirt"><a href="add_shirt.php?customer_id=' . $customerId . '">Add Shirt</a></div>';
  }
  ?>
</div>






<!-- Images -->
<div class="image-section">
  <h2>Images</h2>

  <?php if (!empty($row['image1']) || !empty($row['image2'])) { ?>
    <div class="image-item">
      <?php if (!empty($row['image1'])) { ?>
        <img src="images/<?php echo $row['image1']; ?>" alt="Image 1" width="200">
      <?php } ?>
      <?php if (!empty($row['image2'])) { ?>
        <img src="images/<?php echo $row['image2']; ?>" alt="Image 2" width="200">
      <?php } ?>

      <div class="edit-image">
        <a href="add_image.php?id=<?php echo $id; ?>">Edit</a>
      </div>
    </div>
  <?php } else{?>

  <div class="add-image">
    <a href="add_image.php?customer_id=<?php echo $customerId; ?>">Add Image</a>
  </div>
</div><?php
}
?>
<h2>Basic details</h2>
  <?php if ($resultMeasurements->num_rows > 0) { ?>
    <?php while ($rowMeasurements = $resultMeasurements->fetch_assoc()) { ?>
      <div class="measurement-item">
        <p><strong>Height:</strong> <?php echo $rowMeasurements['height']; ?></p>
        <p><strong>Weigth:</strong> <?php echo $rowMeasurements['weight']; ?></p>

        <div class="edit-measurement">
          <a href="addmeasurements.php?id=<?php echo $customerId; ?>">Edit</a>
        </div>
      </div>
    <?php } ?>
  <?php }else{ ?>

  <div class="add-measurement">
    <a href="addmeasurements.php?id=<?php echo $customerId; ?>">Add basic Measurement</a>
  </div>
  <?php
}
?>
</div>


</body>
</html>
