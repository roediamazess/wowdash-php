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
        
        // Use the actual table structure
        $sql = "SELECT da.*, da.application as application_name, '' as application_code 
                FROM detail_activities da";
        
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
        
        // Use the actual table structure
        $sql = "SELECT da.*, da.application as application_name, '' as application_code 
                FROM detail_activities da 
                WHERE da.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Create new activity
    public function createActivity($data) {
        try {
            // Validate required fields
            $required_fields = ['type', 'application', 'description'];
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    return ['success' => false, 'message' => "Missing required field: $field"];
                }
            }
            
            // Generate activity number if not provided
            $activity_number = $data['activity_number'] ?? 'ACT' . date('md') . rand(100, 999);
            
            // Prepare SQL statement
            $sql = "INSERT INTO detail_activities (project_id, activity_number, information_date, user_position, department, application, type, description, action_solution, due_date, status, cnc_number, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $this->conn->error];
            }
            
            // Prepare data for binding
            $project_id = $data['project_id'] ?? '';
            $information_date = $data['information_date'] ?? '';
            $user_position = $data['user_position'] ?? '';
            $department = $data['department'] ?? '';
            $application = $data['application'] ?? '';
            $type = $data['type'] ?? '';
            $description = $data['description'] ?? '';
            $action_solution = $data['action_solution'] ?? '';
            $due_date = $data['due_date'] ?? '';
            $status = $data['status'] ?? '';
            $cnc_number = $data['cnc_number'] ?? '';
            $created_by = $data['created_by'] ?? 1;
            
            // Bind parameters
            $bind_result = $stmt->bind_param('ssssssssssssi', 
                $project_id,
                $activity_number,
                $information_date,
                $user_position,
                $department,
                $application,
                $type,
                $description,
                $action_solution,
                $due_date,
                $status,
                $cnc_number,
                $created_by
            );
            
            if (!$bind_result) {
                return ['success' => false, 'message' => 'Database bind error: ' . $stmt->error];
            }
            
            // Execute the statement
            $execute_result = $stmt->execute();
            if (!$execute_result) {
                return ['success' => false, 'message' => 'Database execute error: ' . $stmt->error];
            }
            
            // Get the inserted ID
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            
            return ['success' => true, 'message' => 'Activity created successfully', 'id' => $inserted_id];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Update activity
    public function updateActivity($id, $data) {
        try {
            // Validate required fields
            $required_fields = ['type', 'application', 'description'];
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    return ['success' => false, 'message' => "Missing required field: $field"];
                }
            }
            
            $sql = "UPDATE detail_activities SET
                    project_id = ?,
                    information_date = ?,
                    user_position = ?,
                    department = ?,
                    application = ?,
                    type = ?,
                    description = ?,
                    action_solution = ?,
                    due_date = ?,
                    status = ?,
                    cnc_number = ?
                    WHERE id = ?";
            
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                return ['success' => false, 'message' => 'Database prepare error: ' . $this->conn->error];
            }
            
            $project_id = $data['project_id'] ?? '';
            $information_date = $data['information_date'] ?? '';
            $user_position = $data['user_position'] ?? '';
            $department = $data['department'] ?? '';
            $application = $data['application'] ?? '';
            $type = $data['type'] ?? '';
            $description = $data['description'] ?? '';
            $action_solution = $data['action_solution'] ?? '';
            $due_date = $data['due_date'] ?? '';
            $status = $data['status'] ?? '';
            $cnc_number = $data['cnc_number'] ?? '';
            
            $stmt->bind_param('sssssssssssi',
                $project_id,
                $information_date,
                $user_position,
                $department,
                $application,
                $type,
                $description,
                $action_solution,
                $due_date,
                $status,
                $cnc_number,
                $id
            );
            
            $result = $stmt->execute();
            $stmt->close();
            
            if ($result) {
                return ['success' => true, 'message' => 'Activity updated successfully', 'id' => $id];
            } else {
                return ['success' => false, 'message' => 'Database execute error: ' . $stmt->error];
            }
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    
    // Delete activity
    public function deleteActivity($id) {
        $sql = "DELETE FROM detail_activities WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    // Get departments
    public function getDepartments() {
        $sql = "SELECT DISTINCT department FROM detail_activities WHERE department IS NOT NULL AND department != '' ORDER BY department";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get applications
    public function getApplications() {
        // Check if applications table exists
        $checkTable = $this->conn->query("SHOW TABLES LIKE 'applications'");
        if ($checkTable->num_rows == 0) {
            return [];
        }
        
        $sql = "SELECT id, app_code as code, app_name as name FROM applications ORDER BY app_name";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Get activity types
    public function getActivityTypes() {
        return [
            ['type' => 'Bug Fix'],
            ['type' => 'Feature Request'],
            ['type' => 'Improvement'],
            ['type' => 'Maintenance'],
            ['type' => 'Support']
        ];
    }
    
    // Get status options
    public function getStatusOptions() {
        return [
            ['status' => 'Open'],
            ['status' => 'In Progress'],
            ['status' => 'Completed'],
            ['status' => 'On Hold'],
            ['status' => 'Cancelled']
        ];
    }
    
    // Search activities
    public function searchActivities($searchTerm, $limit = 20) {
        $sql = "SELECT da.*, da.application as application_name, '' as application_code 
                FROM detail_activities da 
                WHERE da.description LIKE ? OR da.activity_number LIKE ? OR da.application LIKE ?
                ORDER BY da.created_at DESC LIMIT ?";
        
        $searchPattern = "%$searchTerm%";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssi', $searchPattern, $searchPattern, $searchPattern, $limit);
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
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Ensure clean output
    if (ob_get_level()) {
        ob_end_clean();
    }
    ob_start();
    
    $manager = new DetailActivitiesManager($conn);
    $response = ['success' => false, 'message' => 'Invalid action'];
    
    // Set headers
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');
    
    try {
        switch ($_POST['action']) {
            case 'create':
                $data = [
                    'project_id' => $_POST['project_id'] ?? null,
                    'activity_number' => $_POST['activity_number'] ?? null,
                    'information_date' => $_POST['information_date'] ?? null,
                    'user_position' => $_POST['user_position'] ?? null,
                    'department' => $_POST['department'] ?? null,
                    'application' => $_POST['application'] ?? null,
                    'type' => $_POST['type'] ?? null,
                    'description' => $_POST['description'] ?? null,
                    'action_solution' => $_POST['action_solution'] ?? null,
                    'due_date' => $_POST['due_date'] ?? null,
                    'status' => $_POST['status'] ?? null,
                    'cnc_number' => $_POST['cnc_number'] ?? null,
                    'created_by' => $_SESSION['user_id'] ?? 1
                ];
                
                $result = $manager->createActivity($data);
                echo json_encode($result);
                break;
            
            case 'update_activity':
                if (isset($_POST['id'])) {
                    try {
                        $data = [
                            'project_id' => $_POST['project_id'] ?? '',
                            'activity_number' => $_POST['activity_number'] ?? '',
                            'information_date' => $_POST['information_date'] ?? '',
                            'user_position' => $_POST['user_position'] ?? '',
                            'department' => $_POST['department'] ?? '',
                            'application' => $_POST['application'] ?? '',
                            'type' => $_POST['type'] ?? '',
                            'description' => $_POST['description'] ?? '',
                            'action_solution' => $_POST['action_solution'] ?? '',
                            'due_date' => $_POST['due_date'] ?? '',
                            'status' => $_POST['status'] ?? '',
                            'cnc_number' => $_POST['cnc_number'] ?? ''
                        ];
                        
                        $result = $manager->updateActivity($_POST['id'], $data);
                        echo json_encode($result);
                    } catch (Exception $e) {
                        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Missing activity ID']);
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
                echo json_encode($response);
                break;
                
            case 'get_applications':
                $applications = $manager->getApplications();
                $response = ['success' => true, 'data' => $applications];
                echo json_encode($response);
                break;
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
    // End output buffering and send
    ob_end_flush();
    exit();
}
?> 