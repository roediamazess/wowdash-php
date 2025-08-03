<?php
// get_user_roles.php - Fetch user roles data from database

// Include database connection
include_once __DIR__ . '/db_connection.php';

// Function to get all user roles from database
function getUserRoles() {
    global $conn;
    
    $roles = array();
    
    // Query to fetch user roles
    $sql = "SELECT role_id, role_name, description FROM user_roles ORDER BY role_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $roles[] = $row;
        }
    } else {
        // If no data in database, use default values
        $roles = array(
            array("role_id" => "Administrator", "role_name" => "Me", "description" => "Full system access"),
            array("role_id" => "Supervisor", "role_name" => "Manager", "description" => "Management level access"),
            array("role_id" => "Admin Officer", "role_name" => "Iam", "description" => "Administrative access"),
            array("role_id" => "User", "role_name" => "Team", "description" => "Standard user access"),
            array("role_id" => "Client", "role_name" => "Hotel", "description" => "Client access")
        );
    }
    
    return $roles;
}

// Function to generate HTML options for select dropdown
function generateUserRoleOptions($selectedRole = "") {
    $roles = getUserRoles();
    $options = '<option value="">Select User Role</option>';
    
    foreach($roles as $role) {
        $selected = ($role['role_id'] == $selectedRole) ? 'selected' : '';
        $options .= '<option value="' . $role['role_id'] . '" ' . $selected . '>' . $role['role_id'] . ' (' . $role['role_name'] . ')</option>';
    }
    
    return $options;
}
?> 