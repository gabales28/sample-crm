
<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Trash Leads</h6>
                        <!-- Button trigger modal for Add User -->

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="leadgent_taskdatatable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Removed Leads</th>
                                        <th>Remove Date</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($trashleadsview > 0):
                                        $n = 1;
                                        $customer_contact = "";
                                        $customer_email = ""; ?>
                                        <?php foreach ($trashleadsview as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['user_removed_leads']); ?></td>
                                                <td><?php echo date('Y/m/d', strtotime($row['remove_date'])); ?></td>
                                                <td><?php echo $row['total_trash_leads']; ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                                                    <button type="button" class="btn btn-md btn-info trash_leads"
                                                        data-user_remove_leads_id="<?php echo $row['user_remove_leads_id']; ?>"
                                                        data-trash_id="<?php echo $row['trash_id']; ?>"
                                                        data-remove_date="<?php echo date("Y-m-d", strtotime($row['remove_date'])); ?>"
                                                        data-toggle="modal" data-target="#trash_leads">Restore
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
        <div class="modal fade" id="trash_leads" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 100%; max-width:1560px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Restore Leads</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="save_restore_form" class="view_restore_leads_form">

                            <div class="alert alert-danger">
                                <p></p>
                            </div>
                            <!-- Add Task Form Fields -->
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="User-removed-leads">User Removed Leads</label>
                                    <input class="form-control user_removed_leads" rows="3" id="user_removed_leads"
                                        name="user_removed_leads" readonly></input>
                                        <input type="hidden" class="trash_id" name="trash_id" />
                                        <input type="hidden" class="user_id" name="user_id" />
                                </div>
                              

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="custom-header d-flex mb-2"
                                            style="align-items: center; justify-content: space-between; ">
                                            <div class="ShowEntries">
                                                <label for="entries">Show entries:</label>
                                                <input type="number" id="entriesnum_20" value="10" min="1" step="1"
                                                    style="width: 60px;">
                                            </div>
                                            <div class="SearchBox">
                                                <label for="search">Search:</label>
                                                <input type="text" id="searches" placeholder="Search...">
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-hover nowrap display"
                                            id="restoreTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Contact Email</th>
                                                    <th>Remove Date</th>
                                                    <th>Select</th>
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
                                <input type="submit" value="Restore" id="trash_leads" class="btn btn-primary">
                            </div>
                    </div>

                    </form>

                </div>
            </div>
        </div>