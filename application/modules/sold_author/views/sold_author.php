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
                                            <select class="form-control select_agent_extension_leadgen" id="select_agent_extension" name="select_agent_extension">
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
                                    <input type="text" id="leadgen_search_sold_author" placeholder="Search...">
                                </div>
                                </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover nowrap display" id="ListOfSoldAuthors_leadgent_datatable" width="100%"
                                    cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Emails</th>
                                            <th>Phone Numbers</th>
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



<div class="modal fade" id="add-author-modal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="editUserModalLabel">Add Sold Author</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- leads Form Fields -->
                <div class="alert alert-danger">
                    <p></p>
                </div>
                <div class="tab-content">

                    <div id="contact_person_nav" class="tab-pane fade in active show" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="save_sold_author_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="InputContact">
                                            <label for="number">Contact Number</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="text" class="form-control" name="customer_contact[]"
                                                    placeholder="Add new contact">
                                                <button type="button" class="btn btn-danger removeInputField"><i
                                                        class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" id="addContactField" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">

                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputfieldemail">
                                            <label for="email">Email Address</label>
                                            <div class="mb-3 field-container d-flex gap-1">
                                                <input type="email" class="form-control" name="customer_email[]"
                                                    placeholder="Add new email address">
                                                <button type="button" class="btn btn-danger removeinputfieldemail"><i
                                                        class="ti ti-trash"></i></button>

                                            </div>
                                        </div>
                                        <button type="button" id="addMoreEmail" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>

                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="add_sold_author" class="btn btn-primary">Add</button>

                    </div>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="editsoldauthor" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Sold Author</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- leads Form Fields -->
                <div class="alert alert-danger">
                    <p></p>
                </div>
                <div class="tab-content">

                    <div id="contact_person_nav" class="tab-pane fade in active show" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="edit_sold_author_form" class="view_sold_author">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control full_name" id="customer_name" name="customer_name"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields8">
                                            <label for="number">Contact Number</label>
                                            <div class="mb-3 ">

                                                <div class="customer_contact_details"> </div>
                                                <input type="hidden" class="form-control" name="sold_author_id"
                                                    readonly>
                                            </div>
                                        </div>
                                        <button type="button" id="addMoreContact8" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>

                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <div id="dynamicForm">
                                        <div id="inputFields7">
                                            <label for="email">Email Address</label>
                                            <div class="mb-3 ">

                                                <div class="customer_email_details"></div>

                                            </div>
                                        </div>
                                        <button type="button" id="addMore7" class="btn btn-primary"><i
                                                class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="edit_sold_author" class="btn btn-primary">Save Changes</button>

                    </div>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>