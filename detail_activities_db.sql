-- Detail Activities Database Structure
-- File: detail_activities_db.sql

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS ultimate_dashboard;
USE ultimate_dashboard;

-- Create detail_activities table
CREATE TABLE IF NOT EXISTS detail_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id VARCHAR(50) NOT NULL,
    activity_number INT AUTO_INCREMENT,
    information_date DATE NOT NULL,
    user_position VARCHAR(255) NOT NULL,
    department ENUM('Food & Beverage', 'Kitchen', 'Room Division', 'Front Office', 'Housekeeping', 'Engineering', 'Sales & Marketing', 'IT / EDP', 'Accounting', 'Executive Office') NOT NULL,
    application_id INT,
    type ENUM('Setup', 'Question', 'Issue', 'Report Issue', 'Report Request', 'Feature Request') NOT NULL,
    description TEXT NOT NULL,
    action_solution TEXT NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('Open', 'On Progress', 'Need Requirement', 'Done') NOT NULL DEFAULT 'Open',
    cnc_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT DEFAULT 1,
    INDEX idx_project_id (project_id),
    INDEX idx_department (department),
    INDEX idx_application_id (application_id),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date)
);

-- Create applications table (if not exists)
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample applications data
INSERT INTO applications (code, name, description) VALUES
('POS8', 'Cloud POS', 'Point of Sale System'),
('AR8', 'Cloud AR', 'Accounts Receivable System'),
('INV8', 'Cloud INV', 'Inventory Management System'),
('AP8', 'Cloud AP', 'Accounts Payable System'),
('GL8', 'Cloud GL', 'General Ledger System'),
('HR8', 'Cloud HR', 'Human Resources System'),
('CRM8', 'Cloud CRM', 'Customer Relationship Management'),
('BI8', 'Cloud BI', 'Business Intelligence System');

-- Insert sample detail activities data
INSERT INTO detail_activities (project_id, information_date, user_position, department, application_id, type, description, action_solution, due_date, status, cnc_number) VALUES
('PRJ-001', '2024-01-15', 'John Doe - Manager', 'Food & Beverage', 1, 'Setup', 'Setup new POS system for restaurant', 'Installation completed, training scheduled', '2024-01-31', 'On Progress', 'CNC-001'),
('PRJ-002', '2024-01-16', 'Jane Smith - Supervisor', 'Kitchen', 2, 'Issue', 'Kitchen equipment malfunction', 'Technician called, replacement parts ordered', '2024-01-25', 'Open', 'CNC-002'),
('PRJ-003', '2024-01-17', 'Mike Johnson - Engineer', 'Engineering', 3, 'Feature Request', 'Add inventory tracking feature', 'Development in progress, expected completion by month end', '2024-02-15', 'On Progress', 'CNC-003'),
('PRJ-004', '2024-01-18', 'Sarah Wilson - Director', 'Sales & Marketing', 4, 'Report Request', 'Generate monthly sales report', 'Report template created, automation in progress', '2024-01-30', 'Need Requirement', 'CNC-004'),
('PRJ-005', '2024-01-19', 'David Brown - Analyst', 'IT / EDP', 5, 'Question', 'Database performance optimization', 'Analysis completed, recommendations provided', '2024-01-28', 'Done', 'CNC-005');

-- Add foreign key constraint for application_id
ALTER TABLE detail_activities 
ADD CONSTRAINT fk_detail_activities_application 
FOREIGN KEY (application_id) REFERENCES applications(id) 
ON DELETE SET NULL ON UPDATE CASCADE; 