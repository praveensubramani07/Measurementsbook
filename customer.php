<?php
include "connection.php";

// Check if search form is submitted
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  //$sql = "SELECT * FROM customers WHERE name LIKE '%$search%' ORDER BY id DESC";
  $sql = "SELECT * FROM customers WHERE name LIKE '%$search%' OR mobile LIKE '%$search%' ORDER BY id DESC";

} else {
  $sql = "SELECT * FROM customers ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Styles for the navbar */
    .navbar {
      background: black;
      overflow: hidden;
      position: sticky;
      top: 0;
      z-index: 999;
      height: 60px;
    }

    .navbar a {
      float: left;
      display: block;
      color: #fff;
      text-align: center;
      padding: 20px;
      text-decoration: none;
      font-size: 20px;
      font-weight: bold;
    }

    .navbar a:hover {
      background-color: #555;
    }

    .navbar .icon {
      display: none;
    }

    /* Styles for the search bar */
    .search-bar {
      background-color: #f1f1f1;
      overflow: hidden;
      position: sticky;
      top: 60px; /* Height of the navbar */
      z-index: 99;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 10px;
      transition: top 0.3s ease-in-out;
    }

    .search-button {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
    }

    .search-bar.hidden {
      top: -60px; /* Hide the search bar */
    }

    .search-bar input[type="text"] {
      padding: 10px;
      border: none;
      width: 100%;
      font-size: 16px;
      background-color: #f1f1f1;
      border-radius: 5px;
    }

    /* Styles for the customer boxes */
    .customer-box {
      background: #abbaab;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #ffffff, #abbaab);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #ffffff, #abbaab); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


      padding: 20px;
      margin-bottom: 20px;
      margin: 30px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .customer-box h3,
    .customer-box p {
      margin: 0;
      padding: 10px;
      color: #333;
    }

    /* Full-width button */
    .full-width-button {
      width: 90%;
      padding: 20px;
      margin: 0 auto;
      display: block;
      background-image: linear-gradient(95.2deg, rgba(173, 252, 234, 1) 26.8%, rgba(192, 229, 246, 1) 64%);
      color: black;
      font-size: 16px;
      border: none;
      cursor: pointer;
      border-radius: 10px;
    }

    /* Page background */
    body {
      font-family: Arial, sans-serif;
      background: #ece9e6;
      margin: 0;
      padding: 0;
    }

    a {
      text-decoration: none;
      color: black;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar" id="myNavbar">
    <a href="#home">Apt Custom Tailoring</a>
  </div>

  <div class="search-bar" id="mySearchBar">
    <form action="" method="GET">
      <input type="text" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
      <button type="submit" class="search-button">Search</button>
    </form>
  </div>

  <!-- Add customer button -->
  <a href="addcustomer.php">
    <button class="full-width-button">Add Customer</button>
  </a>

  <!-- Customer boxes -->
  <?php
  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $customerId = $row['id'];
      $customerName = $row['name'];
      $customerPhone = $row['mobile'];
      ?>
      <a href="customerpage.php?id=<?php echo $customerId; ?>">
        <div class="customer-box">
          <h3><?php echo $customerName; ?></h3>
          <p><?php echo $customerPhone; ?></p>
        </div>
      </a>
      <?php
    }
  } else {
    echo "No customers found.";
  }
  ?>

  <!-- JavaScript to toggle the responsive navbar -->
  <script>
    function toggleNavbar() {
      var navbar = document.getElementById("myNavbar");
      if (navbar.className === "navbar") {
        navbar.className += " responsive";
      } else {
        navbar.className = "navbar";
      }
    }
  </script>

  <!-- JavaScript to show/hide the search bar on scroll -->
  <script>
    var prevScrollPos = window.pageYOffset;

    function handleScroll() {
      var currentScrollPos = window.pageYOffset;

      if (prevScrollPos > currentScrollPos) {
        document.getElementById("mySearchBar").classList.remove("hidden");
      } else {
        document.getElementById("mySearchBar").classList.add("hidden");
      }

      prevScrollPos = currentScrollPos;
    }

    window.addEventListener("scroll", handleScroll);
  </script>
</body>
</html>
