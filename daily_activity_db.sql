-- Daily Activity Database Structure
-- File: daily_activity_db.sql

-- Create daily_activities table
CREATE TABLE IF NOT EXISTS `daily_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_number` varchar(10) NOT NULL,
  `information_date` date NOT NULL,
  `user_position` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `application` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `action_solution` text NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Open',
  `cnc_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activity_number` (`activity_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `daily_activities` (`activity_number`, `information_date`, `user_position`, `department`, `application`, `type`, `description`, `action_solution`, `due_date`, `status`, `cnc_number`) VALUES
('DA-001', '2024-01-25', 'John Doe - Manager', 'Food & Beverage', 'POS System', 'Setup', 'Setup new POS system for restaurant area. Need to configure menu items, pricing, and payment methods.', 'Installation completed. Training scheduled for staff on January 28th.', '2024-01-30', 'On Progress', 'CNC-001'),
('DA-002', '2024-01-24', 'Jane Smith - Supervisor', 'Kitchen', 'Inventory System', 'Issue', 'Inventory system showing incorrect stock levels for kitchen supplies.', 'Database sync issue resolved. Stock levels updated correctly.', '2024-01-26', 'Done', 'CNC-002'),
('DA-003', '2024-01-23', 'Mike Johnson - IT Support', 'IT / EDP', 'Booking System', 'Question', 'How to configure email notifications for new bookings?', 'Email configuration completed. Test emails sent successfully.', '2024-01-25', 'Done', 'CNC-003'),
('DA-004', '2024-01-22', 'Sarah Wilson - Front Desk', 'Front Office', 'HR System', 'Report Request', 'Need monthly attendance report for all departments.', 'Report generated and sent to HR department.', '2024-01-24', 'Done', 'CNC-004'),
('DA-005', '2024-01-21', 'David Brown - Engineer', 'Engineering', 'Maintenance System', 'Feature Request', 'Add preventive maintenance scheduling feature.', 'Feature development in progress. Expected completion by end of month.', '2024-01-31', 'On Progress', 'CNC-005');

-- Create departments table for reference
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `departments` (`name`) VALUES
('Food & Beverage'),
('Kitchen'),
('Room Division'),
('Front Office'),
('Housekeeping'),
('Engineering'),
('Sales & Marketing'),
('IT / EDP'),
('Accounting'),
('Executive Office');

-- Create applications table for reference
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `applications` (`name`) VALUES
('POS System'),
('Inventory System'),
('Booking System'),
('HR System'),
('Accounting System'),
('Maintenance System'),
('Email System'),
('Reporting System');

-- Create activity types table for reference
CREATE TABLE IF NOT EXISTS `activity_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `activity_types` (`name`) VALUES
('Setup'),
('Question'),
('Issue'),
('Report Issue'),
('Report Request'),
('Feature Request');

-- Create status table for reference
CREATE TABLE IF NOT EXISTS `activity_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(20) DEFAULT 'primary',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `activity_status` (`name`, `color`) VALUES
('Open', 'primary'),
('On Progress', 'warning'),
('Need Requirement', 'info'),
('Done', 'success'); 