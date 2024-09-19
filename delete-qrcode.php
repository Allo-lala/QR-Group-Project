<?php
// Connect to the database
include './root/config.php';

// Decode the received JSON data
$data = json_decode(file_get_contents('php://input'), true);

$qrId = $data['id'];

// Fetch the file path of the QR code to delete
$sql = "SELECT file_path FROM qr_codes WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->execute([':id' => $qrId]);
$qrCode = $stmt->fetch(PDO::FETCH_ASSOC);

if ($qrCode) {
    // Delete the QR code image file from the server
    if (file_exists($qrCode['file_path'])) {
        unlink($qrCode['file_path']);
    }

    // Delete the QR code record from the database
    $sql = "DELETE FROM qr_codes WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $success = $stmt->execute([':id' => $qrId]);

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
?>
