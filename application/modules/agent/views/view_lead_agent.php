
<div class="pc-container">
<div class="pc-content">
<div class="main-card-container">
    <div class="table-container">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of Leads by Date</h6>
                <!-- Button trigger modal for Add User -->
                <div class="d-flex justify-content-end align-items-center">
                    <!-- <button type="button" class="mr-2 btn btn-secondary" data-toggle="modal"
                        data-target="#AssignSalesToLeadgentModal"> Assign</button> -->

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover nowrap display" id="listagent_taskdatatable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lead Gen. Assigned</th>
                                <th>Date Assigned</th>
                                <th>Total Leads</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($agent_tasks > 0): $n = 1; $customer_contact = ""; $customer_email = ""; ?>
                            <?php 
                                // Sort tasks by date in descending order
                                usort($agent_tasks, function($a, $b) {
                                    return strtotime($b['agent_date_assigned']) - strtotime($a['agent_date_assigned']);
                                });
                                ?>

                                    <?php foreach ($agent_tasks as $row): ?>
                                        <tr>
                                            <td><?php echo $n++; ?></td>
                                            <td><?php echo ucwords($row['leadgent_fname'] .' '. $row['leadgent_lname']); ?></td>
                                            <td><?php echo date('Y/m/d h:i:s', strtotime($row['agent_date_assigned'])); ?></td>
                                            <td><?php echo $row['tasks_total']; ?></td>
                                            <td>
                                                <!-- Button to trigger Edit Task Modal -->
                                            <button type="button" class="btn btn-md btn-success view_agent_task" 
                                                data-task_id="<?php echo $row['agent_task_id']; ?>" 
                                                data-user_id="<?php echo $row['user_id']; ?>" 
                                                data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"  
                                                data-toggle="modal" 
                                                data-target="#editlistoftask">View Details
                                            </button> 
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





<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->

                    <div class="form-group col-md-12">
                        <label for="Title">Title</label>
                        <input type="text" class="filter_title form-control" value="0" name="title" />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="assign_to">Assign to</label>
                        <select class="form-control" name="assign_to" required id="assign_to">
                            <option value="" disabled selected>Select a Sales</option>
                            <?php foreach ($leadgent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Priority">Priority</label>
                        <select class="form-control" name="priority" required id="Priority">
                        <option value="" disabled>Select a Priority</option>
                        <option value="Low" selected>Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Remarks">Remarks</label>
                        <textarea class="form-control " rows="3" id="Remarks" name="remarks"></textarea>
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
<!-- tasks modal end -->

<!-- Add Multiple Tasks Modal -->
<div class="modal fade" id="AssignSalesToLeadgentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign Agent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="savemultiplelagentform" method="POST">
                   
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                    <div class="form-group col-md-3">
                        <label for="assign_to">Assign to</label>
                        <select class="form-control" name="assign_to" required id="user_id">
                            <option value="" disabled selected>Select a Sales</option>
                            <?php foreach ($agent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-3">
                        <label for="assign_to">Priority</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="Remarks">Remarks</label>
                        <textarea class="form-control " rows="3" id="remarks" name="remarks"></textarea>
                    </div>
                    </div> -->

                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="agent_taskmodaldatatable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Email Address</th>
                                        <th>Address</th>
                                        <th>Previous Publisher</th>
                                        <th>Title</th>
                                        <!-- <th>Description</th> -->
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        
                                        <th>Lead Status</th>
                                        <!-- <th>Priority</th> -->
                                        <th>Date Created</th>
                                        <th>Select<span id="checkedCountDisplay"> </span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" value="Add" class="btn btn-primary">
            </div>
        </div>

        </form>

    </div>
</div>
</div>
<!-- end add Multiple Tasks Modal-->

<!-- edit  Multiple Tasks Modal -->
<div class="modal fade" id="editlistoftask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Agent Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateagentask_form" class="editagenttask_form">
                   
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                    <!-- <div class="form-group col-md-3">
                        <label for="assign_to">Assign to</label>
                        <select class="form-control assign_to" name="assign_to" required id="user_id" >
                            <option value="" disabled selected>Select a Sales</option>
                            <?php foreach ($agent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" class="task_id" name="task_id" />

                    </div> -->
                    <!-- <div class="form-group col-md-3">
                        <label for="priority">Priority</label>
                        <select class="form-control priority" id="priority" name="priority" >
                           <option value="" disabled selected>Select Priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div> -->
                    <!-- <div class="form-group col-md-3">
                        <label for="Remarks">Remarks</label>
                        <textarea class="form-control remarks" rows="3" id="remarks" name="remarks"></textarea>
                    </div> -->
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="viewtaskagentdataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Email Address</th>
                                        <th>Address</th>
                                        <!-- <th>Previous Publisher</th> -->
                                        <th>Title</th>
                                        <th>Book Link</th>
                                        <!-- <th>Source</th>
                                        <th>Priority</th> -->
                                        <th>Lead Status</th>
                                        <!-- <th>Lead Gen Assigned</th>
                                        <th>Date Assigned</th>
                                        <th>Priority</th>
                                        <th>Services Status</th>
                                        <th>Agent Service Remarks</th> -->
                                        <th>Phone and Email Status</th>
                                        <th>Note</th>


                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

        </form>

    </div>
</div>
</div>
<!-- edit Multiple Tasks Modal end -->

<!-- Edit Tasks Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edittaskform" class="edittaskform ">
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add User Form Fields -->
                    <div class="form-group col-md-12">
                        <label for="Title">Title</label>
                        <input type="text" class="filter_title2 form-control" value="0" name="title" />
                    </div>
                    <div class="form-group col-md-12">
                        <label for="assign_to">Assign to</label>
                        <select class="form-control" name="assign_to" required id="assign_to">
                            <option value="" disabled selected>Select a Sales</option>
                            <?php foreach ($leadgent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Priority">Priority</label>
                        <select class="form-control" name="priority" required id="Priority">
                        <option value="" disabled>Select a Priority</option>
                        <option value="Low" selected>Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="Remarks">Remarks</label>
                        <textarea class="form-control desc" rows="3" id="Remarks" name="remarks"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" value="Save Changes" class="btn btn-primary">
            </div>
            </form>

        </div>
    </div>
</div>
<!-- edit task modal end -->