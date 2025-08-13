<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Leads</h6>
                        <!-- Button trigger modal for Add User -->
                        <div class="d-flex justify-content-end align-items-center">

                            <select id="agentstatusfilters" class="form-control col-sm-2 "
                                style="margin-right: 1rem">
                                <option value="" selected>All</option>
                                <option value="Pipe">Pipe</option>
                                <option value="Prospect">Prospect</option>
                                <option value="Closed">Closed</option>
                            </select>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="agentsdatatable" width="100%" cellspacing="0"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Contact</th>
                                        <th>Email Address</th>
                                        <th>Book Link</th>
                                        <th>Title</th>
                                        <th>Address</th>
                                        <!-- <th>Previous Publisher</th> -->
                                        <th>Source</th>
                                        <th>Lead Status</th>
                                        <th>Date Distributed</th>
                                        <th>Agent Priority</th>
                                        <th>Service Status</th>
                                        <th>Service Purchased</th>
                                        <th>Agent Service Remarks</th>
                                        <th>Pitched Price</th>
                                        <th>Payment Status</th>
                                        <th>Total Payment</th>
                                        <th>Remaining Balance</th>
                                        <th>Recording URL</th>
                                        <th>Phone and Email Status</th>
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

<!-- Add Lead Modal -->
<div class="modal fade" id="LeadsModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Add Leads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- leads Form Fields -->
                <ul class="nav nav-tabs gap-3">
                    <li class="active"><a data-toggle="pill" id="pills-detail-tab" href="#details">Details</a></li>
                    <li><a data-toggle="pill" id="pills-contact-tab" href="#contact_person_nav">Contact Person</a></li>
                </ul>
                <div class="tab-content">
                    <div id="details" class="tab-pane fade in active show" role="tabpanel"
                        aria-labelledby="pills-detail-tab">
                        <form id="detail_form">
                            <div class="alert alert-success"></div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brandName" required
                                        placeholder="Enter brand name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        placeholder="Enter title">
                                </div>
                                <!-- <div class="form-group col-md-6">
                                                    <label for="desc">Description</label>
                                                    <textarea class="form-control desc" rows="3" id="desc"  name="desc"></textarea>
                                                </div> -->
                            </div>
                            <!-- <div class="form-row mb-3">
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="statuServices">Status</label>
                                                    <select class="form-control" name="statuServices" required id="statuServices">
                                                        <option value="" disabled selected>Select a Services</option>
                                                        <option value="MKTG">MKTG</option>
                                                        <option value="PUB">PUB</option>
                                                    </select> 
                                                 </div>
                                            </div> -->
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="bookLink">Book Link</label>
                                    <input type="text" class="form-control" id="bookLink" name="bookLink" required
                                        placeholder="Enter book link">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="priority">Source</label>
                                    <select class="form-control" name="source" required id="source">
                                        <option value="" disabled>Select a Source</option>
                                        <option value="Company" selected>Company</option>
                                        <option value="Website">Website</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group col-md-6">
                                                    <label for="value">Lead Value</label>
                                                    <input type="text" class="form-control" id="value" required name="value" placeholder="Enter Value">
                                                </div> -->

                                <!-- <div class="form-group col-md-6">
                                                    <label for="assign_to">Assign to</label>
                                                    <select class="form-control" name="assign_to" required id="assign_to">
                                                        <option value="" disabled selected>Select a Sales</option>
                                                        <?php foreach ($leadgent_users as $key => $user): ?>
                                                           <option value="<?= $user['user_id']; ?>"><?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?></option>
                                                           <?php endforeach; ?>
                                                    </select>
                                                </div> -->
                                <!-- <div class="form-group col-md-6">
                                                    <label for="priority">Priority</label>
                                                    <select class="form-control" name="priority" required id="priority">
                                                        <option value="" disabled selected>Select a Status</option>
                                                        <option value="Low">Low</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="High">High</option>
                                                    </select>
                                                </div> -->
                            </div>
                        </form>
                    </div>
                    <div id="contact_person_nav" class="tab-pane fade " role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="contactcustomer_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" required name="customer_name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-6">

                                    <label for="address">Address</label>
                                    <textarea class="form-control" rows="3" id="customer_address" required
                                        name="customer_address"></textarea>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields2">
                                            <label for="number">Contact Number</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="text" class="form-control" required
                                                    name="customer_contact[]" placeholder="Add new contact">
                                                <button type="button" class="btn btn-danger removeField"><i
                                                        class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreContact" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields">
                                            <label for="email">Email Address</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="email" class="form-control" required
                                                    name="customer_email[]" placeholder="Add new email address">
                                                <button type="button" class="btn btn-danger removeFields"><i
                                                        class="ti ti-trash"></i></button>

                                            </div>
                                        </div>
                                        <button type="button" id="addMoreEmail" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="add_lead" class="btn btn-primary">Add</button>

            </div>

        </div>

    </div>
</div>
<!-- lead end -->


