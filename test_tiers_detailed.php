<?php
// Detailed test script for get_tiers.php

echo "Starting detailed test...\n";

// Check if db_connection.php exists
if (file_exists('./partials/db_connection.php')) {
    echo "db_connection.php exists\n";
} else {
    echo "db_connection.php does not exist\n";
    exit;
}

// Check if get_tiers.php exists
if (file_exists('./partials/get_tiers.php')) {
    echo "get_tiers.php exists\n";
} else {
    echo "get_tiers.php does not exist\n";
    exit;
}

// Include tier data functions
echo "Including get_tiers.php...\n";
include_once './partials/get_tiers.php';
echo "get_tiers.php included successfully.\n";

echo "\nTesting getTiers() function:\n";
$tiers = getTiers();
print_r($tiers);

echo "\nTesting generateTierOptions() function:\n";
$options = generateTierOptions();
echo $options;

echo "\nTest completed.\n";
?>
