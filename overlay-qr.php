<?php
header('Content-Type: image/png');

// QR code image URL
$qrCodeUrl = $_GET['qr_code_url'];
$overlayImagePath = __DIR__ . '/logo.png'; // Path to the overlay image

// Load the QR code image
$qrCodeImage = @imagecreatefrompng($qrCodeUrl);
if (!$qrCodeImage) {
    die('Error loading QR code image.');
}

// Load the overlay image
$overlayImage = @imagecreatefrompng($overlayImagePath);
if (!$overlayImage) {
    die('Error loading overlay image.');
}

// Get dimensions
$qrWidth = imagesx($qrCodeImage);
$qrHeight = imagesy($qrCodeImage);
$overlayWidth = imagesx($overlayImage);
$overlayHeight = imagesy($overlayImage);

// Resize the overlay image (optional - to make it smaller)
$scaleFactor = 0.5; // Change this to resize the overlay (e.g., 0.5 = 50% size)
$newOverlayWidth = $overlayWidth * $scaleFactor;
$newOverlayHeight = $overlayHeight * $scaleFactor;

// Create a new true color image for the resized overlay
$resizedOverlay = imagecreatetruecolor($newOverlayWidth, $newOverlayHeight);
imagealphablending($resizedOverlay, false);
imagesavealpha($resizedOverlay, true);

// Apply transparency and resize the overlay
$transparent = imagecolorallocatealpha($resizedOverlay, 0, 0, 0, 127);
imagefill($resizedOverlay, 0, 0, $transparent);
imagecopyresampled($resizedOverlay, $overlayImage, 0, 0, 0, 0, $newOverlayWidth, $newOverlayHeight, $overlayWidth, $overlayHeight);

// Calculate overlay position at the bottom, centered horizontally
$overlayX = ($qrWidth - $newOverlayWidth) / 2; // Centered horizontally
$overlayY = $qrHeight - $newOverlayHeight; // Positioned at the bottom

// Merge resized overlay onto the bottom of the QR code image
imagecopy($qrCodeImage, $resizedOverlay, $overlayX, $overlayY, 0, 0, $newOverlayWidth, $newOverlayHeight);

// Output final image
imagepng($qrCodeImage);

// Free up memory
imagedestroy($qrCodeImage);
imagedestroy($overlayImage);
imagedestroy($resizedOverlay);
?>
