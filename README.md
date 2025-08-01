# Ultimate Dashboard

A comprehensive PHP-based dashboard application with modern UI and robust functionality.

## Features

### Core Modules
- **User Management**: Complete user CRUD operations
- **Detail Activities**: Advanced activity tracking with database integration
- **Settings Management**: Centralized configuration system
- **Applications Management**: Dynamic application tracking
- **Role-based Access Control**: Secure permission system

### Detail Activities Module
- **CRUD Operations**: Create, Read, Update, Delete activities
- **Database Integration**: MySQL with proper foreign key relationships
- **Dynamic Dropdowns**: Applications loaded from database
- **Search & Filter**: Advanced search functionality
- **Modal-based UI**: Modern Bootstrap modals for all operations
- **SweetAlert2 Integration**: Enhanced user notifications

### Technical Stack
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5
- **Icons**: Remix Icons
- **Notifications**: SweetAlert2
- **Charts**: ApexCharts

## Installation

1. **Prerequisites**
   - XAMPP or similar local server
   - PHP 7.4 or higher
   - MySQL 5.7 or higher

2. **Setup Database**
   ```bash
   # Run the database setup script
   php setup_database.php
   
   # Setup settings tables
   php setup_settings_database.php
   ```

3. **Configure Database Connection**
   - Edit `partials/db_connection.php`
   - Update database credentials as needed

4. **Access Application**
   - Navigate to `http://localhost/Ultimate-Dashboard/wowdash-php/`
   - Login with default credentials (if applicable)

## Database Schema

### Detail Activities Table
```sql
CREATE TABLE detail_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id VARCHAR(50),
    information_date DATE NOT NULL,
    user_position VARCHAR(255) NOT NULL,
    department ENUM(...) NOT NULL,
    application_id INT NULL,
    type ENUM(...) NOT NULL,
    description TEXT NOT NULL,
    action_solution TEXT,
    due_date DATE,
    status ENUM(...) DEFAULT 'Open',
    cnc_number VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT DEFAULT 1
);
```

### Applications Table
```sql
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_code VARCHAR(20) NOT NULL UNIQUE,
    app_name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## File Structure

```
wowdash-php/
├── assets/                 # Static assets (CSS, JS, images)
├── partials/              # Reusable PHP components
├── version_history/       # Version control backups
├── detail-activities.php  # Main Detail Activities page
├── detail_activities_functions.php  # Backend functions
├── detail_activities_simple.sql     # Database schema
├── applications_functions.php       # Applications management
├── setup_database.php              # Database setup script
└── README.md                       # This file
```

## Key Features

### Detail Activities
- **Mandatory Fields**: Information Date, User & Position, Department, Application, Type, Description
- **Optional Fields**: Project ID, Due Date, Status, Action/Solution, CNC Number
- **Row-based Interaction**: Click rows to view/edit (similar to Users sidebar)
- **Modal Operations**: Add, Edit, Delete via Bootstrap modals
- **Real-time Updates**: Table updates without page reload

### Database Integration
- **Robust Error Handling**: Comprehensive try-catch blocks
- **Null Value Support**: Proper handling of optional fields
- **Foreign Key Relationships**: Applications linked to activities
- **Data Validation**: Server-side validation with error logging

### UI/UX Features
- **Responsive Design**: Mobile-friendly interface
- **Modern Notifications**: SweetAlert2 for user feedback
- **Consistent Button Placement**: Cancel buttons on the right
- **Hover Effects**: Interactive table rows
- **Loading States**: Visual feedback during operations

## Version History

### Version 1 (Current)
- Complete Detail Activities module implementation
- Database schema with proper relationships
- Robust error handling and logging
- Modern UI with Bootstrap and SweetAlert2
- Version control backups in `version_history/` directory

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is proprietary software. All rights reserved.

## Support

For technical support or questions, please contact the development team. 