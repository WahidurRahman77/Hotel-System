<?php
session_start();
require 'db.php';
if (!isset($_SESSION['guest_id'])) {
    header("Location: index.php");
    exit();
}

$g_id = $_SESSION['guest_id'];
$guest = $conn->query("SELECT g_f_name FROM Guest WHERE g_id = '$g_id'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Portal | Grand Premier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --bg-body: #F4F7FE;
            --bg-card: #FFFFFF;
            --primary-dark: #0B1437;
            --primary-light: #4318FF;
            --accent-gold: #FFB547;
            --text-main: #2B3674;
            --text-muted: #A3AED0;
            --border-light: #E0E5F2;
            --shadow-soft: 0px 18px 40px rgba(112, 144, 176, 0.12);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* --- Premium Sidebar --- */
        .sidebar {
            width: 280px;
            background: var(--bg-card);
            border-right: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            padding: 30px 20px;
            z-index: 10;
        }

        .brand {
            text-align: center;
            margin-bottom: 50px;
        }

        .brand h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.5px;
        }

        .brand span {
            color: var(--accent-gold);
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            border-radius: 12px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
        }

        .nav-item i {
            font-size: 22px;
            margin-right: 14px;
        }

        .nav-item:hover {
            background: rgba(67, 24, 255, 0.05);
            color: var(--primary-light);
        }

        .nav-item.active {
            background: var(--primary-light);
            color: white;
            box-shadow: 0px 10px 20px rgba(67, 24, 255, 0.2);
        }

        .logout-btn {
            background: rgba(226, 232, 240, 0.5);
            color: #E31A1A;
            margin-top: auto;
        }

        .logout-btn:hover {
            background: #E31A1A;
            color: white;
        }

        /* --- Main Content Layout --- */
        .main-content {
            margin-left: 280px;
            padding: 40px 50px;
            width: calc(100% - 280px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 34px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 6px;
        }

        .header p {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
        }

        /* --- Luxury Room Cards Grid --- */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .room-card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 20px 50px rgba(112, 144, 176, 0.2);
        }

        .room-image {
            height: 180px;
            border-radius: 14px;
            background: linear-gradient(135deg, #A3AED0 0%, #E0E5F2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .room-image i {
            font-size: 60px;
            color: white;
            opacity: 0.8;
        }

        .room-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-dark);
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .room-info h3 {
            font-size: 22px;
            color: var(--primary-dark);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .room-features {
            display: flex;
            gap: 15px;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .room-features span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
        }

        .price-block .price {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-light);
        }

        .price-block .night {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .btn-book {
            background: var(--primary-dark);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
        }

        .btn-book:hover {
            background: var(--primary-light);
            box-shadow: 0px 8px 16px rgba(67, 24, 255, 0.2);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px;
            background: var(--bg-card);
            border-radius: 20px;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">
            <h2>Grand<span>Premier</span></h2>
        </div>
        <div class="nav-links">
            <a href="guest_dashboard.php" class="nav-item active">
                <i class="ph ph-squares-four"></i> Explore Rooms
            </a>
            <a href="my_bookings.php" class="nav-item">
                <i class="ph ph-calendar-check"></i> My Bookings
            </a>
            <a href="profile.php" class="nav-item">
                <i class="ph ph-user-circle"></i> Profile Setting
            </a>
        </div>
        <a href="logout.php" class="nav-item logout-btn">
            <i class="ph ph-sign-out"></i> Logout
        </a>
    </aside>

    <main class="main-content">
        <div class="header">
            <div>
                <p>Welcome back, <?php echo htmlspecialchars($guest['g_f_name']); ?></p>
                <h1>Discover Your Perfect Stay</h1>
            </div>
            <div>
                <p style="background: white; padding: 10px 20px; border-radius: 30px; box-shadow: var(--shadow-soft);">
                    <i class="ph ph-map-pin"></i> Chattogram, Bangladesh
                </p>
            </div>
        </div>

        <div class="room-grid">
            <?php
            $rooms = $conn->query("SELECT * FROM Room WHERE r_status = 'Available'");
            if($rooms->num_rows > 0):
                while($room = $rooms->fetch_assoc()): 
            ?>
                <div class="room-card">
                    <div class="room-image">
                        <span class="room-badge"><?php echo htmlspecialchars($room['room_type']); ?></span>
                        <i class="ph ph-bed"></i>
                    </div>
                    
                    <div class="room-info">
                        <h3>Room <?php echo htmlspecialchars($room['room_no']); ?></h3>
                        <div class="room-features">
                            <span><i class="ph ph-wifi-high"></i> Fast WiFi</span>
                            <span><i class="ph ph-television"></i> Smart TV</span>
                            <span><i class="ph ph-wind"></i> AC</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="price-block">
                            <div class="price">$<?php echo htmlspecialchars($room['price']); ?></div>
                            <div class="night">per night</div>
                        </div>
                        <a href="book_room.php?id=<?php echo $room['room_id']; ?>" class="btn-book">Book Now</a>
                    </div>
                </div>
            <?php 
                endwhile; 
            else: 
            ?>
                <div class="empty-state">
                    <i class="ph ph-frown" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <h3>No Rooms Available</h3>
                    <p>We are currently fully booked. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
