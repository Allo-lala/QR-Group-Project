<?php
include './root/config.php';

$productId = isset($_GET['product_id']) ? htmlspecialchars($_GET['product_id']) : '';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authCode = trim($_POST['auth_code']); // Sanitize input

    // Prepare the SQL query to check the auth code
    $stmt = $dbh->prepare("SELECT * FROM product_verifications WHERE product_id = ? AND email = ? AND auth_code = ?");
    $stmt->execute([$productId, $email, $authCode]);

    if ($stmt->rowCount() > 0) {
        // Auth code is valid, redirect to product details
        header("Location: product_details.php?product_id=" . urlencode($productId));
        exit();
    } else {
        $error = "Invalid authentication code. Please try again.";
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
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #1f3f85; /* Blue color */
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-size: 1.1em;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
            font-size: 1em;
            margin-bottom: 20px;
        }
        button {
            background-color: #1f3f85; /* Blue color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        button:hover {
            background-color: #1d3a78;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Authentication Code</h1>
        <form method="POST">
            <label for="auth_code">Enter the code you received:</label>
            <input type="text" name="auth_code" required>
            <button type="submit">Verify</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
