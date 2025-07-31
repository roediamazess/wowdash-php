<?php
// Test script for get_tiers.php

// Include tier data functions
include_once './partials/get_tiers.php';

echo "Testing getTiers() function:\n";
$tiers = getTiers();
print_r($tiers);

echo "\nTesting generateTierOptions() function:\n";
echo generateTierOptions();
?>
