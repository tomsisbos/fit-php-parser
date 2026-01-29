<?php
require 'vendor/autoload.php';

// Test to understand compressed timestamp format
$file = '/var/www/html/tests/Fixtures/FIT/short_activity.fit';
$contents = file_get_contents($file);

// Skip header (14 bytes)
$pos = 14;

echo "First 10 record headers:\n";
for ($i = 0; $i < 10 && $pos < strlen($contents); $i++) {
    $header = ord($contents[$pos]);
    $binary = sprintf('%08b', $header);
    
    $isCompressed = ($header & 0x80) === 0x80;
    $isDefinition = ($header & 0x40) === 0x40;    
    printf("Byte %d: 0x%02X (%s) - ", $pos, $header, $binary);
    
    if ($isCompressed) {
        $localMsg3bit = ($header >> 5) & 0x07;  // 3 bits
        $localMsg2bit = ($header >> 5) & 0x03;  // 2 bits
        $timeOffset = $header & 0x1F;
        echo "COMPRESSED - LocalMsg(3bit)=$localMsg3bit, LocalMsg(2bit)=$localMsg2bit, TimeOffset=$timeOffset\n";
    } elseif ($isDefinition) {
        echo "DEFINITION\n";
    } else {
        $localMsg = $header & 0x0F;
        echo "DATA - LocalMsg=$localMsg\n";
    }
    
    $pos++;
    // Skip ahead a bit to find next header (rough approximation)
    $pos += 10;
}
