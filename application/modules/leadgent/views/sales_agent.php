<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Agents Assigned Task</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="mr-2 btn btn-primary" data-toggle="modal"
                                data-target="#AssignSalesToLeadgentModal"> Assign</button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="listagent_taskdatatable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Assigned Agent</th>
                                        <th>Date Assigned</th>
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
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['agent_date_assigned'])); ?></td>
                                                <td><?php echo $row['tasks_total']; ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                                                    <!-- <button type="button" class="btn btn-md btn-danger edit_agent_task"
                                                        data-task_id="<?php echo $row['agent_task_id']; ?>"
                                                        data-user_id="<?php echo $row['user_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"
                                                        data-toggle="modal"
                                                        data-target="#editlistoftask">Edit
                                                    </button> -->

                                                    <button type="button" class="btn btn-md btn-danger return_lead_control"
                                                        data-task_id="<?php echo $row['agent_task_id']; ?>"
                                                        data-user_id="<?php echo $row['user_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"
                                                        data-toggle="modal"
                                                        data-target="#return-lead-control">Return to Lead Control
                                                    </button>

                                                    <button type="button" class="btn btn-md btn-info recycle"
                                                        data-task_id="<?php echo $row['agent_task_id']; ?>"
                                                        data-user_id="<?php echo $row['user_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['agent_date_assigned'])); ?>"
                                                        data-leadgent_user_id="<?php echo $row['leadgent_user_id']; ?>""
                                                        data-toggle="modal"
                                                        data-target="#recycle">Recycle
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

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between">
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
                        <div class="form-group col-md-3">
                            <label for="assign_to">Leads Status</label>
                            <select id="leadgent_assign_statusfilter" class="form-control leadgent_assign_statusfilter">
                                <option value="Active Lead">Active Lead</option>
                                <option value="Inactive Lead">Inactive Lead</option>
                                <option value="Active Email">Active Email</option>
                                <option value="Confirmed Leads">Confirmed Leads</option>
                                <option value="Need to Confirm">Need to Confirm</option>
                                <option value="Mined Leads">Mined Leads</option>
                                <option value="Voice Mail Leads">Voice Mail Leads</option>
                                <option value="Distributed Leads">Distributed Leads</option>
                                <option value="Disconnected">Disconnected</option>
                                <option value="Wrong Email and Phone">Wrong Email and Phone</option>
                                <option value="Special Leads">Special Leads</option>
                                <option value="Deceased">Deceased</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                    <div class="ShowEntries">
                                        <label for="entries">Show entries:</label>
                                        <input type="number" id="entries_4" value="10" min="1" step="1" style="width: 60px;">
                                    </div>
                                    <div class="SearchBox">
                                        <label for="search">Search:</label>
                                        <input type="text" id="search" placeholder="Search...">
                                    </div>
                                </div>
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
                                            <th>Book Link</th>
                                            <th>Source</th>      

                                            <th>Lead Status</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Agent Tasks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateagentask_form" class="editagenttask_form">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="form-group col-md-3">
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


                        </div>
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
                            <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                <div class="ShowEntries">
                                    <label for="entries">Show entries:</label>
                                    <input type="number" id="entries_5" value="10" min="1" step="1" style="width: 60px;">
                                </div>
                                <div class="SearchBox">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search" placeholder="Search...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="editaskagentdataTable"
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
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Priority</th>
                                        <th>Lead Status</th>
                                        <th>Date Assigned</th>
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
                <input type="submit" value="Save changes" class="btn btn-primary">
            </div>
        </div>

        </form>

    </div>
</div>
</div>
<!-- edit Multiple Tasks Modal end -->

<div class="modal fade" id="recycle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recycle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save_recycle_lead_form" class="recycle_form">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <!-- <label for="assign_to">Assign to</label>
                            <select class="form-control assign_to" name="assign_to" required id="user_id">
                                <option value="" disabled selected>Select a Sales</option>
                                <?php foreach ($agent_users as $key => $user): ?>
                                    <option value="<?= $user['user_id']; ?>">
                                        <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select> -->
                            <input type="hidden" class="previous_agent" name="previous_agent" value="" />
                            <input type="hidden" class="task_id" name="task_id" />
                            <input type="hidden" class="agent_task_id" name="agent_task_id" />
                            <input type="hidden" class="leadgent_user_id" name="leadgent_user_id" />
  
                            <!-- <input type="text" class="lead_id" name="lead_id" /> -->


                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                <div class="ShowEntries">
                                    <label for="entries">Show entries:</label>
                                    <input type="number" id="entriesnum_1" value="10" min="1" step="1" style="width: 60px;">
                                </div>
                                <div class="SearchBox">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search_recycle_lead" placeholder="Search...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="recycledataTable"
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
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Priority</th>
                                        <th>Lead Status</th>
                                        <th>Date Assigned</th>
                                        <th>Sales Remarks</th>
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
                <input type="submit" value="Save changes" class="btn btn-primary">
            </div>
        </div>

        </form>

    </div>
</div>
</div>

<!-- Return to lead Control start -->
<div class="modal fade" id="return-lead-control" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return to Lead Control</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save_return_lead_control_form" class="return_lead_control_form">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <!-- <label for="assign_to">Assign to</label>
                            <select class="form-control assign_to" name="assign_to" required id="user_id">
                                <option value="" disabled selected>Select a Sales</option>
                                <?php foreach ($agent_users as $key => $user): ?>
                                    <option value="<?= $user['user_id']; ?>">
                                        <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select> -->
                            <input type="hidden" class="previous_agent" name="previous_agent" value="" />
                            <input type="hidden" class="task_id" name="task_id" />
                            <input type="hidden" class="agent_task_id" name="agent_task_id" />
                            <input type="hidden" class="leadgent_user_id" name="leadgent_user_id" />
                            <input type="hidden" class="existing_user_id" name="existing_user_id" />

                            <!-- <input type="text" class="lead_id" name="lead_id" /> -->


                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                <div class="ShowEntries">
                                    <label for="entries">Show entries:</label>
                                    <input type="number" id="entriesnum_10" value="10" min="1" step="1" style="width: 60px;">
                                </div>
                                <div class="SearchBox">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search_return_lead_control" placeholder="Search...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="return_lead_controldataTable"
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
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Priority</th>
                                        <th>Lead Status</th>
                                        <th>Date Assigned</th>
                                        <th>Sales Remarks</th>
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
                <input type="submit" value="Return" class="btn btn-primary">
            </div>
        </div>

        </form>

    </div>
</div>
</div>


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