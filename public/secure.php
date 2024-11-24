<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    http_response_code(403); // Forbidden
    echo "Unauthorized access!";
    exit;
}

$file = $_GET['file'] ?? '';

// Define valid files for security purposes
$validFiles = ['output.m3u8', 'output0.ts', 'output1.ts', 'output2.ts', 'output3.ts'];

if (in_array($file, $validFiles)) {
    // Going up one directory level to access the 'videos' folder
    $filePath = __DIR__ . '/../videos/' . $file;

    if (file_exists($filePath)) {
        // Determine the correct content type for the file
        if (strpos($file, '.m3u8') !== false) {
            header('Content-Type: application/vnd.apple.mpegurl');
        } elseif (strpos($file, '.ts') !== false) {
            header('Content-Type: video/mp2t');
        }

        // Output the file content
        readfile($filePath);
    } else {
        http_response_code(404); // Not Found
        echo "File not found!";
    }
} else {
    http_response_code(403); // Forbidden
    echo "Forbidden access to the requested file!";
}
?>
