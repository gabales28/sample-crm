<div class="pc-container">
<div class="pc-content">
<div class="main-card-container">
        <div class="table-container">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List of Leads</h6>
                    <!-- Button trigger modal for Add lEAD -->
                    
                    <div class="d-flex justify-content-end align-items-center">
                    <form  method="POST" action="<?php echo base_url('leads/upload_lead'); ?>"  enctype="multipart/form-data" class="mr-3 d-flex align-items-center">
                    <?php if($this->session->flashdata('success')):?>
                            <div class="alert alert-success" style="display:block !important; position: absolute; top: 70px;"><p><?php echo $this->session->flashdata('success'); ?></p></div> 
                          <?php elseif($this->session->flashdata('error')):?>
                            <div class="alert alert-danger" style="display:block !important;position: absolute; top: 70px;"><p><?php echo $this->session->flashdata('error'); ?></p></div> 
                        <?php endif;?>
                        <select id="statusfilter" class="form-control" style="width: 100px;">
                            <option value=" " selected>All</option>
                            <option value="Active Lead">Active</option>
                            <option value="Inactive Lead">Inactive</option>
                        </select>
                       <!-- <button type="submit" class="btn btn-secondary">Upload</button>
                        <div class="custom-file mr-2">
                            <input type="file" name="upload_lead" required class="custom-file-input" id="customFileInput" aria-describedby="customFileInput">
                            <label class="custom-file-label" for="customFileInput">Select file</label>
                        </div> -->
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="agentsdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Brand Name</th>
                                    <th>Title</th>
                                    <th>Book Link</th>
                                    <!-- <th>Description</th>
                                    <th>Lead Value</th> -->
                                    <th>Source</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
                                    <!-- <th>Assign to</th> -->
                                    <!-- <th>Priority</th> -->
                                    <th>Date Distributed/Created</th>
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
                 <div class="modal fade" id="LeadsModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
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
                                        <div class="alert alert-success"><p></p></div> 
                                    <ul class="nav nav-tabs gap-3">
                                        <li class="active"><a data-toggle="pill"  id="pills-detail-tab"  href="#details">Details</a></li>
                                        <li><a data-toggle="pill" id="pills-contact-tab"  href="#contact_person_nav" >Contact Person</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="details" class="tab-pane fade in active show" role="tabpanel" aria-labelledby="pills-detail-tab">
                                        <form id="detail_form">  
                                        <div class="form-row mb-3">
                                        <div class="form-group col-md-6">
                                                    <label for="brandName">Brand Name</label>
                                                    <input type="text" class="form-control" id="brandName" name="brandName" required placeholder="Enter brand name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" required placeholder="Enter title">
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
                                                    <input type="text" class="form-control" id="bookLink" name="bookLink" required placeholder="Enter book link">
                                                </div>
                                            <div class="form-group col-md-6">
                                                    <label for="priority">Source</label>
                                                    <select class="form-control" name="source" required id="source">
                                                        <option value="" disabled >Select a Source</option>
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
                                                        <?php foreach ($leadgent_users as $key => $user):?>
                                                           <option value="<?=$user['user_id'];?>"><?php echo ucwords($user['fname'].' '.$user['lname']);?></option>
                                                           <?php endforeach;?>
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
                                        <div id="contact_person_nav" class="tab-pane fade " role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <form id="contactcustomer_form">  
                                           <div class="form-row mb-3">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" required name="customer_name" placeholder="Enter name">
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="address">Address</label>
                                                    <textarea class="form-control" rows="3" id="customer_address" required name="customer_address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-6"> 
                                                    <div id="dynamicForm">
                                                        <div id="inputFields2">
                                                        <label for="number">Contact Number</label>
                                                            <div class="mb-3 field-container d-flex gap-1">
                                                                <input type="text" class="form-control" required name="customer_contact[]" placeholder="Add new contact">
                                                                <button type="button" class="btn btn-danger removeField"><i class="ti ti-trash"></i></button>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="addMoreContact" class="btn btn-primary"><i class="ti ti-plus"></i></button>
                                                    </div>                               
                                            </div>
                                                <div class="form-group col-md-6">
                                                    <div id="dynamicForm">
                                                        <div id="inputFields">
                                                        <label for="email">Email Address</label>
                                                            <div class="mb-3 field-container d-flex gap-1">
                                                                <input type="email" class="form-control" required name="customer_email[]" placeholder="Add new email address">
                                                                <button type="button" class="btn btn-danger removeFields"><i class="ti ti-trash"></i></button>

                                                            </div>
                                                        </div>
                                                        <button type="button" id="addMoreEmail" class="btn btn-primary"><i class="ti ti-plus"></i></button>

                                                    </div>
                                                </div>
                                            </div> 
                                        </form>
                                        </div>
                                    </div>
                                          

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button"  id="add_lead" class="btn btn-primary">Add</button>

                            </div>

                        </div>

                    </div>
                </div>
                <!-- lead end -->


      <!-- Edit Modal -->
 
      <div class="modal fade" id="editLeadsModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Edit Leads</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <!-- leads Form Fields -->
                                        <div class="alert alert-success"><p></p></div> 
                                    <ul class="nav nav-tabs gap-3">
                                        <li class="active"><a data-toggle="pill"  id="pills-detail-tab"  href="#edit_details">Details</a></li>
                                        <li><a data-toggle="pill" id="pills-contact-tab"  href="#edit_contact_person_nav" >Contact Person</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="edit_details" class="tab-pane fade in active show" role="tabpanel" aria-labelledby="pills-detail-tab">
                                        <form id="edit_detail_form" class="edit_detail_form">  
                                        <div class="form-row mb-3">
                                        <div class="form-group col-md-6">
                                                    <label for="brandName">Brand Name</label>
                                                    <input type="text" class="form-control" id="brandName" name="brandName" required placeholder="Enter brand name">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" required placeholder="Enter title">
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
                                                    <label for="bookLink">Book Link</label>
                                                    <input type="text" class="form-control" id="bookLink" name="bookLink" required placeholder="Enter book link">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="priority">Source</label>
                                                    <select class="form-control" name="source" required id="source">
                                                        <option value="" disabled >Select a Source</option>
                                                        <option value="Company">Company</option>
                                                        <option value="Website">Website</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div> 
                                                <!-- <div class="form-group col-md-6">
                                                    <label for="assign_to">Assign to</label>
                                                    <select class="form-control" name="assign_to" required id="assign_to">
                                                        <option value="" disabled selected>Select a Sales</option>
                                                        <?php foreach ($leadgent_users as $key => $user):?>
                                                           <option value="<?=$user['user_id'];?>"><?php echo ucwords($user['fname'].' '.$user['lname']);?></option>
                                                           <?php endforeach;?>
                                                    </select>
                                                </div> -->
                                            <div class="form-row mb-3">   
                                                <div class="form-group col-md-6">
                                                    <label for="statusData">Status</label>
                                                    <select class="form-control" name="statusData" required id="statusData">
                                                        <option value="" disabled selected>Select a Status</option>
                                                        <option value="Active Leads">Active</option>
                                                        <option value="Inactive Leads">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </form>                         
                                        </div>
                                        <div id="edit_contact_person_nav" class="tab-pane fade " role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <form id="edit_contactcustomer_form" class="edit_contactcustomer_form">  
                                           <div class="form-row mb-3">
                                                <div class="form-group col-md-6">
                                                    <label for="name">Customer Name</label>
                                                    <input type="text" class="form-control" id="name" required name="customer_name" placeholder="Enter name">
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label for="address">Address</label>
                                                    <textarea class="form-control customer_address" rows="3" id="customer_address" required name="customer_address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-6"> 
                                                    <div id="dynamicForm">
                                                        <div id="inputFields2">
                                                        <label for="number">Contact Number</label>
                                                            <div class="mb-3 ">
                                                               
                                                                <div class="customer_contact_details"> </div>
                                                                <input type="hidden" class="form-control" required name="lead_id" readonly>
                                                            </div>
                                                        </div>
                                                        <button type="button" id="addMoreContact" class="btn btn-primary"><i class="ti ti-plus"></i></button>

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
                                                        <button type="button" id="addMore" class="btn btn-primary"><i class="ti ti-plus"></i></button>
                                                     
                                                    </div>
                                                </div>
                                            </div> 
                                        </form>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button"  id="update_lead" class="btn btn-primary">Save Change</button>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- lead end -->
