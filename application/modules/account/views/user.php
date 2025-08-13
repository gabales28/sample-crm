<div class="pc-container">
<div class="pc-content">
<div class="main-card-container">
        <div class="table-container">
            <div class="card shadow mb-4">
               
                <div class="card-header py-3" style="display: flex; align-items: center; justify-content: space-between;">
                    <h6 class="m-0 font-weight-bold text-primary">List of Users</h6>
                    <!-- Button trigger modal for Add User -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                        Add User
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="userdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>RC Number</th>
                                    <th>Email Address</th>
                                    <th>Address</th>
                                    <th>Usertype</th>
                                    <th>Sales Quota</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($all_users > 0): $n = 1; ?>
                                    <?php foreach ($all_users as $row): ?>
                                        <tr>
                                            <td><?php echo $n++; ?></td>
                                            <td><?php echo ucwords($row['fname'] .' '. $row['lname']); ?></td>
                                            <td><?php echo $row['contact']; ?></td>
                                            <td><?php echo $row['phonenumber']; ?></td>
                                            <td><?php echo $row['email_add']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['usertype']; ?></td>
                                            <td><?php echo $row['quota']; ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td>
                                                <!-- Button to trigger Edit User Modal -->
                                                <button type="button" class="btn btn-md btn-danger edit_user" data-user_id="<?php echo $row['user_id']; ?>" data-toggle="modal" data-target="#editUserModal">Edit</button>
                                                <button type="button" class="btn btn-md btn-primary auto-login-btn" data-email_add="<?php echo $row['email_add']; ?>" data-usertype="<?php echo $row['usertype']; ?>" data-user_id="<?php echo $row['user_id']; ?>">Login</button>

                                            </td>
                                        </tr>   
                                    <?php endforeach; ?>
                                <?php endif; ?>   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>      
    </div> 
    </div>      
    </div>
    
    
             
