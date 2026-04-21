-- 1. Create the Admin Table
CREATE TABLE Admin (
    adm_id INT PRIMARY KEY AUTO_INCREMENT,
    f_name VARCHAR(50) NOT NULL,
    l_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- 2. Create the Guest Table
CREATE TABLE Guest (
    g_id INT PRIMARY KEY AUTO_INCREMENT,
    g_f_name VARCHAR(50) NOT NULL,
    g_l_name VARCHAR(50) NOT NULL,
    g_email VARCHAR(100) NOT NULL UNIQUE,
    g_phone VARCHAR(20) NOT NULL,
    address TEXT,
    g_status ENUM('Active', 'Inactive', 'Banned') DEFAULT 'Active',
    g_password VARCHAR(255) NOT NULL
);

-- 3. Create the Room Table
CREATE TABLE Room (
    room_id INT PRIMARY KEY AUTO_INCREMENT,
    room_no VARCHAR(10) NOT NULL UNIQUE,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    r_status ENUM('Available', 'Booked', 'Maintenance') DEFAULT 'Available'
);

-- 4. Create the Booking Table (Child of Guest)
CREATE TABLE Booking (
    b_id INT PRIMARY KEY AUTO_INCREMENT,
    g_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    b_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) DEFAULT 0.00,
    due_amount DECIMAL(10,2) NOT NULL,
    b_status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    
    -- This rule ensures a booking MUST belong to a real guest
    FOREIGN KEY (g_id) REFERENCES Guest(g_id) 
    ON DELETE CASCADE
);

-- 5. Create the Booking_Room Table (Child of Booking and Room)
-- This is your M:N (Many-to-Many) relationship table
CREATE TABLE Booking_Room (
    br_id INT PRIMARY KEY AUTO_INCREMENT,
    b_id INT NOT NULL,
    room_id INT NOT NULL,
    
    -- These rules ensure we can't link fake bookings or fake rooms
    FOREIGN KEY (b_id) REFERENCES Booking(b_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES Room(room_id) ON DELETE CASCADE
);

-- 6. Create the Payment Table (Child of Booking)
CREATE TABLE Payment (
    p_id INT PRIMARY KEY AUTO_INCREMENT,
    b_id INT NOT NULL,
    method ENUM('Credit Card', 'Cash', 'Bank Transfer', 'Mobile Banking') NOT NULL,
    bank_acc_no VARCHAR(50),
    p_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    p_amount DECIMAL(10,2) NOT NULL,
    p_status ENUM('Completed', 'Failed', 'Refunded') DEFAULT 'Completed',
    
    -- This rule ensures a payment MUST be attached to a real booking
    FOREIGN KEY (b_id) REFERENCES Booking(b_id) ON DELETE CASCADE
); i have gave pushed this SQL i am giving you file take this i will give you more 