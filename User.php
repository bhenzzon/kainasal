 <?php
 // Initialize the session
 session_start();
  
 // Check if the user is already logged in, if yes then redirect him to welcome page
 if(isset($SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
     header("location: user.php");
     exit;
 }
  
 // Include config file
 require_once "config.php";
    // Create a connection

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $time = $_POST['time'];

        // Insert data into the database
        $sql = "INSERT INTO User (name, address, contact, time) VALUES ('$name', '$address', '$contact', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->result;
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Form</title>
    <style>
       
       #logo{ 
       position: center; 
       top:0; 
       left:0; 
       } 
       
       body{
       background-image: url(doctor.jpg);
       background-position: center;
       }
       
       #form{
       background-color: rgb(255, 255, 255);
       width:25%;
       border-radius: 4px;
       margin:120px auto;
       padding:50px;
       
       }
       
       #btn{
       color:rgb(255, 255, 255);
       background-color: rgb(189, 22, 22);
       padding:10px;
       font-size: large;
       border-radius: 10px;
       }
       
       @media screen and (max-width: 570px) {
       #form {
         width: 65%;
         margin-left:none;
         padding:40px;
       }
       
       
       
       }
       </style>
</head>
<body>
<div class="wrapper">
    <div id="form">

<div id="logo"> 
    <img src="logo.png"> 
</div>  
        <h2>Fill up form</h2>
        <p>Please fill in your credentials to order.</p>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="address">Address:</label>
        <textarea name="address" required></textarea><br>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" required><br>

        <label for="time">Time:</label>
        <input type="text" name="time" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
