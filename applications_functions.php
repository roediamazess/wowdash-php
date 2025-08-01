<?php
/**
 * Applications Functions
 * File: applications_functions.php
 * Description: Functions untuk CRUD operations applications
 */

include_once __DIR__ . '/partials/db_connection.php';

class ApplicationsManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Get all applications
    public function getAllApplications() {
        $sql = "SELECT * FROM applications ORDER BY app_code";
        $result = $this->conn->query($sql);
        
        $applications = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $applications[] = $row;
            }
        }
        
        return $applications;
    }
    
    // Get application by ID
    public function getApplicationById($id) {
        $sql = "SELECT * FROM applications WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    // Create new application
    public function createApplication($data) {
        $sql = "INSERT INTO applications (app_code, app_name) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $data['app_code'], $data['app_name']);
        
        $result = $stmt->execute();
        return $result ? $this->conn->insert_id : false;
    }
    
    // Update application
    public function updateApplication($id, $data) {
        $sql = "UPDATE applications SET app_code = ?, app_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssi', $data['app_code'], $data['app_name'], $id);
        
        return $stmt->execute();
    }
    
    // Delete application
    public function deleteApplication($id) {
        $sql = "DELETE FROM applications WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }
    
    // Check if app_code exists
    public function checkAppCodeExists($app_code, $exclude_id = null) {
        $sql = "SELECT COUNT(*) as count FROM applications WHERE app_code = ?";
        if ($exclude_id) {
            $sql .= " AND id != ?";
        }
        
        $stmt = $this->conn->prepare($sql);
        if ($exclude_id) {
            $stmt->bind_param('si', $app_code, $exclude_id);
        } else {
            $stmt->bind_param('s', $app_code);
        }
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager = new ApplicationsManager($conn);
    $response = ['success' => false, 'message' => ''];
    
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'get_applications':
            $applications = $manager->getAllApplications();
            $response = ['success' => true, 'data' => $applications];
            break;
            
        case 'get_application':
            if (isset($_POST['id'])) {
                $application = $manager->getApplicationById($_POST['id']);
                if ($application) {
                    $response = ['success' => true, 'data' => $application];
                } else {
                    $response = ['success' => false, 'message' => 'Application not found'];
                }
            }
            break;
            
        case 'create_application':
            $app_code = $_POST['app_code'] ?? '';
            $app_name = $_POST['app_name'] ?? '';
            
            if (empty($app_code) || empty($app_name)) {
                $response = ['success' => false, 'message' => 'App Code and App Name are required'];
            } elseif ($manager->checkAppCodeExists($app_code)) {
                $response = ['success' => false, 'message' => 'App Code already exists'];
            } else {
                $data = ['app_code' => $app_code, 'app_name' => $app_name];
                $result = $manager->createApplication($data);
                
                if ($result) {
                    $response = ['success' => true, 'message' => 'Application created successfully'];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to create application'];
                }
            }
            break;
            
        case 'update_application':
            if (isset($_POST['id'])) {
                $app_code = $_POST['app_code'] ?? '';
                $app_name = $_POST['app_name'] ?? '';
                
                if (empty($app_code) || empty($app_name)) {
                    $response = ['success' => false, 'message' => 'App Code and App Name are required'];
                } elseif ($manager->checkAppCodeExists($app_code, $_POST['id'])) {
                    $response = ['success' => false, 'message' => 'App Code already exists'];
                } else {
                    $data = ['app_code' => $app_code, 'app_name' => $app_name];
                    $result = $manager->updateApplication($_POST['id'], $data);
                    
                    if ($result) {
                        $response = ['success' => true, 'message' => 'Application updated successfully'];
                    } else {
                        $response = ['success' => false, 'message' => 'Failed to update application'];
                    }
                }
            }
            break;
            
        case 'delete_application':
            if (isset($_POST['id'])) {
                $result = $manager->deleteApplication($_POST['id']);
                
                if ($result) {
                    $response = ['success' => true, 'message' => 'Application deleted successfully'];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to delete application'];
                }
            }
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?> 