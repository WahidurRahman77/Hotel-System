<?php
require 'db.php';
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secret_code = $_POST['secret_code'];
    
    // 1. Verify Secret Code First
    if ($secret_code !== '4444') {
        $msg = "<div class='alert alert-error'>Error: Invalid Admin Secret Code!</div>";
    } else {
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // 2. Check if the email is already registered
        $check_email = $conn->query("SELECT * FROM Admin WHERE email='$email'");

        if ($check_email->num_rows > 0) {
            $msg = "<div class='alert alert-error'>The email is already registered!</div>";
        }
        // 3. Check if passwords match
        elseif ($password !== $confirm_password) {
            $msg = "<div class='alert alert-error'>Error: Passwords do not match!</div>";
        } 
        // 4. If everything is correct, register the admin
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Admin (f_name, l_name, email, phone, password) VALUES ('$f_name', '$l_name', '$email', '$phone', '$hashed_password')";
            
            if ($conn->query($sql) === TRUE) {
                $msg = "<div class='alert alert-success'>Admin registered successfully!</div>";
            } else {
                $msg = "<div class='alert alert-error'>Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Admin Registration</h2>
    <?php echo $msg; ?>
    <form method="POST" action="">
        <div class="form-group"><label>First Name</label><input type="text" name="f_name" required></div>
        <div class="form-group"><label>Last Name</label><input type="text" name="l_name" required></div>
        <div class="form-group"><label>Email Address</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Phone Number</label><input type="text" name="phone" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <div class="form-group"><label>Confirm Password</label><input type="password" name="confirm_password" required></div>
        <div class="form-group"><label>Admin Secret Code</label><input type="password" name="secret_code" placeholder="Enter code..." required></div>
        
        <button type="submit" class="btn">Register Admin</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Login</button>
    </form>
</div>

</body>
</html>