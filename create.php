<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Fullname = $address = $contact = "";
$Fullname_err = $address_err = $contact_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Fullname
    $input_Fullname = trim($_POST["Fullname"]);
    if(empty($input_Fullname)){
        $Fullname_err = "Please enter a Fullname.";
    } elseif(!filter_var($input_Fullname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Fullname_err = "Please enter a valid Fullname.";
    } else{
        $Fullname = $input_Fullname;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate contact
    $input_contact = trim($_POST["contact"]);
    if(empty($input_contact)){
        $contact_err = "Please enter the contact amount.";     
    } elseif(!ctype_digit($input_contact)){
        $contact_err = "Please enter a positive integer value.";
    } else{
        $contact = $input_contact;
    }
    
    // Check input errors before inserting in database
    if(empty($Fullname_err) && empty($address_err) && empty($contact_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO user (Fullname, address, contact) VALUES (?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_Fullname, $param_address, $param_contact);
            
            // Set parameters
            $param_Fullname = $Fullname;
            $param_address = $address;
            $param_contact = $contact;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: admin.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Fullname</label>
                            <input type="text" Fullname="Fullname" class="form-control <?php echo (!empty($Fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Fullname; ?>">
                            <span class="invalid-feedback"><?php echo $Fullname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea Fullname="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>contact</label>
                            <input type="text" Fullname="contact" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>">
                            <span class="invalid-feedback"><?php echo $contact_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="admin.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>