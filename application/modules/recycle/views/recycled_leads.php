<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Recycled Leads</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">
                        

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="listagent_taskdatatable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>lead Generation assigned</th>
                                        <th>Assigned Agent</th>
                                        <th>Status</th>
                                        <th>Date Returned</th>
                                        <th>Total Leads</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($return_to_lead_control_data > 0): $n = 1;
                                        $customer_contact = "";
                                        $customer_email = ""; ?>
                                        <?php foreach ($return_to_lead_control_data as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['lead_gen_name']); ?></td>
                                                <td><?php echo ucwords($row['previous_agent']); ?></td>
                                                <td><?php echo ucwords($row['return_status']); ?></td>
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['date_return_to_lead_control'])); ?></td>
                                                <td><?php echo $row['tasks_total']; ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                               
                                                    <button type="button" class="btn btn-md  return_to_backet" style="background-color:#003333; color:white"
                                                        data-task_id="<?php echo $row['return_to_lead_control_id']; ?>"
                                                        data-user_id="<?php echo $row['agent_id']; ?>"
                                                        data-date_assigned="<?php echo date("Y-m-d", strtotime($row['date_return_to_lead_control'])); ?>"
                                                        data-toggle="modal"
                                                        data-target="#view-return-lead-control">Return Lead
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

<!-- view and return lead  -->
<div class="modal fade" id="view-return-lead-control" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return Leads to the Bucket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_return_lead_backet_form" class="return_lead_backet_form">

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
                            <!-- <input type="text" class="previous_agent" name="previous_agent" value="" /> -->
                            <input type="hidden" class="lead_id" name="lead_id" />
                            <input type="hidden" class="return_to_lead_control_id" name="return_to_lead_control_id" />
                            <!-- <input type="text" class="leadgent_user_id" name="leadgent_user_id" />
                            <input type="text" class="existing_user_id" name="existing_user_id" /> -->

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
                                    <input type="text" id="search_recycle" placeholder="Search...">
                                </div>
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="return_lead_backetdataTable"
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
                <input type="submit" value="Return" class="btn btn-primary">
            </div>
        </div>

        </form>

    </div>
</div>
</div>
<!-- view history -->
<div class="modal fade" id="viewrecyclehistory_datatable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Reycle History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="view_recycle_history" class="view_recycleform">

                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                    <div class="row">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="custom-header d-flex mb-2" style="align-items: center; justify-content: space-between; ">
                                    <div class="ShowEntries">
                                        <label for="entries">Show entries:</label>
                                        <input type="number" id="entries_75" value="10" min="1" step="1" style="width: 60px;">
                                    </div>
                                    <div class="SearchBox">
                                        <label for="search">Search:</label>
                                        <input type="text" id="search" placeholder="Search...">
                                    </div>

                                    <input type="hidden" class="recycle_id" name="recycle_id" />
                                    <input type="hidden" class="lead_id" name="lead_id" />
                                </div>
                                <table class="table table-bordered table-hover nowrap display" id="Exampleewrecycle_historydatatable"
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
                                            <th>Lead Gen. Distributor</th>
                                            <th>Previous Agent</th>
                                            <th>Lead Status</th>
                                            <th>Services Status</th>
                                            <th>Agent Priority</th>
                                            <th>Agent Service Remarks</th>
                                            <th>Pitched Price</th>
                                            <th>Payment Status</th>
                                            <th>Recording URL</th>
                                            <th>Date Distributed/Created</th>
                                            <th>Agent Date Assigned</th>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
            </div>

            </form>

        </div>
    </div>
</div>