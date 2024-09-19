<div class="modal fade" id="deleteUser<?= $row->id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" enctype="multipart/form-data" class="p-2">
                    <!-- id, username, email, national_id, user_role, password, photo, created_at, updated_at -->
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $row->username; ?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $row->id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $row->email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nationalId" class="form-label">National ID</label>
                        <input type="text" class="form-control" id="nationalId" name="national_id" value="<?= $row->national_id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="userRole" class="form-label">User Role</label>
                        <select class="form-control" id="userRole" name="user_role">
                            <option value="<?= $row->user_role; ?>"><?= $row->user_role; ?></option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="guest">Guest</option>

                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?= $row->password; ?>">
                    </div> -->
                    <div class="form-group">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <input type="hidden" class="form-control" id="photo" name="oldphoto" value="<?=$row->photo?>">
                        <img src="<?=$row->photo;?>" alt="User Photo" class="img-thumbnail" width="100">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="edit_user_btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>