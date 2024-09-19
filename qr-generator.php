<?php
include 'header.php';

// Fetch QR codes from the database
$qrCodesQuery = $dbh->query("SELECT * FROM qr_codes");
$qrCodes = $qrCodesQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">QR Code Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Generate QR Code</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="productSelect">Select Product</label>
                                        <select id="productSelect" class="form-control">
                                            <option value="" disabled selected>Select a product</option>
                                            <?php
                                            $products = $dbh->query("SELECT * FROM products");
                                            while ($row = $products->fetch(PDO::FETCH_OBJ)) { ?>
                                                <option value='<?php echo $row->product_id ?>'><?php echo htmlspecialchars($row->product_name); ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary btn-block" id="generateBtn">
                                            <i class="fas fa-qrcode"></i> Generate QR Code
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Auth Code</th>
                                            <th>QR Code</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($qrCodes as $qrCode) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($qrCode['id']) ?></td>
                                                <td><?= htmlspecialchars($qrCode['product_name']) ?></td>
                                                <td><?= htmlspecialchars($qrCode['auth_code']) ?></td>
                                                <td><img src="<?= htmlspecialchars($qrCode['file_path']) ?>" alt="QR Code" class="img-thumbnail" width="100"></td>
                                                <td>
                                                    <!-- Print Button with Icon -->
                                                    <button type="button" class="btn btn-success btn-sm" onclick="printQRCode('<?= htmlspecialchars($qrCode['file_path']) ?>')">
                                                        <i class="fas fa-print"></i>
                                                    </button>

                                                    <!-- Download Button with Icon -->
                                                    <button type="button" class="btn btn-info btn-sm" onclick="downloadQRCode('<?= htmlspecialchars($qrCode['file_path']) ?>', '<?= urlencode($qrCode['product_name']) ?>')">
                                                        <i class="fas fa-download"></i>
                                                    </button>

                                                    <!-- Delete Button with Icon -->
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteQRCode(<?= htmlspecialchars($qrCode['id']) ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<script>
    try {
        document.getElementById('generateBtn').addEventListener("click", () => {
            const productSelect = document.getElementById('productSelect');
            const productId = productSelect.value;
            const product_name = productSelect.options[productSelect.selectedIndex].text;

            // Generate a random unique authentication code
            const authCode = Math.round(Math.random() * 900000 + 100000);

            if (!productId) {
                alert("Please select a product.");
                return;
            }

            console.log(JSON.stringify({
                product_id: productId,
                product_name: product_name,
                authCode: authCode
            }))

            // Send data to PHP for QR code generation
            fetch('generate-qrcode.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        product_name: product_name,
                        authCode: authCode
                    })
                })
                .then(response => {
                    console.log('Raw response:', response);
                    return response.text(); // Use text() to see the raw response as a string
                })
                .then(data => {
                    console.log('Raw response data:', data); // Log raw data
                    try {
                        const parsedData = JSON.parse(data); // Try parsing if the response is valid JSON
                        console.log(parsedData);
                        if (parsedData.qrImage) {
                            // Insert new row with the newly generated QR code
                            const table = document.getElementById('example2').getElementsByTagName('tbody')[0];
                            const newRow = table.insertRow();
                            newRow.innerHTML = `
                                <td>${parsedData.qrId}</td>
                                <td>${product_name}</td>
                                <td>${authCode}</td>
                                <td>
                                    <img src="${parsedData.qrImage}" alt="QR Code" width="100">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="printQRCode('${data.qrImage}')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" onclick="downloadQRCode('${data.qrImage}', '${encodeURIComponent(product_name)}')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteQRCode('${data.qrId}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            `;
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

        });
    } catch (error) {
        console.log('Error:', error);
    }

    function printQRCode(imgURL) {
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
        printWindow.document.write(`<img src="${imgURL}" width="400">`);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    }

    function downloadQRCode(imgURL, product_name) {
        const a = document.createElement('a');
        a.href = imgURL;
        a.download = `${decodeURIComponent(product_name)}.png`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function deleteQRCode(id) {
        if (confirm('Are you sure you want to delete this QR code?')) {
            fetch('delete-qrcode.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('QR code deleted successfully.');
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        alert('Error deleting QR code.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    }
</script>