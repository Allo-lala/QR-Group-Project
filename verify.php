<?php
include './root/config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './root/vendor/autoload.php'; // Autoload PHPMailer via Composer

// Get product ID and auth code from URL query parameters
$productId = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$authCode = isset($_GET['auth_code']) ? $_GET['auth_code'] : ''; // Get the same auth code passed in the link

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Save the auth code and email to the database
    $stmt = $dbh->prepare("INSERT INTO product_verifications (product_id, email, auth_code) VALUES (?, ?, ?)");
    $stmt->execute([$productId, $email, $authCode]);

    // Send the authentication code via PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Enable verbose debug output
        $mail->SMTPDebug = 2; // Set to 0 to disable debug output

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'atugonzabenjaminm@gmail.com'; // Your Gmail address
        $mail->Password = 'mpfj eghf dztp vplq'; // Your newly generated App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use 'tls' for StartTLS
        $mail->Port = 587;

        // Email content
        $mail->setFrom('atugonzabenjaminm@gmail.com', 'LSK ');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Product Authentication Code';
        $mail->Body = "Your authentication code is <strong>$authCode</strong>. <br>Click <a href='https://demo.vlearned.com/verify_code.php?product_id=$productId&email=$email'>here</a> to verify your product.";

        $mail->send();
        $message = "Authentication code has been sent to your email.";
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }
        input[type="email"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verify Product Authenticity</h1>
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="email">Enter your email:</label>
            <input type="email" name="email" required>
            <button type="submit">Send Authentication Code</button>
        </form>
    </div>
</body>
</html>
