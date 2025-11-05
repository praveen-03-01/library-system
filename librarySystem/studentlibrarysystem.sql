-- Library Management System Database with Sri Lankan Literature Collection
-- Price-free version
-- Version: 2.7
-- Updated: 2024-06-20

CREATE DATABASE IF NOT EXISTS library_management_system 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE library_management_system;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS issueinfo;
DROP TABLE IF EXISTS timer;
DROP TABLE IF EXISTS trendingbook;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS borrowings;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS authors;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS system_settings;
DROP TABLE IF EXISTS audit_log;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    student_id VARCHAR(20) UNIQUE,
    role ENUM('admin', 'librarian', 'student') NOT NULL DEFAULT 'student',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    failed_attempts INT DEFAULT 0,
    last_failed_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Student profile table
CREATE TABLE student (
    studentid INT AUTO_INCREMENT PRIMARY KEY,
    student_username VARCHAR(50) NOT NULL UNIQUE,
    FullName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20),
    studentpic VARCHAR(255) DEFAULT 'default_student.jpg',
    department VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_username) REFERENCES users(username)
) ENGINE=InnoDB;

-- Category table
CREATE TABLE category (
    categoryid INT AUTO_INCREMENT PRIMARY KEY,
    categoryname VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Authors table
CREATE TABLE authors (
    authorid INT AUTO_INCREMENT PRIMARY KEY,
    authorname VARCHAR(255) NOT NULL,
    biography TEXT,
    nationality VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Books table (price column removed)
CREATE TABLE books (
    bookid INT AUTO_INCREMENT PRIMARY KEY,
    bookpic VARCHAR(255) DEFAULT 'default_book.jpg',
    bookname VARCHAR(255) NOT NULL,
    categoryid INT,
    authorid INT,
    ISBN VARCHAR(20) UNIQUE,
    publisher VARCHAR(255),
    publication_year YEAR,
    quantity INT NOT NULL DEFAULT 1,
    available_copies INT NOT NULL DEFAULT 1,
    description TEXT,
    awards TEXT,
    status ENUM('available', 'borrowed', 'lost', 'damaged') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoryid) REFERENCES category(categoryid),
    FOREIGN KEY (authorid) REFERENCES authors(authorid)
) ENGINE=InnoDB;

-- Trending books table
CREATE TABLE trendingbook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bookid INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bookid) REFERENCES books(bookid) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Borrowings table (fine_amount column retained as it's related to late fees, not book prices)
CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bookid INT NOT NULL,
    borrowed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NOT NULL,
    returned_at TIMESTAMP NULL,
    fine_amount DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('active', 'returned', 'overdue', 'lost') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bookid) REFERENCES books(bookid) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Feedback table (fixed version)
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stdid INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (stdid) REFERENCES student(studentid) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Audit Log table
CREATE TABLE audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Message table
CREATE TABLE message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('no', 'yes') DEFAULT 'no',
    sender ENUM('admin', 'student') NOT NULL,
    date VARCHAR(50) NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
) ENGINE=InnoDB;

-- Issue Info table
CREATE TABLE issueinfo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    studentid INT NOT NULL,
    bookid INT NOT NULL,
    issuedate DATE NOT NULL,
    returndate DATE NOT NULL,
    approve VARCHAR(10),
    FOREIGN KEY (studentid) REFERENCES student(studentid),
    FOREIGN KEY (bookid) REFERENCES books(bookid)
) ENGINE=InnoDB;

-- Timer table
CREATE TABLE timer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stdid INT NOT NULL,
    bid INT NOT NULL,
    date DATETIME NOT NULL,
    FOREIGN KEY (stdid) REFERENCES student(studentid),
    FOREIGN KEY (bid) REFERENCES books(bookid)
) ENGINE=InnoDB;

