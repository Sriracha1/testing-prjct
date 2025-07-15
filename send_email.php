<?php
// Get form data
$guestName = $_POST['guestName'] ?? '';
$attendance = $_POST['attendance'] ?? '';
$guestCount = $_POST['guestCount'] ?? '';

// Create an array to store new data
$newEntry = [
    'name' => $guestName,
    'attendance' => $attendance,
    'guestCount' => $guestCount,
    'submittedAt' => date('Y-m-d H:i:s')
];

// File to store the responses
$file = 'responses.json';

// Read existing data
if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $data = json_decode($jsonData, true);
} else {
    $data = [];
}

// Add new entry
$data[] = $newEntry;

// Save back to file
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

// Redirect or confirm submission
header('Location: thank-you.html'); // optional redirect
exit;
?>