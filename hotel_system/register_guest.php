<?php
require 'db.php';
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $g_f_name = $_POST['g_f_name'];
    $g_l_name = $_POST['g_l_name'];
    $g_email = $_POST['g_email'];
    $g_phone = $_POST['g_phone'];
    $address = $_POST['address'];
    $g_password = $_POST['g_password'];
    $confirm_g_password = $_POST['confirm_g_password'];

    // 1. Check if the email is already registered
    $check_email = $conn->query("SELECT * FROM Guest WHERE g_email='$g_email'");
    
    if ($check_email->num_rows > 0) {
        $msg = "<div class='alert alert-error'>The email is already registered!</div>";
    } 
    // 2. Check if passwords match
    elseif ($g_password !== $confirm_g_password) {
        $msg = "<div class='alert alert-error'>Error: Passwords do not match!</div>";
    } 
    // 3. If email is new and passwords match, register the guest
    else {
        $hashed_password = password_hash($g_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Guest (g_f_name, g_l_name, g_email, g_phone, address, g_password) VALUES ('$g_f_name', '$g_l_name', '$g_email', '$g_phone', '$address', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            $msg = "<div class='alert alert-success'>Guest registered successfully!</div>";
        } else {
            $msg = "<div class='alert alert-error'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Guest Registration</h2>
    <?php echo $msg; ?>
    <form method="POST" action="">
        <div class="form-group"><label>First Name</label><input type="text" name="g_f_name" required></div>
        <div class="form-group"><label>Last Name</label><input type="text" name="g_l_name" required></div>
        <div class="form-group"><label>Email Address</label><input type="email" name="g_email" required></div>
        <div class="form-group"><label>Phone Number</label><input type="text" name="g_phone" required></div>
        <div class="form-group"><label>Address</label><textarea name="address" required></textarea></div>
        <div class="form-group"><label>Password</label><input type="password" name="g_password" required></div>
        <div class="form-group"><label>Confirm Password</label><input type="password" name="confirm_g_password" required></div>
        
        <button type="submit" class="btn">Register</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Login</button>
    </form>
</div>

</body>
</html>