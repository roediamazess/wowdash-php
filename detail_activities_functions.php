<?php
// Detail Activities Functions
// File: detail_activities_functions.php

require_once './partials/db_connection.php';

class DetailActivitiesManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Get all detail activities with pagination and filters
    public function getAllActivities($limit = 20, $offset = 0, $status = null, $department = null) {
        // Check if detail_activities table exists
        $checkDetailTable = $this->conn->query("SHOW TABLES LIKE 'detail_activities'");
        if ($checkDetailTable->num_rows == 0) {
            return [];
        }
        
        // Check if applications table exists and has the required columns
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'applications'");
        if ($checkTable->num_rows > 0) {
            // Check if application_id column exists in detail_activities
            $checkAppIdColumn = $this->conn->query("SHOW COLUMNS FROM detail_activities LIKE 'application_id'");
            if ($checkAppIdColumn->num_rows > 0) {
                $checkColumns = $this->conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
                if ($checkColumns->num_rows > 0) {
                    $sql = "SELECT da.*, a.app_name as application_name, a.app_code as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id";
                } else {
                    $sql = "SELECT da.*, a.app_name as application_name, '' as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id";
                }
            } else {
                $sql = "SELECT da.*, '' as application_name, '' as application_code 
                        FROM detail_activities da";
            }
        } else {
            $sql = "SELECT da.*, '' as application_name, '' as application_code 
                    FROM detail_activities da";
        }
        
        $params = [];
        $conditions = [];
        
        if ($status && $status !== 'All Status') {
            $conditions[] = "da.status = ?";
            $params[] = $status;
        }
        
        if ($department && $department !== 'All Department') {
            $conditions[] = "da.department = ?";
            $params[] = $department;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY da.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get single activity by ID
    public function getActivityById($id) {
        // Check if detail_activities table exists
        $checkDetailTable = $this->conn->query("SHOW TABLES LIKE 'detail_activities'");
        if ($checkDetailTable->num_rows == 0) {
            return null;
        }
        
        // Check if applications table exists and has the required columns
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'applications'");
        if ($checkTable->num_rows > 0) {
            // Check if application_id column exists in detail_activities
            $checkAppIdColumn = $this->conn->query("SHOW COLUMNS FROM detail_activities LIKE 'application_id'");
            if ($checkAppIdColumn->num_rows > 0) {
                $checkColumns = $this->conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
                if ($checkColumns->num_rows > 0) {
                    $sql = "SELECT da.*, a.app_name as application_name, a.app_code as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id 
                            WHERE da.id = ?";
                } else {
                    $sql = "SELECT da.*, a.app_name as application_name, '' as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id 
                            WHERE da.id = ?";
                }
            } else {
                $sql = "SELECT da.*, '' as application_name, '' as application_code 
                        FROM detail_activities da 
                        WHERE da.id = ?";
            }
        } else {
            $sql = "SELECT da.*, '' as application_name, '' as application_code 
                    FROM detail_activities da 
                    WHERE da.id = ?";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Create new activity
    public function createActivity($data) {
        try {
            $sql = "INSERT INTO detail_activities (project_id, information_date, user_position, department, application_id, type, description, action_solution, due_date, status, cnc_number, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Debug: Log SQL and data
            error_log("SQL: " . $sql);
            error_log("Data for binding: " . print_r($data, true));
            
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                error_log("Prepare failed: " . $this->conn->error);
                return false;
            }
            
            // Handle null values properly
            $project_id = $data['project_id'] ?? '';
            $information_date = $data['information_date'] ?? '';
            $user_position = $data['user_position'] ?? '';
            $department = $data['department'] ?? '';
            $application_id = ($data['application_id'] && $data['application_id'] !== '') ? $data['application_id'] : null;
            $type = $data['type'] ?? '';
            $description = $data['description'] ?? '';
            $action_solution = $data['action_solution'] ?? '';
            $due_date = $data['due_date'] ?? '';
            $status = $data['status'] ?? '';
            $cnc_number = $data['cnc_number'] ?? '';
            $created_by = $data['created_by'] ?? 1;
            
            // Debug: Log binding parameters
            error_log("Binding parameters: project_id='$project_id', information_date='$information_date', user_position='$user_position', department='$department', application_id='" . ($application_id ?? 'NULL') . "', type='$type', description='$description', action_solution='$action_solution', due_date='$due_date', status='$status', cnc_number='$cnc_number', created_by='$created_by'");
            
            $bind_result = $stmt->bind_param('ssssissssssi', 
                $project_id,
                $information_date,
                $user_position,
                $department,
                $application_id,
                $type,
                $description,
                $action_solution,
                $due_date,
                $status,
                $cnc_number,
                $created_by
            );
            
            if (!$bind_result) {
                error_log("Bind failed: " . $stmt->error);
                return false;
            }
            
            $result = $stmt->execute();
            if (!$result) {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
            
            $insert_id = $this->conn->insert_id;
            error_log("Insert successful, ID: " . $insert_id);
            return $insert_id;
            
        } catch (Exception $e) {
            error_log("Exception in createActivity: " . $e->getMessage());
            return false;
        }
    }
    
    // Update activity
    public function updateActivity($id, $data) {
        $sql = "UPDATE detail_activities SET 
                project_id = ?,
                information_date = ?, 
                user_position = ?, 
                department = ?, 
                application_id = ?, 
                type = ?, 
                description = ?, 
                action_solution = ?, 
                due_date = ?, 
                status = ?, 
                cnc_number = ? 
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        // Handle null values properly
        $project_id = $data['project_id'] ?? '';
        $information_date = $data['information_date'] ?? '';
        $user_position = $data['user_position'] ?? '';
        $department = $data['department'] ?? '';
        $application_id = ($data['application_id'] && $data['application_id'] !== '') ? $data['application_id'] : null;
        $type = $data['type'] ?? '';
        $description = $data['description'] ?? '';
        $action_solution = $data['action_solution'] ?? '';
        $due_date = $data['due_date'] ?? '';
        $status = $data['status'] ?? '';
        $cnc_number = $data['cnc_number'] ?? '';
        
        $stmt->bind_param('ssssissssssi', 
            $project_id,
            $information_date,
            $user_position,
            $department,
            $application_id,
            $type,
            $description,
            $action_solution,
            $due_date,
            $status,
            $cnc_number,
            $id
        );
        
        return $stmt->execute();
    }
    
    // Delete activity
    public function deleteActivity($id) {
        $sql = "DELETE FROM detail_activities WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    
    // Get departments
    public function getDepartments() {
        return [
            'Food & Beverage',
            'Kitchen', 
            'Room Division',
            'Front Office',
            'Housekeeping',
            'Engineering',
            'Sales & Marketing',
            'IT / EDP',
            'Accounting',
            'Executive Office'
        ];
    }
    
    // Get applications
    public function getApplications() {
        // Check if applications table exists
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'applications'");
        if ($checkTable->num_rows > 0) {
            $checkColumns = $this->conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
            if ($checkColumns->num_rows > 0) {
                $sql = "SELECT id, app_code as code, app_name as name FROM applications ORDER BY app_name";
            } else {
                $sql = "SELECT id, '' as code, app_name as name FROM applications ORDER BY app_name";
            }
            $result = $this->conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Return empty array if table doesn't exist
            return [];
        }
    }
    
    // Get activity types
    public function getActivityTypes() {
        return [
            'Setup',
            'Question',
            'Issue',
            'Report Issue',
            'Report Request',
            'Feature Request'
        ];
    }
    
    // Get status options
    public function getStatusOptions() {
        return [
            'Open',
            'On Progress',
            'Need Requirement',
            'Done'
        ];
    }
    
    // Search activities
    public function searchActivities($searchTerm, $limit = 20) {
        // Check if detail_activities table exists
        $checkDetailTable = $this->conn->query("SHOW TABLES LIKE 'detail_activities'");
        if ($checkDetailTable->num_rows == 0) {
            return [];
        }
        
        // Check if applications table exists and has the required columns
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'applications'");
        if ($checkTable->num_rows > 0) {
            // Check if application_id column exists in detail_activities
            $checkAppIdColumn = $this->conn->query("SHOW COLUMNS FROM detail_activities LIKE 'application_id'");
            if ($checkAppIdColumn->num_rows > 0) {
                $checkColumns = $this->conn->query("SHOW COLUMNS FROM applications LIKE 'app_code'");
                if ($checkColumns->num_rows > 0) {
                    $sql = "SELECT da.*, a.app_name as application_name, a.app_code as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id 
                            WHERE da.project_id LIKE ? 
                            OR da.user_position LIKE ? 
                            OR da.description LIKE ? 
                            OR da.action_solution LIKE ?
                            ORDER BY da.created_at DESC LIMIT ?";
                } else {
                    $sql = "SELECT da.*, a.app_name as application_name, '' as application_code 
                            FROM detail_activities da 
                            LEFT JOIN applications a ON da.application_id = a.id 
                            WHERE da.project_id LIKE ? 
                            OR da.user_position LIKE ? 
                            OR da.description LIKE ? 
                            OR da.action_solution LIKE ?
                            ORDER BY da.created_at DESC LIMIT ?";
                }
            } else {
                $sql = "SELECT da.*, '' as application_name, '' as application_code 
                        FROM detail_activities da 
                        WHERE da.project_id LIKE ? 
                        OR da.user_position LIKE ? 
                        OR da.description LIKE ? 
                        OR da.action_solution LIKE ?
                        ORDER BY da.created_at DESC LIMIT ?";
            }
        } else {
            $sql = "SELECT da.*, '' as application_name, '' as application_code 
                    FROM detail_activities da 
                    WHERE da.project_id LIKE ? 
                    OR da.user_position LIKE ? 
                    OR da.description LIKE ? 
                    OR da.action_solution LIKE ?
                    ORDER BY da.created_at DESC LIMIT ?";
        }
        
        $searchPattern = "%$searchTerm%";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssssi', $searchPattern, $searchPattern, $searchPattern, $searchPattern, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get activity count by status
    public function getActivityCountByStatus() {
        $sql = "SELECT status, COUNT(*) as count FROM detail_activities GROUP BY status";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $manager = new DetailActivitiesManager($conn);
    $response = ['success' => false, 'message' => 'Invalid action'];
    
    switch ($_POST['action']) {
        case 'get_activity':
            if (isset($_POST['id'])) {
                $activity = $manager->getActivityById($_POST['id']);
                if ($activity) {
                    $response = ['success' => true, 'data' => $activity];
                } else {
                    $response = ['success' => false, 'message' => 'Activity not found'];
                }
            }
            break;
            
        case 'create_activity':
            try {
                // Debug: Log received data
                error_log("Received POST data: " . print_r($_POST, true));
                
                $data = [
                    'project_id' => $_POST['project_id'] ?? '',
                    'information_date' => $_POST['information_date'] ?? '',
                    'user_position' => $_POST['user_position'] ?? '',
                    'department' => $_POST['department'] ?? '',
                    'application_id' => ($_POST['application_id'] && $_POST['application_id'] !== '') ? $_POST['application_id'] : null,
                    'type' => $_POST['type'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'action_solution' => $_POST['action_solution'] ?? '',
                    'due_date' => $_POST['due_date'] ?? '',
                    'status' => $_POST['status'] ?? '',
                    'cnc_number' => $_POST['cnc_number'] ?? '',
                    'created_by' => 1
                ];
                
                // Debug: Log processed data
                error_log("Processed data: " . print_r($data, true));
                
                $result = $manager->createActivity($data);
                if ($result) {
                    $response = ['success' => true, 'message' => 'Activity created successfully', 'id' => $result];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to create activity'];
                }
            } catch (Exception $e) {
                error_log("Exception in create_activity: " . $e->getMessage());
                $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
            break;
            
        case 'update_activity':
            if (isset($_POST['id'])) {
                try {
                    $data = [
                        'project_id' => $_POST['project_id'] ?? '',
                        'information_date' => $_POST['information_date'] ?? '',
                        'user_position' => $_POST['user_position'] ?? '',
                        'department' => $_POST['department'] ?? '',
                        'application_id' => ($_POST['application_id'] && $_POST['application_id'] !== '') ? $_POST['application_id'] : null,
                        'type' => $_POST['type'] ?? '',
                        'description' => $_POST['description'] ?? '',
                        'action_solution' => $_POST['action_solution'] ?? '',
                        'due_date' => $_POST['due_date'] ?? '',
                        'status' => $_POST['status'] ?? '',
                        'cnc_number' => $_POST['cnc_number'] ?? ''
                    ];
                    
                    $result = $manager->updateActivity($_POST['id'], $data);
                    if ($result) {
                        $response = ['success' => true, 'message' => 'Activity updated successfully'];
                    } else {
                        $response = ['success' => false, 'message' => 'Failed to update activity'];
                    }
                } catch (Exception $e) {
                    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
                }
            }
            break;
            
        case 'delete_activity':
            if (isset($_POST['id'])) {
                $result = $manager->deleteActivity($_POST['id']);
                if ($result) {
                    $response = ['success' => true, 'message' => 'Activity deleted successfully'];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to delete activity'];
                }
            }
            break;
            
        case 'get_applications':
            $applications = $manager->getApplications();
            $response = ['success' => true, 'data' => $applications];
            break;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?> 