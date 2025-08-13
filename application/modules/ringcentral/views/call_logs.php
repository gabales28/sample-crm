<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <!-- Flatpkr -->
                <!-- End Content Row -->
                <div class="col-sm-4.5 d-inline-block mb-2">
                    <div id="reportpaymentrange" style="background: #fff; cursor: pointer; padding: 10px 15px; border: 1px solid #ccc;">
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                </div>
                <div class="col-sm-4 d-inline-block mb-2">
                    <?php if ($this->session->userdata['userlogin']['usertype'] == "Admin" || $this->session->userdata['userlogin']['usertype'] == "Lead Gen."): ?>
                        <form class="header-search">
                            <select class="form-control agent_extension" id="agent_extension" name="agent_extension">
                                <option value="0" disabled="" selected="">Select an Agent</option>
                                <?php if ($agent_users != false): ?>
                                    <?php foreach ($agent_users as $sales): ?>
                                        <option value="<?php echo $sales['phonenumber']; ?>">
                                            <?php echo ucfirst($sales['fname'] . ' ' . $sales['lname']); ?> (<?php echo ucfirst($sales['usertype']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-sm-4 d-inline-block mb-4">
                    <h3>Total of Call logs: <span class="total_call_logs">0</span></h3>
                </div>


                <!-- <form id="agent_user" method="post">
                    <input type="hidden" id="from_date" name="from_date" class="form-control" />
                    <input type="hidden" id="to_date" name="to_date" class="form-control" />
                </form> -->

                <!-- Flatpkr -->
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Call Logs</h6>
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
                            <table class="table table-bordered table-hover nowrap display" id="callLogs_dataTable" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <!-- <th>Ext. Number</th> -->
                                        <th>To</th>
                                        <th>Action</th>
                                        <th>Result</th>
                                        <th>Date / Time</th>
                                        <th>Call Duration</th>
                                        <th>Recording</th>
                                    </tr>
                                </thead>
                                <tbody class="callLogs">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>