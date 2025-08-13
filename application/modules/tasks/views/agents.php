
<div class="pc-container">
<div class="pc-content">
<div class="main-card-container">
    <div class="table-container">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of agents</h6>
                <!-- Button trigger modal for Add User -->
                <div class="d-flex justify-content-end align-items-center">
                    <!-- <button type="button" class="mr-2 " data-toggle="modal"
                        data-target="#addmultipleleadgentsTaskModal"> Assign </button> -->
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addleadgentTaskModal">Add
                        single</button> -->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover nowrap display" id="leadgent_taskdatatable" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lead Gen. Distributor</th>
                                <th>Assigned Agent</th>
                                <th>Date Assigned</th>
                                <th>Total Tasks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($tableagents > 0): $n = 1; $customer_contact = ""; $customer_email = ""; ?>
                                <?php 
                                // Sort tasks by date in descending order
                                usort($tableagents, function($a, $b) {
                                    return strtotime($b['agent_date_assigned']) - strtotime($a['agent_date_assigned']);
                                });
                                ?>
                                    <?php foreach ($tableagents as $row): ?>
                                        <tr>
                                            <td><?php echo $n++; ?></td>
                                            <td><?php echo ucwords($row['leadgent_fname'] .' '. $row['leadgent_lname']); ?></td>
                                            <td><?php echo ucwords($row['fname'] .' '. $row['lname']); ?></td>
                                            <td><?php echo date('Y/m/d h:i:s', strtotime($row['agent_date_assigned'])); ?></td>
                                            <td><?php echo $row['tasks_total']; ?></td>
                                            <td>
                                                <!-- Button to trigger Edit Task Modal -->
                                            <button type="button" class="btn btn-md btn-success view_task" 
                                                data-task_id="<?php echo $row['agent_task_id']; ?>" 
                                                data-user_id="<?php echo $row['user_id']; ?>" 
                                                data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"  
                                                data-toggle="modal" 
                                                data-target="#editlistoftask">View details
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




<!-- edit  Multiple Tasks Modal -->
<div class="modal fade" id="editlistoftask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_leadgent_task_form" class="editleadgenttask_form">
                   
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                    <!-- <div class="form-group col-md-3"> -->
                        
                        <!-- <label for="assign_to">Assigned</label> -->
                        <!-- <input class="form-control"  readonly > -->
                            <!-- <?php foreach ($leadgent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?> -->
                            <!-- </input> -->
                        <!-- <input type="hidden" class="leadgent_task_id" name="leadgent_task_id" />

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
                            <table class="table table-bordered table-hover nowrap display" id="viewtaskdataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Contact #</th>
                                        <th>Contact Email</th>
                                        <th>Address</th>
                                        <th>Previous Publisher</th>
                                        <th>Title</th>
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Lead Gen. Destributor</th>
                                        <th>Assigned Agent</th>
                                        <th>Lead Status</th>
                                        <th>Agent Priority</th>
                                        
                                        <th>Date Assigned</th>
                                        <th>Sales Remarks</th>
                                        <th>Note</th>

                                        <!-- <th>Remarks</th> -->
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
                <!-- <input type="submit" value="Save changes" id="editlistoftask" class="btn btn-primary"> -->
            </div>
        </div>

        </form>

    </div>
</div>
</div>
<!-- edit Multiple Tasks Modal end -->
