<?php
  # Initialize the session.
  session_start();

  $cart_count = 0;
 
  # Check if the user is logged in, if not then redirect to login page.
  if(!isset($_SESSION["user_loggedin"]) || $_SESSION["user_loggedin"] != true) {
    header("location: ../user/login.php");
    exit;
  }

  $user_id = $_SESSION["user_id"];

  # Include file to connect to database.
  require_once "../connect.php";
  
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | My Account</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
  </head>
  <body>
    <!------ Menu ------>
    <div class="header">
      <div class="container">
        <div class="logo"></div>
        <div class="navbar">
          <nav>
            <ul id="MenuItems">
            <li><a href="../index.html">Home</a></li>
            <li><a href="../shop/products.php">Products</a></li>
            <li><a href="../contact.php">Contact</a></li>
            <li><a href="../employee/login.php">Employee</a></li>
            <li><a href="../user/login.php">Account</a></li>
            </ul>
            <?php
              if(!empty($_SESSION["shopping_cart"])) {
              $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            ?>
            <?php
              }
            ?>
            <div class="cart_div">
              <a href="../shop/cart.php"><img src="../images/cart.png" /><span><?php echo $cart_count; ?></span></a>
            </div>
            <img scr="images/menu.png" class="menu-icon" onclick="menutoggle()">
          </nav>   
        </div>
      </div>
    </div>

    <h1 class="prompt">Hello, <b><?php echo htmlspecialchars($_SESSION["user_name"]); ?></b>. Welcome to our site.</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <input type="submit" name="ad-btn" value="Account Details">
      <input type="submit" name="ao-btn" value="Account Orders">
    </form>
    <div class="accnt-details-res">
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['ad-btn'])) {
          ## NEED TO ADD EDIT BUTTON TO EDIT ACCOUNT INFO ##
          $sql = "SELECT name, address, email, phone FROM users WHERE id = $user_id";
          $stmt = $pdo->prepare($sql);

          if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
              if ($row = $stmt->fetch()) {
                echo "<h3>Account Details</h3>";
                echo "Name: " . $row["name"] . "</br>";
                echo "Address: " . $row["address"] . "</br>";
                echo "Email: " . $row["email"] . "</br>";
                echo "Phone: " . $row["phone"] . "</br>";
              }
            }
          }
        } elseif (isset($_POST['ao-btn'])) {
            echo "This is the account order button.";
          }
      }
    ?>
    </div>

    <p>
      <a href="../user/logout.php" class="logout-btn">Sign Out</a>
    </p>
    
  </body>
</html>