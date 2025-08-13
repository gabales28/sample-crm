<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Tasks</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">

                            <select id="status_task_agent_filters" class="form-control col-sm-2" style="margin-right: 1rem">
                                <option value="" selected>All</option>
                                <option value="Active Lead">Active Lead</option>
                                <option value="Inactive Leads">Inactive Lead</option>
                                <option value="Active Email">Active Email</option>
                                <option value="Confirmed Leads">Confirmed Leads</option>
                                <option value="Unconfirmed">Unconfirmed</option>
                                <option value="Voice Mail Leads">Voice Mail Leads</option>
                                <option value="Distributed Leads">Distributed Leads</option>
                                <option value="Disconnected">Disconnected</option>
                                <option value="Wrong Email & Phone">Wrong Email & Phone</option>
                                <option value="Special Leads">Special Leads</option>
                                <option value="Filtered Confirmed No.">Filtered Confirmed No.</option>
                                <option value="Active Clients">Active Clients</option>
                                <option value="Deceased">Deceased</option>
                            </select>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="taskagentdatatable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>Previous Publisher</th> -->
                                        <th>Title</th>
                                        <th>Book Link</th>
                                        <th>Source</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Customer Email</th>
                                        <th>Address</th>
                                        <th>Priority</th>
                                        <th>Assigned Agent</th>
                                        <th>Lead Status</th>
                                        <th>Agent Priority</th>
                                        <th>Service Status</th>
                                        <th>Agent Remarks</th>
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
                                        <th>Lead Gen. Distributor</th>
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