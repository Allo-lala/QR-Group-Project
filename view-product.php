<!-- View product -->
  <div class="modal fade" id="viewProduct<?=$row->id?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View Product</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div>
            <div>
                <h3>Product name: <span class="text-primary"><?=$row->product_name?></span></h3>
                <h5>Product ID: <span class="text-primary"><?=$row->product_id?></span></h5>
                <h5>Batch number: <span class="text-primary"><?=$row->batch_number?></span></h5>
                <h5>Product date: <span class="text-primary"><?=$row->production_date?></span></h5>
                <h5>Created at: <span class="text-primary"><?=$row->created_at?></span></h5>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!-- <button type="submit" name="add_product_btn" class="btn btn-primary">Added</button> -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- View product -->