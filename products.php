<?php include('header.php'); ?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
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
              <h3 class="card-title">Product Management</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                  <i class="fas fa-plus"></i> Add Product
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                
                    <th>Batch Number</th>
                    <th>Production Date</th>
                    <th>Production Type</th>
                    <th>Round</th>
                    <th>Hardness</th>
                    <th>Oven setting</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $products = $dbh->query("SELECT * FROM products");
                  $count = 1;
                  while ($row = $products->fetch(PDO::FETCH_OBJ)) {
                  ?>
                    <tr>
                      <td><?= $count; ?></td>
                      <td><?= $row->product_id ?></td>
                      <td><?= $row->product_name ?></td>
                    
                      <td><?= $row->batch_number ?></td>
                      <td><?= $row->production_date ?></td>
                      <td><?= $row->product_type ?></td>
                      <td><?= $row->route ?></td>
                      <td><?= $row->hardness ?></td>
                      <td><?= $row->oven_setting ?></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProduct<?= $row->id ?>">
                          <i class="fas fa-edit"></i>
                        </button>
                        <a href="?deleteProduct=<?= $row->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                          <i class="fas fa-trash"></i>
                        </a>
                        <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#viewProduct<?= $row->id ?>">
                          <i class="fas fa-eye"></i>
                        </button>
                      </td>
                    </tr>
                  <?php
                    $count++;
                    include 'edit-product.php';
                    include 'view-product.php';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<?php if (isset($_REQUEST['deleteProduct'])) {
  $id = $_GET['deleteProduct'];
  $sql = $dbh->query("DELETE FROM products WHERE id = '$id' ");
  if ($sql) {
    echo "
          <script>
            window.location.href = 'products';
          </script>
        ";
  }
}
?>

<!-- Add Product Modal -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" placeholder="Enter product name">
          </div>
          <div class="form-group">
            <label class="form-label">Product ID</label>
            <input type="text" class="form-control" id="productid" name="product_id" readonly>
            <h2 id="showId"></h2>
          </div>
          <div class="form-group">
            <label for="batchNumber" class="form-label">Batch Number</label>
            <input type="text" class="form-control" id="batchNumber" name="batch_number" placeholder="Enter batch number">
          </div>
          <div class="form-group">
            <label for="productionDate" class="form-label">Production Date</label>
            <input type="date" class="form-control" id="productionDate" name="production_date">
          </div>
        
         
          <div class="form-group">
            <label for="productionDate" class="form-label">Round</label>
            <select class="form-control" name="route">
              <option>SELECT ROUND</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
           
            
            </select>
          </div>



          <div class="form-group">
            <label for="productionDate" class="form-label">Haerdness</label>
            <select class="form-control" name="hardness">
              <option>SELECT HARDNESS TYPE</option>
              <option value="PSO">PSO</option>
              <option value="XSO">XSO</option>
              <option value="SOO">SOO</option>
              <option value="ME">ME</option>
              <option value="FM">FM</option>
              <option value="XFM">XFM</option>
              <option value="DX < UD">DX < UD</option>
              <option value="UUD">UUD</option>
            
            </select>
          </div>



          <div class="form-group">
            <label for="productionDate" class="form-label">Product type</label>
            <select class="form-control" name="product_type">
              <option>---select type---</option>
              <option value="Latex">Latex</option>
              <option value="Matress">Matress</option>
            </select>
          </div>
          <div class="form-group">
            <label for="productionDate" class="form-label">Oven setting</label>
            <select class="form-control" name="oven_setting">
              <option>Choose Oven Setting</option>
              <option value="1a to 16a">1a to 16a</option>
              <option value="1b to 16b">1b to 16b</option>
           
            </select>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="add_product_btn" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
  // Generate Product ID
  function generateId() {
    function getRandomLetters(length) {
      let result = '';
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      return result;
    }

    const randomString = getRandomLetters(3);
    const randomNumber = Math.floor(Math.random() * 1000);
    // const productId = document.getElementById('productId');
    // productId.value = randomString + randomNumber;
    document.getElementById('productid').value = 'LSK'+ randomNumber;
    // document.getElementById('showId').innerHTML = randomString + randomNumber;

    console.log("Generated Product ID:", productId.value); // Log the generated ID
  }

  generateId()
</script>

<?php include('footer.php'); ?>