-- Create the database and select it
CREATE DATABASE IF NOT EXISTS cyber_sonic;
USE cyber_sonic;

--------------------------------------------------
-- 1. Minimal users table (for login/registration)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--------------------------------------------------
-- 2. user_profiles table for extended profile details
--------------------------------------------------
CREATE TABLE IF NOT EXISTS user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id)
);

--------------------------------------------------
-- 3. exam_form_filling table (without file upload columns)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS exam_form_filling (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    father_name VARCHAR(100) NOT NULL,
    mother_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    college VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 4. abc_id_creation table (without file upload columns)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS abc_id_creation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 5. flight_ticket_booking table (without file upload columns)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS flight_ticket_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    contact VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    flight_details VARCHAR(255) NOT NULL,
    travelling_date DATE NOT NULL,
    travelling_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 6. train_ticket_booking table (without file upload column for photo)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS train_ticket_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    contact_details VARCHAR(100) NOT NULL,
    departure_location VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    travelling_date DATE NOT NULL,
    travelling_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 7. insurance_premium_payment table
-- (Assuming "id_proof" is stored as text in this table)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS insurance_premium_payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    policy_number VARCHAR(50) NOT NULL,
    email_id VARCHAR(100) NOT NULL,
    id_proof VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 8. event_ticket_booking table (without file upload column for id_proof)
--------------------------------------------------
CREATE TABLE IF NOT EXISTS event_ticket_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    event_name VARCHAR(100) NOT NULL,
    email_confirmation VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 9. electricity_bill_payment table
--------------------------------------------------
CREATE TABLE IF NOT EXISTS electricity_bill_payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    consumer_id VARCHAR(50) NOT NULL,
    sub_division_code INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

--------------------------------------------------
-- 10. health_insurance_premium table
--------------------------------------------------
CREATE TABLE IF NOT EXISTS health_insurance_premium (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    policy_id VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
