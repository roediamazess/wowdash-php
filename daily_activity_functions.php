<?php
// Daily Activity Database Functions
// File: daily_activity_functions.php

require_once './partials/db_connection.php';

class DailyActivityManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Get all daily activities
    public function getAllActivities($limit = 20, $offset = 0, $status = null) {
        $sql = "SELECT * FROM daily_activities";
        $params = [];
        
        if ($status && $status !== 'All Status') {
            $sql .= " WHERE status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get single activity by ID
    public function getActivityById($id) {
        $sql = "SELECT * FROM daily_activities WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create new activity
    public function createActivity($data) {
        // Generate activity number
        $activityNumber = $this->generateActivityNumber();
        
        $sql = "INSERT INTO daily_activities (activity_number, information_date, user_position, department, application, type, description, action_solution, due_date, status, cnc_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            $activityNumber,
            $data['information_date'],
            $data['user_position'],
            $data['department'],
            $data['application'],
            $data['type'],
            $data['description'],
            $data['action_solution'],
            $data['due_date'],
            $data['status'],
            $data['cnc_number'] ?? null
        ]);
        
        return $result ? $this->conn->lastInsertId() : false;
    }
    
    // Update activity
    public function updateActivity($id, $data) {
        $sql = "UPDATE daily_activities SET 
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
        return $stmt->execute([
            $data['information_date'],
            $data['user_position'],
            $data['department'],
            $data['application'],
            $data['type'],
            $data['description'],
            $data['action_solution'],
            $data['due_date'],
            $data['status'],
            $data['cnc_number'] ?? null,
            $id
        ]);
    }
    
    // Delete activity
    public function deleteActivity($id) {
        $sql = "DELETE FROM daily_activities WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Generate unique activity number
    private function generateActivityNumber() {
        $sql = "SELECT MAX(CAST(SUBSTRING(activity_number, 4) AS UNSIGNED)) as max_num FROM daily_activities WHERE activity_number LIKE 'DA-%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $nextNum = ($result['max_num'] ?? 0) + 1;
        return 'DA-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
    }
    
    // Get departments
    public function getDepartments() {
        $sql = "SELECT * FROM departments ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get applications
    public function getApplications() {
        $sql = "SELECT * FROM applications ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get activity types
    public function getActivityTypes() {
        $sql = "SELECT * FROM activity_types ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get status options
    public function getStatusOptions() {
        $sql = "SELECT * FROM activity_status ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Search activities
    public function searchActivities($searchTerm, $limit = 20) {
        $sql = "SELECT * FROM daily_activities WHERE 
                user_position LIKE ? OR 
                department LIKE ? OR 
                application LIKE ? OR 
                description LIKE ? OR 
                cnc_number LIKE ?
                ORDER BY created_at DESC LIMIT ?";
        
        $searchPattern = "%$searchTerm%";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $searchPattern,
            $limit
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get activity count by status
    public function getActivityCountByStatus() {
        $sql = "SELECT status, COUNT(*) as count FROM daily_activities GROUP BY status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Initialize manager
$dailyActivityManager = new DailyActivityManager($conn);

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    switch ($_POST['action']) {
        case 'get_activities':
            $limit = $_POST['limit'] ?? 20;
            $offset = $_POST['offset'] ?? 0;
            $status = $_POST['status'] ?? null;
            $activities = $dailyActivityManager->getAllActivities($limit, $offset, $status);
            echo json_encode(['success' => true, 'data' => $activities]);
            break;
            
        case 'get_activity':
            $id = $_POST['id'] ?? null;
            if ($id) {
                $activity = $dailyActivityManager->getActivityById($id);
                echo json_encode(['success' => true, 'data' => $activity]);
            } else {
                echo json_encode(['success' => false, 'message' => 'ID required']);
            }
            break;
            
        case 'create_activity':
            $data = [
                'information_date' => $_POST['information_date'],
                'user_position' => $_POST['user_position'],
                'department' => $_POST['department'],
                'application' => $_POST['application'],
                'type' => $_POST['type'],
                'description' => $_POST['description'],
                'action_solution' => $_POST['action_solution'],
                'due_date' => $_POST['due_date'],
                'status' => $_POST['status'],
                'cnc_number' => $_POST['cnc_number'] ?? null
            ];
            
            $result = $dailyActivityManager->createActivity($data);
            if ($result) {
                echo json_encode(['success' => true, 'id' => $result, 'message' => 'Activity created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create activity']);
            }
            break;
            
        case 'update_activity':
            $id = $_POST['id'] ?? null;
            if ($id) {
                $data = [
                    'information_date' => $_POST['information_date'],
                    'user_position' => $_POST['user_position'],
                    'department' => $_POST['department'],
                    'application' => $_POST['application'],
                    'type' => $_POST['type'],
                    'description' => $_POST['description'],
                    'action_solution' => $_POST['action_solution'],
                    'due_date' => $_POST['due_date'],
                    'status' => $_POST['status'],
                    'cnc_number' => $_POST['cnc_number'] ?? null
                ];
                
                $result = $dailyActivityManager->updateActivity($id, $data);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Activity updated successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update activity']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID required']);
            }
            break;
            
        case 'delete_activity':
            $id = $_POST['id'] ?? null;
            if ($id) {
                $result = $dailyActivityManager->deleteActivity($id);
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Activity deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete activity']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'ID required']);
            }
            break;
            
        case 'search_activities':
            $searchTerm = $_POST['search_term'] ?? '';
            $activities = $dailyActivityManager->searchActivities($searchTerm);
            echo json_encode(['success' => true, 'data' => $activities]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
    exit;
}
?> 