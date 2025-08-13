<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3  ">
                        <h6 class="m-0 pl-4 pb-3 pt-3 font-weight-bold text-primary">List of Sold Authors</h6>
                        <div class="card-body">
                            <div class="row  pl-1 pb-3">
                                <div class="table-responsive col-md-4  pb-3">
                                    <?php if ($this->session->userdata['userlogin']['usertype'] == "Admin" || $this->session->userdata['userlogin']['usertype'] == "Lead Gen."): ?>
                                        <form class="header-search">
                                            <select class="form-control select_agent_extension" id="select_agent_extension" name="select_agent_extension">
                                                <option value="" selected="">All Sold Leads</option>
                                                <?php if ($agent_users != false): ?>
                                                    <?php foreach ($agent_users as $sales): ?>
                                                        <option value="<?php echo $sales['user_id']; ?>">
                                                            <?php echo ucfirst($sales['fname'] . ' ' . $sales['lname']); ?> (<?php echo ucfirst($sales['usertype']); ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <div class="SearchBox col-md-4">
                                    <label for="search">Search:</label>
                                    <input type="text" id="admin_search_sold_author" placeholder="Search...">
                                </div>
                                </div>
                                <table class="table table-bordered table-hover nowrap display" id="sold_author_of_agents_datatable" width="100%"
                                    cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Emails</th>
                                            <th>Phone Numbers</th>
                                            <th>Action</th>
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
</div>
</div>

<div class="modal fade" id="view_transaction_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Transaction History</h5>
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


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="ViewTransactionHistory_dataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Additional Book Title</th>
                                        <th>Pitched Price</th>
                                        <th>Amount</th>
                                        <!-- <th>Previous Agent</th> -->
                                        <th>Payment Status</th>
                                        <th>Services Status</th>
                                        <th>Service Purchased</th>
                                        <th>Service Agent Remarks</th>
                                        <th>Agent Priority</th>
                                        <th>Recording URL</th>
                                        <th>Date Paid</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody class="View_Payment_transaction_history">

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