<!-- Edit Modal -->

<div class="modal fade" id="editLeadsModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Add Lead Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">

                <div id="edit_details" class="tab-pane fade in active show" role="tabpanel"
                    aria-labelledby="pills-detail-tab">
                    <form id="edit_agent_detail_form " class="edit_detail_form">
                        <div class="alert alert-danger">
                            <p></p>
                        </div>
                        <div class="row">
                        <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                                    <label for="priority">Priority</label>
                                    <select class="form-control agent_priority" name="agent_priority"
                                        id="agent_priority">
                                        <option value="" disabled selected>Select a Priority</option>
                                        <option value="Pipe">Pipe</option>
                                        <option value="Prospect">Prospect</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                            <div class="form-group col-md-6">
                                    <label for="additional_book">Additional Title (if the author is submitting another book)</label>
                                    <textarea name="additional_book" class="form-control additional_book" id="additional_book" placeholder="Another Book Title (optional)" cols="30" rows="2"></textarea>
                                </div>
                                

                                <div class="form-group col-md-6">
                                    <label for="ServicesStatus">Services Status</label>
                                    <select class="form-control services_status" name="services_status"
                                        id="services_status" disabled>
                                        <option value="" disabled selected>Select service status</option>
                                        <option value="Publishing">Publishing</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Package">Package</option>
                                        <option value="Add Ons">Add Ons</option>
                                    </select>
                                    <!-- <textarea class="form-control services_status" name="services_status" id="services_status" cols="20" rows="5"></textarea> -->
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="service_purchased">Service Purchased</label>
                                    <textarea type="text" class="form-control service_purchased" placeholder="ex. pawn, knight, website, etc...." name="service_purchased"
                                        id="service_purchased" id="service_purchased"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Remarks">Service Remarks</label>
                                    <select class="form-control agent_remarks" name="agent_remarks" id="agent_remarks"
                                        disabled>
                                        <option value="" disabled selected>Select a Remark</option>
                                        <option value="On Process">On Process</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="PitchedPrice">Pitched Price</label>
                                    <input type="text" class="form-control pitched_price" placeholder="$0.00" name="pitched_price"
                                        id="pitchedPrice" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="PaymentStatus">Payment Status</label>
                                    <select class="form-control payment_status" name="payment_status" id="paymentStatus"
                                        disabled>
                                        <option value="" disabled selected>Select a Payment Status</option>
                                        <option value="Initial payment">Initial payment</option>
                                        <option value="Full payment">Full payment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="form-group col-md-6" id="amountContainer">
                                    <label for="Amount">Amount</label>
                                    <input type="number" class="form-control amount" name="amount" placeholder="$0.00" id="amount" disabled>
                                    <input type="hidden" class="form-control total_payment" name="total_payment" placeholder="$0.00" id="total_payment" disabled>

                                </div>
                                <div class="form-group col-md-6" id="amountContainer">
                                    <label for="balance">Balance</label>
                                    <input type="number" class="form-control balance" name="balance" placeholder="$0.00" id="balance" readonly>

                                </div>
                                <input type="hidden" class="current_status_payment" name="current_status_payment" readonly>
                                <input type="hidden" class="form-control current_balance" name="current_balance" id="current_balance">
                                <input type="hidden" class="form-control current_amount" name="current_amount" id="current_amount">
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md">
                                    <label for="Recording">Recording URL</label>
                                    <input type="recording" class="form-control recording" required placeholder="Recording URL" name="recording"
                                        id="recording" disabled id="recording">
                                </div>

                    </form>
                </div>
                <input type="hidden" class="agent_task_id" name="agent_task_id" />
                <input type="hidden" class="lead_id" name="lead_id" />
            </div>

            <input type="hidden" class="lead_id" name="lead_id" />
            <input type="hidden" class="agent_task_id" name="agent_task_id" />

        </div>



        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="update_agent_lead" class="btn btn-primary">Save</button>

        </div>

        </form>
    </div>

</div>

</div>
</div>
</div>

<!-- lead end -->



<!-- edit  Multiple Tasks Modal -->
<div class="modal fade" id="view_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">History</h5>
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
                            <table class="table table-bordered table-hover nowrap display" id="paymenthistorydataTable"
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
                                        <th>Date Paid</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody class="details_history">

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


<div class="modal fade" id="edit_agentLeadsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 1300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Payments</h5>
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
                            <table class="table table-bordered table-hover nowrap display" id="editPaymentsdataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Additional Book Title</th>
                                        <th>Pitched Price</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Services Status</th>
                                        <th>Service Purchased</th>
                                        <th>Payment Status</th>
                                        <th>Service Agent Remarks</th>
                                        <th>Agent Priority</th>
                                        <th>Recording</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="edit_agent_leads">

                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <td colspan="4" style="text-align:right;"><strong>Total Balance:</strong></td>
                                        <td id="totalBalanceCell"></td>
                                    </tr>
                                </tfoot> -->
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