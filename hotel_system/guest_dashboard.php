<?php
session_start();
if (!isset($_SESSION['guest_id'])) {
    header("Location: index.php");
    exit();
}
?>
<h1>Welcome to the Guest Dashboard</h1>
<p>View your bookings, manage your profile, and book new rooms here.</p>
<a href="logout.php">Logout</a>