<?php
// Simple Test Update Activity
// File: simple_test_update.php

require_once './partials/db_connection.php';
require_once './detail_activities_functions.php';

echo "<h2>Simple Test Update Activity</h2>";

try {
    $manager = new DetailActivitiesManager($conn);
    
    // Get first activity
    $activities = $manager->getAllActivities(1);
    if (count($activities) > 0) {
        $activity = $activities[0];
        $activityId = $activity['id'];
        
        echo "Testing update for activity ID: " . $activityId . "<br>";
        echo "Current description: " . $activity['description'] . "<br>";
        
        // Test update
        $updateData = [
            'project_id' => $activity['project_id'],
            'information_date' => $activity['information_date'],
            'user_position' => $activity['user_position'],
            'department' => $activity['department'],
            'application' => $activity['application'],
            'type' => $activity['type'],
            'description' => 'TEST UPDATE - ' . date('Y-m-d H:i:s'),
            'action_solution' => $activity['action_solution'],
            'due_date' => $activity['due_date'],
            'status' => $activity['status'],
            'cnc_number' => $activity['cnc_number']
        ];
        
        $result = $manager->updateActivity($activityId, $updateData);
        
        if ($result) {
            echo "<p style='color: green;'>✓ Update successful!</p>";
            
            // Verify update
            $updatedActivity = $manager->getActivityById($activityId);
            if ($updatedActivity) {
                echo "Updated description: " . $updatedActivity['description'] . "<br>";
            }
        } else {
            echo "<p style='color: red;'>✗ Update failed!</p>";
        }
    } else {
        echo "<p style='color: red;'>No activities found to test</p>";
    }
    
    echo "<p><a href='detail-activities.php'>Go to Detail Activities Page</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?> 