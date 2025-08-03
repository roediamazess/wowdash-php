-- Settings Database Schema
-- File: settings_database.sql
-- Description: Database schema for all Settings modules

-- Create project_status table
CREATE TABLE IF NOT EXISTS project_status (
    status_id VARCHAR(50) PRIMARY KEY,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create project_type table
CREATE TABLE IF NOT EXISTS project_type (
    type_id VARCHAR(50) PRIMARY KEY,
    type_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create applications table (update existing structure)
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_code VARCHAR(20) UNIQUE,
    app_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create project_information table
CREATE TABLE IF NOT EXISTS project_information (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id VARCHAR(50) NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    client_name VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create assignment_pic table
CREATE TABLE IF NOT EXISTS assignment_pic (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pic_code VARCHAR(20) NOT NULL,
    pic_name VARCHAR(255) NOT NULL,
    position VARCHAR(100),
    department VARCHAR(100),
    email VARCHAR(255),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create tier_level table
CREATE TABLE IF NOT EXISTS tier_level (
    tier_id VARCHAR(20) PRIMARY KEY,
    tier_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create user_roles table (if not exists)
CREATE TABLE IF NOT EXISTS user_roles (
    role_id VARCHAR(50) PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default data for project_status
INSERT IGNORE INTO project_status (status_id, description) VALUES
('Scheduled', 'Jadwal yang telah diagendakan'),
('Running', 'Projek sedang berjalan'),
('Document', 'Projek selesai, namun team belum menyerahkan Berita Acara'),
('Document Check', 'Projek selesai, team sudah menyerahkan Berita Acara, belum dicek'),
('Done', 'Projek selesai, Berita Acara sudah diserahkan dan sudah dilakukan pengecekan'),
('Cancel', 'Projek dibatalkan'),
('Rejected', 'Pengajuan Projek, namun ditolak oleh pihak hotel');

-- Insert default data for project_type
INSERT IGNORE INTO project_type (type_id, type_name) VALUES
('Implementation', 'Implementation'),
('Upgrade', 'Upgrade'),
('Maintenance', 'Maintenance'),
('Retraining', 'Retraining'),
('On Line Maintenance', 'On Line Maintenance'),
('Remote Installation', 'Remote Installation'),
('On Line Training', 'On Line Training'),
('In House Training', 'In House Training'),
('Special Request', 'Special Request'),
('2nd Implementation', '2nd Implementation'),
('Others', 'Others'),
('Jakarta Support', 'Jakarta Support'),
('Bali Support', 'Bali Support');

-- Insert default data for applications (update existing table)
INSERT IGNORE INTO applications (app_code, app_name) VALUES
('FO8', 'Cloud FO'),
('POS8', 'Cloud POS'),
('AR8', 'Cloud AR'),
('INV8', 'Cloud INV'),
('AP8', 'Cloud AP'),
('GL8', 'Cloud GL');

-- Insert default data for user_roles
INSERT IGNORE INTO user_roles (role_id, role_name, description) VALUES
('Administrator', 'Me', 'Full system access'),
('Supervisor', 'Manager', 'Management level access'),
('Admin Officer', 'Iam', 'Administrative access'),
('User', 'Team', 'Standard user access'),
('Client', 'Hotel', 'Client access');

-- Insert default data for tier_level
INSERT IGNORE INTO tier_level (tier_id, tier_name, description) VALUES
('T1', 'Tier 1', 'Basic support level'),
('T2', 'Tier 2', 'Intermediate support level'),
('T3', 'Tier 3', 'Advanced support level'),
('T4', 'Tier 4', 'Expert support level');

-- Insert sample data for assignment_pic
INSERT IGNORE INTO assignment_pic (pic_code, pic_name, position, department, email, phone) VALUES
('PIC001', 'John Doe', 'Senior Developer', 'IT / EDP', 'john.doe@company.com', '+62-812-3456-7890'),
('PIC002', 'Jane Smith', 'Project Manager', 'Sales & Marketing', 'jane.smith@company.com', '+62-812-3456-7891'),
('PIC003', 'Bob Johnson', 'System Analyst', 'IT / EDP', 'bob.johnson@company.com', '+62-812-3456-7892');

-- Insert sample data for project_information
INSERT IGNORE INTO project_information (project_id, project_name, client_name, description) VALUES
('PRJ001', 'Hotel Management System Implementation', 'Grand Hotel Jakarta', 'Implementation of comprehensive hotel management system'),
('PRJ002', 'POS System Upgrade', 'Bali Resort & Spa', 'Upgrade of existing POS system to latest version'),
('PRJ003', 'Cloud Migration Project', 'Metropolitan Hotel', 'Migration of on-premise systems to cloud infrastructure'); 