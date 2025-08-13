<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">
                                                 
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Leads</h6>
                        <!-- Button trigger modal for Add User -->
                        <!-- <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="mr-2 btn btn-primary" data-toggle="modal"
                                data-target="#AssignSalesToLeadgentModal"> Assign</button>
                                                                                                                                                                        
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="listagent_taskdatatable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Assign to</th>
                                        <!-- <th>Date Assigned</th> -->
                                        <th>Total Leads</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($agent_tasks > 0): $n = 1;
                                        $customer_contact = "";
                                        $customer_email = ""; ?>
                                        
                                        <?php foreach ($agent_tasks as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['fname'] . ' ' . $row['lname']); ?></td>
                                                <!-- <td><?php echo date('Y/m/d h:i:s', strtotime($row['agent_date_assigned'])); ?></td> -->
                                                <td><?php echo $row['tasks_total']; ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                                                    <button type="button" class="btn btn-md btn-success view_agent_task"
                                                        data-task_id="<?php echo $row['agent_task_id']; ?>"
                                                        data-user_id="<?php echo $row['user_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"
                                                        data-toggle="modal"
                                                        data-target="#view_editlistoftask">View
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
<div class="modal fade" id="view_editlistoftask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Agent's Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateagentask_form" class="view_editagenttask_form">

                    <div class="alert alert-success">
                        <p></p>
                    </div>

                    <div class="row">
                        <!-- <div class="form-group col-md-3">
                            <label for="assign_to">Assign to</label>
                            <select class="form-control assign_to" name="assign_to" required id="user_id">
                                <option value="" disabled selected>Select a Sales</option>
                                <?php foreach ($agent_users as $key => $user): ?>
                                    <option value="<?= $user['user_id']; ?>">
                                        <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" class="task_id" name="task_id" />
                            <input type="hidden" class="existing_user_id" name="existing_user_id" />


                        </div> -->
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                <div class="ShowEntries">
                                    <label for="entries">Show entries:</label>
                                    <input type="number" id="entries_7" value="10" min="1" step="1" style="width: 60px;">
                                </div>
                                <div class="SearchBox">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search_view_leadgent" placeholder="Search...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="view_editaskagentdataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Customer Email</th>
                                        <th>Address</th>
                                        <th>Previous Publisher</th>
                                        <th>Title</th>
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Assigned Agent</th>
                                        <th>Lead Status</th>
                                        <th>Agent Priority</th>
                                        <th>Service Status</th>
                                        <th>Agent Remarks</th>
                                        <th>Sales Remarks</th>
                                        <th>Agent Date Assigned</th>
                                        <th>Remarks</th>
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
            </div>
        </div>

        </form>

    </div>
</div>
</div>