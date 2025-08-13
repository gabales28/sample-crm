<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of lead Generations</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" class="mr-2 btn btn-primary" data-toggle="modal"
                                data-target="#addmultipleleadgentsTaskModal"> Assign Agent </button>
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addleadgentTaskModal">Add
                        single</button> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="agent_leadgent" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Agent Name</th>
                                        <th>Lead Gen. Name</th>
                                        <th>Date Assigned</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if ($table_agent_leadgents > 0): $n = 1; ?>
                                        <?php foreach ($table_agent_leadgents as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['fname'] . ' ' . $row['lname']); ?></td>
                                                <td><?php echo ucwords($row['leadgent_fname'] . ' ' . $row['leadgent_lname']); ?></td>
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['date_assigned'])); ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                                                    <button type="button" class="btn btn-md btn-danger edit_leadgent_agent" data-task_id="<?php echo $row['agent_leadgent_id']; ?>"
                                                        data-user_id="<?php echo $row['user_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['date_assigned'])); ?>"
                                                        data-toggle="modal"
                                                        data-target="#editlistoftask">Edit
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
<!-- Add Multiple Tasks Modal -->
<div class="modal fade" id="addmultipleleadgentsTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form id="savemultipleleadgentagentform" method="POST">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="assign_to">Assign to</label>
                            <select class="form-control" name="assign_to" required id="user_id">
                                <option value="" disabled selected>Select a Lead Gen.</option>
                                <?php foreach ($leadgent_users as $key => $user): ?>
                                    <option value="<?= $user['user_id']; ?>">
                                        <?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- <div class="form-group col-md-3">
                            <label for="Remarks">Remarks</label>
                            <textarea class="form-control " rows="3" id="remarks" name="remarks"></textarea>
                        </div> -->
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="SalesLeadgentuserdatatable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Phone Number</th>
                                        <th>Email Address</th>
                                        <th>Status</th>
                                        <th>Select<span id="checkedCountDisplay"> </span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($agent_users > 0): $n = 1; ?>
                                        <?php foreach ($agent_users as $key => $user):  ?>
                                            <tr>
                                                <td><?= $n++; ?></td>
                                                <td><?= $user['fname'] . ' ' .  $user['lname']; ?></td>
                                                <td><?= $user['contact']; ?></td>
                                                <td><?= $user['email_add']; ?></td>
                                                <td><?= $user['status']; ?></td>
                                                <td><input type="checkbox" name="users_id[]" class="lead-checkbox" data-user_id="<?= $user['user_id']; ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
    <div class="modal-dialog" style="width: 100%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit lead Gen. Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_leadgent_agent_form" class="update_leadgent_agent_form">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                   
                    <div class="form col-mb-3">
                            <label for="assign_to">Assign to</label>
                            <select class="form-control assign_leadgent" name="assign_leadgent" required id="">
                                <option value="" disabled selected>Select a Lead Gen.</option>
                                <?php foreach ($leadgent_users as $key => $user): ?>
                                    <option value="<?= $user['user_id']; ?>">
                                        <?= ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- <input type="hidden" class="leadgent_task_id" name="leadgent_task_id" /> -->
                   
                    <div class="form col-mb-3">
                        <label for="assign_to_agent">Select Agent</label>
                        <select class="form-control assign_agent" name="assign_agent" required id="">
                            <option value="" disabled selected>Select an Agent</option>
                            <?php foreach ($agent_users as $key => $user): ?>
                                <option value="<?= $user['user_id']; ?>">
                                    <?= ucwords($user['fname'] . ' ' . $user['lname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" class="agent_leadgent_id" name="agent_leadgent_id"/>
                        <input type="hidden" class="existing_agent_user_id" name="existing_agent_user_id"/>
                        <input type="hidden" class="existing_leadgent_user_id" name="existing_leadgent_user_id"/>   
                    </div>
                    <!-- <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="SalesLeadgentuserdatatable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Phone Number</th>
                                        <th>Email Address</th>
                                        <th>Status</th>
                                        <th>Select<span id="checkedCountDisplay"> </span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($agent_users > 0): $n = 1; ?>
                                        <?php foreach ($agent_users as $key => $user):  ?>
                                            <tr>
                                                <td><?= $n++; ?></td>
                                                <td><?= $user['fname'] . ' ' .  $user['lname']; ?></td>
                                                <td><?= $user['contact']; ?></td>
                                                <td><?= $user['email_add']; ?></td>
                                                <td><?= $user['status']; ?></td>
                                                <td><input type="checkbox" name="users_id[]" class="lead-checkbox" data-user_id="<?= $user['user_id']; ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
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