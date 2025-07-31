CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_tier VARCHAR(100),
    start_work DATE,
    user_role VARCHAR(100),
    user_email VARCHAR(255),
    birthday DATE
);
