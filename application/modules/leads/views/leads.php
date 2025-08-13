<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Leads</h6>
                        <!-- Button trigger modal for Add lEAD -->

                        <div class="d-flex justify-content-end align-items-center">
                        <button id="export_csv" class="btn btn-primary" style="margin-right:20px">Export to CSV</button>

                            <form method="POST" action="<?php echo base_url('leads/upload_lead'); ?>"
                                enctype="multipart/form-data" class="mr-3 d-flex align-items-center">
                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success"
                                        style="display:block !important; position: absolute; top: 70px;">
                                        <p><?php echo $this->session->flashdata('success'); ?></p>
                                    </div>
                                <?php elseif ($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger"
                                        style="display:block !important;position: absolute; top: 70px;">
                                        <p><?php echo $this->session->flashdata('error'); ?></p>
                                    </div>
                                <?php endif; ?>
                                <select id="statusfilter" class="form-control statusfilter" style="margin-right: 1rem">
                                <option value="">All</option>
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
                                <button type="submit" class="btn btn-secondary"
                                    style="margin-right: .2rem;">Upload</button>
                                <div class="custom-file mr-2">
                                    <input type="file" name="upload_lead" class="custom-file-input" id="customFileInput"
                                        aria-describedby="customFileInput">
                                    <label class="custom-file-label" for="customFileInput">Select file</label>
                                </div>
                            </form>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#LeadsModal">Add Lead</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="custom-header d-flex mb-2"
                                style="align-items: center; justify-content: space-between; ">
                                <!-- <div class="ShowEntries">
                                    <label for="entries">Show entries:</label>
                                    <input type="number" id="entries" value="10" min="1" step="1" style="width: 60px;">
                                </div> -->
                                <!-- <div class="SearchBox">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search" placeholder="Search...">
                                </div> -->
                            </div>
                            <table class="table table-bordered table-hover nowrap display" id="leaddatatable"
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
                                        <!-- <th>Description</th>
                                    <th>Lead Value</th> -->
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Sales Remarks</th>
                                        <!-- <th>Assign to</th> -->
                                        <!-- <th>Priority</th> -->
                                        <th>Date Created</th>
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
                <h5 class="modal-title" id="editUserModalLabel">Add Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- leads Form Fields -->
                <div class="alert alert-danger">
                    <p></p>
                </div>
                <ul class="nav nav-tabs gap-3">
                    <li class="active"><a data-toggle="pill" id="pills-contact-tab" href="#contact_person_nav">Contact
                            Person</a></li>
                    <li><a data-toggle="pill" id="pills-detail-tab" href="#details">Details</a></li>
                </ul>
                <div class="tab-content">
                    <div id="contact_person_nav" class="tab-pane fade in active show" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="contactcustomer_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="customer_name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-6">

                                    <label for="address">Address</label>
                                    <textarea class="form-control" rows="3" id="customer_address"
                                        name="customer_address"></textarea>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields2">
                                            <label for="number">Contact Number</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="text" class="form-control" name="customer_contact[]"
                                                    placeholder="Add new contact">
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
                                                <input type="email" class="form-control" name="customer_email[]"
                                                    placeholder="Add new email address">
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
                    <div id="details" class="tab-pane fade " role="tabpanel" aria-labelledby="pills-detail-tab">
                        <form id="detail_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="brandName">Previous Publisher</label>
                                    <input type="text" class="form-control" id="brandName" name="brandName"
                                        placeholder="Enter Previous Publisher">
                                </div>
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields3">
                                            <label for="title">Title</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="text" class="form-control" id="title" name="title[]"
                                                    placeholder="Enter title">
                                                <button type="button" class="btn btn-danger removeFields_1"><i
                                                        class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreTitle" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>

                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <label for="bookLink">Book Link</label>
                                        <div id="inputFields4">
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="text" class="form-control" id="bookLink" name="bookLink[]"
                                                    placeholder="Enter book link">
                                                <button type="button" class="btn btn-danger removeFields_2"><i
                                                        class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreBookLink" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-md-6">
                                    <label for="priority">Source</label>
                                    <select class="form-control" name="source" id="source">
                                        <option value="" disabled>Select a Source</option>
                                        <option value="Company" selected>Company</option>
                                        <option value="Website">Website</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div> -->
                                <div class="form-group col-md-6">
                                    <label for="Source">Source</label>
                                    <input type="text" class="form-control" name="source" id="source"
                                        placeholder="Source">
                                </div>


                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="statusData">Status</label>
                                    <select class="form-control" name="statusData" id="statusData">
                                        <option value="" selected>All</option>
                                        <option value="Active Lead">Active Lead</option>
                                        <option value="Inactive Lead">Inactive Lead</option>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <!-- leads Form Fields -->
                <div class="alert alert-danger">
                    <p></p>
                </div>
                <ul class="nav nav-tabs gap-3">
                    <li class="active"><a data-toggle="pill" id="pills-contact-tab"
                            href="#edit_contact_person_nav">Contact Person</a></li>
                    <li><a data-toggle="pill" id="pills-detail-tab" href="#edit_details">Details</a></li>
                </ul>
                <div class="tab-content">
                    <div id="edit_contact_person_nav" class="tab-pane fade  in active show" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="edit_contactcustomer_form" class="edit_contactcustomer_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Customer Name</label>
                                    <input type="text" class="form-control" id="name" name="customer_name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-6">

                                    <label for="address">Address</label>
                                    <textarea class="form-control customer_address" rows="3" id="customer_address"
                                        name="customer_address"></textarea>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields2">
                                            <label for="number">Contact Number</label>
                                            <div class="mb-3 ">

                                                <div class="customer_contact_details"> </div>
                                                <input type="hidden" class="form-control" name="lead_id" readonly>
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
                                            <div class="mb-3 ">

                                                <div class="customer_email_details"></div>

                                            </div>
                                        </div>
                                        <button type="button" id="addMore" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="edit_details" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-detail-tab">
                        <form id="edit_detail_form" class="edit_detail_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="brandName">Previous Publisher</label>
                                    <input type="text" class="form-control" id="brandName" name="brandName"
                                        placeholder="Enter Previous Publisher">
                                </div>
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields3">
                                            <label for="title">Title</label>
                                            <div class="mb-3 ">
                                                <div class="book_title_details"></div>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreTitle" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>

                                    </div>
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
                                <!-- <div class="form-group col-md-6">
                                                    <label for="value">Lead Value</label>
                                                    <input type="text" class="form-control" id="value" required name="value" placeholder="Enter Value">
                                                </div> -->
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <label for="bookLink">Book Link</label>
                                        <div id="inputFields4">
                                            <div class="mb-3">
                                                <div class="bookLink_details"></div>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreBookLink" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- <div class="form-group col-md-6">
                                    <label for="priority">Source</label>
                                    <select class="form-control" name="source" id="source">
                                        <option value="" disabled>Select a Source</option>
                                        <option value="Company">Company</option>
                                        <option value="Website">Website</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div> -->
                                <div class="form-group col-md-6">
                                    <label for="Source">Source</label>
                                    <input type="text" class="form-control" name="source" id="source"
                                        placeholder="Source">
                                </div>
                            </div>
                            <!-- <div class="form-group col-md-6">
                                                    <label for="assign_to">Assign to</label>
                                                    <select class="form-control" name="assign_to" required id="assign_to">
                                                        <option value="" disabled selected>Select a Sales</option>
                                                        <?php foreach ($leadgent_users as $key => $user): ?>
                                                           <option value="<?= $user['user_id']; ?>"><?php echo ucwords($user['fname'] . ' ' . $user['lname']); ?></option>
                                                           <?php endforeach; ?>
                                                    </select>
                                                </div> -->
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="statusData">Status</label>
                                    <select class="form-control" name="statusData" id="statusData">
                                        <option value="" disabled selected>Select a Status</option>
                                        <option value="" selected>All</option>
                                        <option value="Active Lead">Active Lead</option>
                                        <option value="Inactive Lead">Inactive Lead</option>
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
                                <div class="form-group col-md-6">
                                    <label for="SalesRemarks">Sales Remarks</label>
                                    <input type="text" class="form-control" name="sales_remarks" id="sales_remarks"
                                        placeholder="Sales Remarks">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="update_lead" class="btn btn-primary">Save Change</button>

            </div>

        </div>

    </div>
</div>

<!-- lead end -->

<!-- <div id="loadingSpinner" style="">
<img src="<?php echo base_url('assets/images/loader.gif'); ?>" alt="Loading...">
</div> -->


