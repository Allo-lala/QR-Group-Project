<?php include 'header.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Management</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-user-plus"></i> Add User
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>National ID</th>
                      <th>Role</th>
                      <th>Photo</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $users = $dbh->query("SELECT * FROM users");
                      $count = 1;
                      while ($row = $users->fetch(PDO::FETCH_OBJ)) {
                    ?>
                      <tr>
                        <td><?=$count;?></td>
                        <td><?=$row->username;?></td>
                        <td><?=$row->email;?></td>
                        <td><?=$row->national_id;?></td>
                        <td><?=$row->user_role;?></td>
                        <td><img src="<?=$row->photo;?>" alt="User Photo" class="img-thumbnail" width="100"></td>
                        <td>
                          <!-- Update Button with Icon -->
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#deleteUser<?=$row->id?>">
                            <i class="fas fa-edit"></i>
                          </button>

                          <!-- Delete Button with Icon -->
                          <a href="?deleteUser=<?=$row->id?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                          </a>

                          <!-- View Button with Icon -->
                          <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#editUser<?=$row->id?>">
                            <i class="fas fa-eye"></i>
                          </button>
                        </td>
                      </tr>
                    <?php 
                      $count++;
                      include 'edit-user.php';
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

  <?php if (isset($_REQUEST['deleteUser'])) {
      $id = $_GET['deleteUser'];
      $sql = $dbh->query("DELETE FROM users WHERE id = '$id' ");
      if ($sql) {
        echo "
          <script>
            window.location.href = users;
          </script>
        ";
      }
    }
  ?>
  
  <!-- Add User Modal -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="" enctype="multipart/form-data">
            <!-- id, username, email, national_id, user_role, password, photo, created_at, updated_at -->
            <div class="form-group">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
              <label for="nationalId" class="form-label">National ID</label>
              <input type="text" class="form-control" id="nationalId" name="national_id" placeholder="Enter National ID">
            </div>
            <div class="form-group">
              <label for="userRole" class="form-label">User Role</label>
              <select class="form-control" id="userRole" name="user_role">
                <option value="" disabled selected>Select user role</option>
                <option value="admin">Admin</option>
            
            
               
              </select>
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="register_btn">Save changes</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
<?php include('footer.php'); ?>
