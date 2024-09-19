<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include './root/config.php'; // Ensure this contains your PDO database connection
include './root/phpqrcode/qrlib.php'; // Ensure the QR code library is included

// Ensure the QR codes directory exists
$qrDir = 'qrcodes/';
if (!file_exists($qrDir)) {
    mkdir($qrDir, 0775, true);
}

// Get product details from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$productId = isset($data['product_id']) ? $data['product_id'] : '';
$authCode = isset($data['authCode']) ? $data['authCode'] : '';
$product_name = isset($data['product_name']) ? $data['product_name'] : 'Sample Product';

if (empty($productId) || empty($authCode)) {
    die(json_encode(['error' => 'Missing product ID or authentication code.']));
}

// Check if a QR code already exists for this product_id
$stmt = $dbh->prepare("SELECT file_path FROM qr_codes WHERE product_id = ?");
$stmt->execute([$productId]);
$existingQRCode = $stmt->fetchColumn();

if ($existingQRCode) {
    // Return the existing QR code path
    echo json_encode(['qrImage' => $existingQRCode]);
    exit;
}

// Prepare the URL for the QR code (link to the verification page)
$verificationURL = "https://auth.lskmy.com/verify?product_name=" . urlencode($product_name) . "&auth_code=" . urlencode($authCode);

// QR Code configurations
$eccLevel = QR_ECLEVEL_H; // ECC level: H (High) for maximum error correction
$zoomFactor = 10; // Increased zoom factor for larger QR code
$qrFilePath = $qrDir . uniqid() . '.png'; // Generate unique file name for the QR code image

// Content for the QR code
$qrContent = $verificationURL; // Only include the URL for scanning efficiency

// Generate the QR code with the content
QRcode::png($qrContent, $qrFilePath, $eccLevel, $zoomFactor);

if (!file_exists($qrFilePath)) {
    die(json_encode(['error' => 'Failed to generate QR code.']));
}

// Add a logo to the QR code
$logoPath = './root/images/logoz.png';
$QR = imagecreatefrompng($qrFilePath);
if ($QR === false) {
    die(json_encode(['error' => 'Failed to load QR code image.']));
}

$logo = imagecreatefrompng($logoPath);
if ($logo === false) {
    die(json_encode(['error' => 'Failed to load logo image.']));
}

$QR_width = imagesx($QR);
$QR_height = imagesy($QR);
$logo_width = imagesx($logo);
$logo_height = imagesy($logo);

// Scale logo to fit in the QR Code
$logo_qr_width = $QR_width / 5; // Adjusted for better readability
$scale = $logo_width / $logo_qr_width;
$logo_qr_height = $logo_height / $scale;

// Calculate the position to place the logo (centered)
$logo_x = ($QR_width - $logo_qr_width) / 2;
$logo_y = ($QR_height - $logo_qr_height) / 2;

// Merge the logo onto the QR code image
imagecopyresampled($QR, $logo, $logo_x, $logo_y, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

// Save QR code again, but with the logo
imagepng($QR, $qrFilePath);
imagedestroy($QR);
imagedestroy($logo);

// Add text below the QR code: Product Name and "AUTHENTIC"
$fontPath = './root/fonts/Arial.ttf'; // Path to your TTF font file
$image = imagecreatefrompng($qrFilePath);
$imageWidth = imagesx($image);
$imageHeight = imagesy($image);

// Create a new image with additional space for text
$padding = 30; // Increased padding
$fontSize = 70; // Increased font size
$newHeight = $imageHeight + $padding + $fontSize * 2 + 60; // Extra space for text and padding
$frameWidth = $imageWidth + 40; // Increased padding around the image
$frameImage = imagecreatetruecolor($frameWidth, $newHeight);
$backgroundColor = imagecolorallocate($frameImage, 255, 255, 255); // White background
imagefill($frameImage, 0, 0, $backgroundColor);

// Copy the QR code image onto the new image
imagecopy($frameImage, $image, 20, 20, 0, 0, $imageWidth, $imageHeight);

// Set text color to black
$textColor = imagecolorallocate($frameImage, 0, 0, 0);

// Text to be added below the QR code
$text1 = $product_name; // Display product name

// Function to wrap text into multiple lines if too long
function wrapText($fontSize, $angle, $fontPath, $text, $maxWidth) {
    $words = explode(' ', $text);
    $wrappedText = '';
    $line = '';

    foreach ($words as $word) {
        $testLine = $line . $word . ' ';
        $bbox = imagettfbbox($fontSize, $angle, $fontPath, $testLine);
        $testWidth = $bbox[2] - $bbox[0];

        if ($testWidth > $maxWidth) {
            $wrappedText .= trim($line) . "\n";
            $line = $word . ' ';
        } else {
            $line = $testLine;
        }
    }
    return $wrappedText . trim($line);
}

// Use the wrapText function to split product name into multiple lines
$wrappedText = wrapText($fontSize, 0, $fontPath, $text1, $frameWidth - 60); // 60px padding

// Split the wrapped text into lines
$lines = explode("\n", $wrappedText);
$lineHeight = $fontSize + 10; // Add some space between lines

// Calculate the starting Y position for the text (centered)
$textY = $imageHeight + $padding + $fontSize;

// Add each line of the wrapped text below the QR code
foreach ($lines as $line) {
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $line);
    $textWidth = $bbox[2] - $bbox[0];
    $textX = ($frameWidth - $textWidth) / 2;
    imagettftext($frameImage, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $line);
    $textY += $lineHeight;
}

// Save the final image with the text and QR code
imagepng($frameImage, $qrFilePath);
imagedestroy($image);
imagedestroy($frameImage);

// Save the QR code details to the database
$stmt = $dbh->prepare("INSERT INTO qr_codes (product_id, product_name, auth_code, file_path) VALUES (?, ?, ?, ?)");
$stmt->execute([$productId, $product_name, $authCode, $qrFilePath]);

// Return the file path to the frontend
echo json_encode(['qrImage' => $qrFilePath]);

?>
