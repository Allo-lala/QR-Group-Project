<!-- View product -->
<div class="modal fade" id="editProduct<?= $row->id ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form actio="" method="post">
          <div class="form-group">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" value="<?= $row->product_name ?>">
            <input type="hidden" class="form-control" id="productName" name="id" value="<?= $row->id ?>">
          </div>
          <div class="form-group">
            <label for="productId" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="productId" name="product_id" value="<?= $row->product_id ?>">
          </div>
          <div class="form-group">
            <label for="batchNumber" class="form-label">Batch Number</label>
            <input type="text" class="form-control" id="batchNumber" name="batch_number" value="<?= $row->batch_number ?>">
          </div>
          <div class="form-group">
            <label for="productionDate" class="form-label">Production Date</label>
            <input type="date" class="form-control" id="productionDate" name="production_date" value="<?= $row->production_date ?>">
          </div>
          <div class="form-group">
            <label for="productionDate" class="form-label">Hardness</label>
            <input type="text" class="form-control" name="hardness" value="<?= $row->hardness ?>">
          </div>
          <div class="form-group">
            <label for="productionDate" class="form-label">Route</label>
            <input type="text" class="form-control" name="route" value="<?= $row->route ?>">
          </div>
          <div class="form-group">
            <label for="productType" class="form-label">Product Type</label>
            <select class="form-control" name="product_type" id="productType">
              <option value="Latex" <?php if ($row->product_type == 'Latex') echo 'selected'; ?>>Latex</option>
              <option value="Matress" <?php if ($row->product_type == 'Matress') echo 'selected'; ?>>Matress</option>
            </select>
          </div>
          <div class="form-group">
            <label for="ovenSetting" class="form-label">Oven Setting</label>
            <select class="form-control" name="oven_setting" id="ovenSetting">
              <option value="">---select level---</option>
              <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="<?= $i ?>" <?php if ($row->oven_setting == $i) echo 'selected'; ?>><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="edit_product_btn" class="btn btn-primary">Edit</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- View product -->