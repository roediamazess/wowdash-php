<?php
// Test script to verify that the tier functions work correctly

// Include the tier functions
include_once __DIR__ . '/wowdash-php/partials/get_tiers.php';

// Test the getTiers function
echo "Testing getTiers() function:\n";
$tiers = getTiers();
print_r($tiers);

// Test the generateTierOptions function
echo "\nTesting generateTierOptions() function:\n";
echo generateTierOptions();
?>
