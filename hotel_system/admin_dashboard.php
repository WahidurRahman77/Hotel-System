<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>
<h1>Welcome to the Admin Dashboard</h1>
<p>Manage rooms, bookings, and guests here.</p>
<a href="logout.php">Logout</a>