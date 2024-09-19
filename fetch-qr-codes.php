<?php
include 'config.php'; // Make sure this includes your database connection

// Fetch QR codes from the database
$stmt = $pdo->query("SELECT * FROM qr_codes");
$qrCodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return QR codes data as JSON
echo json_encode($qrCodes);
?>
