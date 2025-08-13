<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">List of Sold Authors</h6>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="ListOfSoldAuthors_datatable" width="100%"
                                cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Phone Numbers</th>
                                        <th>Emails</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if ($get_authors_data > 0):
                                        $n = 1;
                                        $phone_number = "";
                                        $email = ""; ?>
                                        <?php foreach ($get_authors_data as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['full_name']); ?></td>
                                                <td><?php echo ucwords($row['email']); ?></td>
                                                <td><?php echo ucwords($row['phone_number']); ?></td>
                                                <td>
                                                    <!-- Button to trigger Edit Task Modal -->
                                                    <button type="button" class="btn btn-md btn-danger edit_agent_task"
                                                        data-sold_author_id="<?php echo $row['sold_author_id']; ?>"
                                                        data-toggle="modal" data-target="#editlistoftask">Edit
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

<!-- lead end -->

<div class="modal fade" id="Add_newsold_author" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
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
                <div class="tab-content">

                    <div id="contact_person_nav" class="tab-pane fade in active show" role="tabpanel"
                        aria-labelledby="pills-contact-tab">
                        <form id="save_sold_author_form">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="customer_name"
                                        placeholder="Enter name">
                                </div>
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
                            </div>
                            <div class="form-row mb-3">

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
 
