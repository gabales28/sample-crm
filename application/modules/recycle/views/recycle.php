<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recycle History</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="recycledatatable" width="100%" cellspacing="0"
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
                                        <th>Total Payment</th>
                                        <th>Remaining Balance</th>
                                        <th>Recording URL</th>
                                        <th>Status</th>
                                        <th>Date Distributed/Created</th>
                                        <th>Agent Date Assigned</th>
                                        <th>Note</th>
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
                                <table class="table table-bordered table-hover nowrap display" id="viewrecycle_historydatatable"
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
                                            <th>Status</th>
                                            <th>Date Recycled</th>
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