-- System Settings table (fine_per_day setting retained as it's for late fees)
CREATE TABLE system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Create indexes for performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_student_id ON users(student_id);
CREATE INDEX idx_books_title ON books(bookname);
CREATE INDEX idx_books_authorid ON books(authorid);
CREATE INDEX idx_books_isbn ON books(ISBN);
CREATE INDEX idx_books_categoryid ON books(categoryid);
CREATE INDEX idx_borrowings_user_id ON borrowings(user_id);
CREATE INDEX idx_borrowings_bookid ON borrowings(bookid);
CREATE INDEX idx_borrowings_due_date ON borrowings(due_date);
CREATE INDEX idx_borrowings_status ON borrowings(status);
CREATE INDEX idx_audit_log_user_id ON audit_log(user_id);
CREATE INDEX idx_audit_log_action ON audit_log(action);
CREATE INDEX idx_audit_log_created_at ON audit_log(created_at);

-- Insert default system settings (removed price-related settings)
INSERT INTO system_settings (setting_key, setting_value, description) VALUES
('max_borrow_days', '14', 'Maximum number of days a book can be borrowed'),
('max_books_per_user', '5', 'Maximum number of books a user can borrow at once'),
('library_email', 'library@abcinstitute.edu', 'Library contact email'),
('library_phone', '+94 11 2345678', 'Library contact phone'),
('max_login_attempts', '5', 'Maximum failed login attempts before lockout'),
('lockout_time', '900', 'Lockout duration in seconds after max failed attempts'),
('library_name', 'ABC Institute Library', 'Name of the library'),
('library_address', '123 Education Street, Colombo, Sri Lanka', 'Physical address of the library');

-- Insert literary categories
INSERT INTO category (categoryname) VALUES
('Sri Lankan Literature'),
('Fiction'),
('Historical Fiction'),
('Memoir'),
('Satire'),
('Coming-of-Age'),
('Thriller'),
('Classic Literature'),
('Sports Fiction');

-- Insert Sri Lankan authors
INSERT INTO authors (authorname, nationality, biography) VALUES
('Shehan Karunatilaka', 'Sri Lankan', 'Winner of the Booker Prize for "The Seven Moons of Maali Almeida"'),
('Shyam Selvadurai', 'Sri Lankan-Canadian', 'Author of acclaimed novels about Sri Lankan society'),
('Michael Ondaatje', 'Sri Lankan-Canadian', 'Author of "The English Patient" and other internationally acclaimed works'),
('Romesh Gunesekera', 'Sri Lankan-British', 'Booker Prize shortlisted author known for his lyrical prose'),
('Leonard Woolf', 'British', 'Colonial civil servant who wrote the classic "The Village in the Jungle"'),
('Nihal de Silva', 'Sri Lankan', 'Author and environmentalist who won the Gratiaen Prize'),
('Sonali Deraniyagala', 'Sri Lankan', 'Author of the devastating tsunami memoir "Wave"'),
('Martin Wickramasinghe', 'Sri Lankan', 'Considered the father of modern Sinhala literature'),
('Pradeep Mathew', 'Sri Lankan', 'Fictional cricketer from "Chinaman" (included for completeness)');

-- Insert Sri Lankan books collection with unique ISBNs (price column removed)
INSERT INTO books (bookname, authorid, categoryid, ISBN, publisher, publication_year, quantity, description, awards) VALUES
('The Seven Moons of Maali Almeida', 1, 5, '978-1784743461', 'Sort of Books', 2022, 5, 
 'A satirical and fantastical look at the Sri Lankan Civil War through the eyes of a dead war photographer.',
 'Booker Prize 2022 Winner'),

('Funny Boy', 2, 6, '978-0771008671', 'McClelland & Stewart', 1994, 3,
 'A coming-of-age novel about a young boy growing up gay in a privileged Tamil family in Colombo during the years leading up to the 1983 anti-Tamil pogroms.',
 'Lambda Literary Award'),

('Running in the Family', 3, 4, '978-0771008672', 'McClelland & Stewart', 1982, 4,
 'A poetic memoir where the author returns to Sri Lanka to explore his family''s history and the country''s colonial past.',
 'Books in Canada First Novel Award'),

('Anil''s Ghost', 3, 3, '978-0771065390', 'McClelland & Stewart', 2000, 4,
 'A powerful novel about a forensic anthropologist who returns to Sri Lanka during its civil war to investigate political murders.',
 'Giller Prize Finalist'),

('Reef', 4, 2, '978-1862070273', 'Granta Books', 1994, 3,
 'The story of a young man who becomes a chef in a wealthy household in 1960s Ceylon, offering a poignant look at class and colonialism.',
 'Booker Prize Shortlist 1994'),

('The Village in the Jungle', 5, 8, '978-9552144013', 'Vijitha Yapa', 1913, 2,
 'An unflinching portrayal of the harsh realities of village life and poverty in early 20th century Ceylon.',
 'Classic of Colonial Literature'),

('The Road from Elephant Pass', 6, 7, '978-9556650313', 'Vijitha Yapa', 2003, 3,
 'A thriller set during the civil war about an army officer and a female Tamil Tiger guerrilla on an unlikely journey.',
 'Gratiaen Prize Winner'),

('Wave', 7, 4, '978-0345804310', 'Knopf', 2013, 3,
 'A moving memoir about losing her entire family in the 2004 tsunami.',
 'National Book Critics Circle Award Finalist'),

('Gamperaliya', 8, 1, '978-9552102037', 'S. Godage & Brothers', 1944, 2,
 'A classic of Sinhala literature depicting social and economic changes in a traditional Sri Lankan village.',
 'First novel in the Koggala Trilogy'),

('Chinaman: The Legend of Pradeep Mathew', 1, 9, '978-0224091561', 'Jonathan Cape', 2010, 4,
 'A witty story about an alcoholic journalist''s quest to find a forgotten Sri Lankan cricketer.',
 'Commonwealth Writers'' Prize, DSC Prize for South Asian Literature');

-- Insert sample admin user
-- Default password: Admin@123 (bcrypt hash)
INSERT INTO users (username, password_hash, name, email, role, status) VALUES
('admin', '123', 'System Administrator', 'admin@abcinstitute.edu', 'admin', 'active');

-- Insert sample librarian
-- Default password: Librarian@123
INSERT INTO users (username, password_hash, name, email, role, status) VALUES
('librarian1', '123', 'Jane Doe', 'librarian@abcinstitute.edu', 'librarian', 'active');

-- Insert sample student
-- Default password: Student@123
INSERT INTO users (username, password_hash, name, email, student_id, role, status) VALUES
('student1', '123', 'John Smith', 'student1@abcinstitute.edu', 'STU2023001', 'student', 'active');

-- Insert student profile
INSERT INTO student (student_username, FullName, Email, Password, PhoneNumber, department) VALUES
('student1', 'John Smith', 'student1@abcinstitute.edu', '123', '1234567890', 'English Literature');

-- Mark some books as trending
INSERT INTO trendingbook (bookid) VALUES (1), (2), (3);

-- Insert sample feedback
INSERT INTO feedback (stdid, rating, comment) VALUES
(1, 5, 'The Sri Lankan literature collection is outstanding! Especially loved "The Seven Moons of Maali Almeida"'),
(1, 4, 'Great to see such a comprehensive collection of local authors'),
(1, 5, 'The library has helped me discover amazing Sri Lankan writers I never knew about');

-- Create database user with appropriate privileges
CREATE USER IF NOT EXISTS 'library_admin'@'localhost' IDENTIFIED BY 'SecurePassword123';
GRANT ALL PRIVILEGES ON library_management_system.* TO 'library_admin'@'localhost';
FLUSH PRIVILEGES;

COMMIT;