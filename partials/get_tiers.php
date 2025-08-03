<?php
// get_tiers.php - Fetch tier data from database

// Include database connection
include_once __DIR__ . '/db_connection.php';

// Function to get all tiers from database
function getTiers() {
    global $conn;
    
    $tiers = array();
    
    // Query to fetch tiers (assuming there's a tiers table)
    $sql = "SELECT tier_code, tier_name FROM tiers ORDER BY id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tiers[] = $row;
        }
    } else {
        // If no data in database, use default values
        $tiers = array(
            array("tier_code" => "New Born", "tier_name" => "Baru Masuk"),
            array("tier_code" => "Tier 1", "tier_name" => "Baru Assist"),
            array("tier_code" => "Tier 2", "tier_name" => "Trial Leader"),
            array("tier_code" => "Tier 3", "tier_name" => "Leader")
        );
    }
    
    return $tiers;
}

// Function to generate HTML options for select dropdown
function generateTierOptions($selectedTier = "") {
    $tiers = getTiers();
    $options = '<option value="">Select Tier</option>';
    
    foreach($tiers as $tier) {
        $selected = ($tier['tier_code'] == $selectedTier) ? 'selected' : '';
        $options .= '<option value="' . $tier['tier_code'] . '" ' . $selected . '>' . $tier['tier_code'] . '</option>';
    }
    
    return $options;
}
