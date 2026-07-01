CREATE DATABASE IF NOT EXISTS ai_solutions CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ai_solutions;

CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    country VARCHAR(80) NOT NULL,
    job_title VARCHAR(80) NOT NULL,
    job_details TEXT NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS event_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    full_name VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS feedback_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL,
    subject VARCHAR(120) NOT NULL,
    rating TINYINT NOT NULL,
    review TEXT NOT NULL,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin account. Password is "Admin@123" (bcrypt hash below).
-- Change it after import for any real deployment.
INSERT IGNORE INTO admin_users (username, password_hash, created_at)
VALUES ('admin', '$2y$12$C1zIfxNaxulsu75TClVFW.mzgsWwtlRK2hNJv.fJzy5mbWTJMytnO', NOW());

INSERT INTO feedback_reviews (full_name, email, subject, rating, review, status, created_at)
VALUES
('Aarav Sharma', 'aarav.demo@gmail.com', 'Helpful prototype delivery', 5, 'The prototype was easy to understand and the admin dashboard made enquiry tracking clear.', 'approved', NOW()),
('Maya Rai', 'maya.demo@gmail.com', 'Excellent support automation', 5, 'The AI-Solutions team explained how customer support automation can reduce repeated manual work.', 'approved', NOW()),
('Liam Carter', 'liam.demo@gmail.com', 'Good event experience', 4, 'The event demo was useful and the registration process was simple on a mobile screen.', 'approved', NOW());

INSERT INTO activity_logs (message, created_at)
VALUES ('Database imported successfully', NOW());
