<?php
include './root/config.php';

$productId = isset($_GET['product_id']) ? $_GET['product_id'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authCode = $_POST['auth_code'];

    // Check if the provided auth code matches the one in the database
    $stmt = $dbh->prepare("SELECT * FROM product_verifications WHERE product_id = ? AND email = ? AND auth_code = ?");
    $stmt->execute([$productId, $email, $authCode]);

    if ($stmt->rowCount() > 0) {
        // Auth code is valid, display the product details
        header("Location: product_details.php?product_id=$productId");
        exit(); // Ensure no further code is executed after redirect
    } else {
        $message = "Invalid authentication code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate Product</title>
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
            text-align: center;
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
        input[type="text"] {
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
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Authentication Code</h1>
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="auth_code">Enter the code you received:</label>
            <input type="text" name="auth_code" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
