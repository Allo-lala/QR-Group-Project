<?php
include './root/config.php';

$productId = isset($_GET['product_id']) ? $_GET['product_id'] : '';

$stmt = $dbh->prepare("SELECT * FROM product_verifications WHERE product_id = ?");
$stmt->execute([$productId]);

$product = $stmt->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }
        .authentic {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }
        .not-found {
            font-size: 18px;
            color: #dc3545;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($product): ?>
            <h1>Product Details</h1>
            <p><strong>AuthCode:</strong> <span class="highlight"><?php echo htmlspecialchars($product->auth_code); ?></span></p>
            <p><strong>Your Email:</strong> <?php echo htmlspecialchars($product->email); ?></p>
            <p><strong>Production Date:</strong> <?php echo htmlspecialchars($product->production_date); ?></p>
            <p class="authentic">Status: AUTHENTIC</p>
        <?php else: ?>
            <p class="not-found">Product not found or invalid product ID.</p>
        <?php endif; ?>
    </div>
</body>
</html>
