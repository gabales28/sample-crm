<div class="main-card-container">
        <div class="table-container">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Activity</h6>
                    <!-- Button trigger modal for Add User -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ActivityModal">
                        Add Activity
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="userdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Created</th>
                                    <th>Title</th>
                                    <th>Labels</th>
                                    <th>Value</th>
                                    <th>Customer</th>
                                    <th>Organization</th>
                                    <th>Contact Person</th>
                                    <th>Owner</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tabledeals > 0): $n = 1; ?>
                                    <?php foreach ($tabledeals as $row): ?>
                                        <tr>
                                            <td><?php echo $n++; ?></td>
                                            <td><?php echo $row['created']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['labels']; ?></td>
                                            <td><?php echo $row['value']; ?></td>
                                            <td><?php echo $row['customer']; ?></td>
                                            <td><?php echo $row['organization']; ?></td>
                                            <td><?php echo $row['contact_person']; ?></td>
                                            <td><?php echo $row['owner']; ?></td>
                                            <td>
                                                <!-- Button to trigger Edit User Modal -->
                                                <button type="button" class="btn btn-md btn-danger edit_leads" data-user_id="<?php echo $row['lead_id']; ?>" data-toggle="modal" data-target="#editLeadsModal">Edit</button>
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

    <!-- Add Task Modal -->
 <div class="modal fade" id="ActivityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="addtaskform" method="POST">
                                <div class="alert alert-success"><p></p></div> 
                                    <!-- Add User Form Fields -->
                                    <div class="form-group col-md-12">
                                                <label for="Title">Title</label>
                                                    <select class="form-control" name="title" required id="Title">
                                                        <option value="" disabled selected>Select Title</option>
                                                        <?php foreach ($leads as $key => $lead):?>
                                                           <option value="<?=$lead['lead_id'];?>"><?php echo ucwords($lead['title']);?></option>
                                                           <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                <label for="assign_to">Assign to</label>
                                                    <select class="form-control" name="assign_to" required id="assign_to">
                                                        <option value="" disabled selected>Select a Sales</option>
                                                        <?php foreach ($leadgent_users as $key => $user):?>
                                                           <option value="<?=$user['user_id'];?>"><?php echo ucwords($user['fname'].' '.$user['lname']);?></option>
                                                           <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="Priority">Priority</label>
                                                    <select class="form-control" name="priority" required id="Priority">
                                                        <option value="" disabled selected>Select a Status</option>
                                                        <option value="Low">Low</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="Remarks">Remarks</label>
                                                    <textarea class="form-control desc" rows="3" id="Remarks"  name="remarks"></textarea>
                                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" value="Add" class="btn btn-primary">
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
