<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Tasks</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">

                            <select id="statusfilters" class="form-control col-sm-2" style="margin-right: 1rem">
                                <option value="" selected>All</option>
                                <option value="Active Lead">Active Lead</option>
                                <option value="Inactive Lead">Inactive Lead</option>
                            </select>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="taskdatatable"
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
                                        <th>Assigned Agent</th>
                                        <th>Lead Status</th>
                                        <th>Services Status</th>
                                        <th>Agent Priority</th>
                                        <th>Agent Service Remarks</th>
                                        <th>Recording URl</th>
                                        <th>Date Distributed/Created</th>
                                        <th>Agent Date Assigned</th>
                                        <th>Sales Remarks</th>
                                        <th>Note</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php if ($tabletasks > 0 || $tableleadgents > 0): ?>
                                        <?php
                                        $n = 1;

                                        foreach ($tabletasks as $row):
                                            // Find related row in $tableleadgents
                                            $relatedRow = null;

                                            ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo $row['brand_name']; ?></td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['book_link']; ?></td>
                                                <td><?php echo $row['source']; ?></td>
                                                <td><?php echo $row['customer_name']; ?></td>
                                                <td><?php echo $row['customer_contact']; ?></td>
                                                <td><?php echo $row['customer_address']; ?></td>
                                                <td><?php echo $row['priority']; ?></td>
                                                <td><?php echo $row['customer_email']; ?></td>
                                                <td><?php echo ucwords($row['fname'] . ' ' . $row['lname']); ?>
                                                </td>
                                                <td><?php echo ucwords($row['agent_fname'] . ' ' . $row['agent_lname']); ?>
                                                </td>
                                                <td><?php echo $row['lead_status']; ?></td>
                                                <td><?php echo $row['services_status']; ?></td>
                                                <td><?php echo $row['agent_priority']; ?></td>
                                                <td><?php echo $row['agent_remarks']; ?></td>
                                                <td><?php echo $row['note']; ?></td>
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['date_assigned'])); ?></td>
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['agent_date_assined'])); ?>
                                                </td>


                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?> -->
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
                            <table class="table table-bordered table-hover nowrap display" id="viewstaskdataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Lead Gen Distributor</th>
                                        <th>Assigned Agent</th>
                                        <th>Title</th>
                                        <th>Book Link</th>
                                        <!-- <th>Lead Value</th> -->
                                        <th>Source</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Email Address</th>
                                        <th>Priority</th>
                                        <th>Lead Status</th>
                                        <th>Date Assigned</th>
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
<div class="modal fade" id="edit_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="history_task_form" class="">

                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <!-- Add Task Form Fields -->
                   

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="edithistorydataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Additional Book Title</th>
                                        <th>Pitched Price</th>
                                        <th>Amount</th>
                                        <th>Payment Status</th>
                                        <th>Services Status</th>
                                        <th>Service Purchased</th>
                                        <th>Service Agent Remarks</th>
                                        <th>Agent Priority</th>
                                        <th>Recording URL</th>
                                        <th>Date paid</th>
                                        <th>Date</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody class="edit_history">

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