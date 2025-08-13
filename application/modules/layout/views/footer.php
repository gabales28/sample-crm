<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0">Copyright &copy; <a href="#" target="_blank">Nimbus Digital Marketing</a></p>
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="#" target="_blank">Home</a></li>
                    <li class="list-inline-item"><a href="#" target="_blank">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#" target="_blank">Contact us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="adduserform" method="POST">
                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add User Form Fields -->

                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="FirstName">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="fname" required placeholder="Enter first name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="LastName">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="lname" required placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userPhone">Phone Number</label>
                            <input type="text" class="form-control" id="userPhone" name="contact" required placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phonenumber">RC Number</label>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" required placeholder="Enter RingCentral Number">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userEmail">Email Address</label>
                            <input type="email" class="form-control" id="userEmail" name="email_address" required placeholder="Enter email address">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="username" required placeholder="Enter username">
                        </div>

                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userType">User Type</label>
                            <select class="form-control" id="userType" name="usertype" required>
                                <option value="" disabled selected>Select user type</option>
                                <option value="Admin">Admin</option>
                                <option value="Lead Gen.">Lead Gen</option>
                                <option value="Sales Trainee">Sales Trainee</option>
                                <option value="Sales Prospecting">Sales Prospecting</option>
                                <option value="Sales Tier 1">Sales Tier 1</option>
                                <option value="Sales Tier 2">Sales Tier 2</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userStatus">Status</label>
                            <select class="form-control" id="editUserType" name="status" required>
                                <option value="" disabled selected>Select user status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="UserQuota">Sales Quota</label>
                            <input type="text" class="form-control" id="UserQuota" name="UserQuota" placeholder="Enter sales quota">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userAddress">Address</label>
                            <textarea class="form-control" rows="3" id="address" required name="address"></textarea>

                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" value="Add" class="btn btn-primary">
            </div>
            </form>

        </div>
    </div>
</div>


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edituserform" class="edituserform">
                    <!-- Edit User Form Fields -->
                    <div class="alert alert-danger">
                        <p></p>
                    </div>
                    <!-- Add User Form Fields -->

                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="FirstName">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="fname" required placeholder="Enter first name">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="LastName">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="lname" required placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userPhone">Phone Number</label>
                            <input type="text" class="form-control" id="userPhone" name="contact" required placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phonenumber">RC Number</label>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" required placeholder="Enter RingCentral Number">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userEmail">Email Address</label>
                            <input type="email" class="form-control" id="userEmail" name="email_address" required placeholder="Enter email address">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="username" required placeholder="Enter username">
                        </div>

                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userType">User Type</label>
                            <select class="form-control usertype" id="userType" name="usertype" required>
                                <option value="" disabled selected>Select user type</option>
                                <option value="Admin">Admin</option>
                                <option value="Lead Gen.">Lead Gen.</option>
                                <option value="Sales Trainee">Sales Trainee</option>
                                <option value="Sales Prospecting">Sales Prospecting</option>
                                <option value="Sales Tier 1">Sales Tier 1</option>
                                <option value="Sales Tier 2">Sales Tier 2</option>
                            </select>
                            <input type="hidden" readonly class="form-control" id="ID" name="user_id">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userStatus">Status</label>
                            <select class="form-control status" id="editUserType" name="status" required>
                                <option value="" disabled selected>Select user status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="UserQuota">Sales Quota</label>
                            <input type="text" class="form-control" id="UserQuota" name="UserQuota" placeholder="Enter sales quota">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userAddress">Address</label>
                            <textarea class="form-control address" rows="3" id="address" required name="address"></textarea>

                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" value="Save Change" class="btn btn-primary">

            </div>
            </form>
        </div>
    </div>
</div>
<!-- user modal -->


<div class="modal fade bd-example-modal-lg loadingModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>


<div class="modal fade" id="activityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lead Activities</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="activitiesdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>User In Charged</th>
                                    <th>Remarks</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                            <tbody class="lead_activity_detail">

                            </tbody>
                        </table>
                    </div>
                </div>
                Notes
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="notesdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>User In Charged</th>
                                    <th>Notes</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                            <tbody class="notes_detail">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<!-- Modal Structure -->
<div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userProfile_form" class="userProfile_form">
                    <div class="alert alert-success">
                        <p></p>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Contact Number</label>
                            <input type="tel" class="form-control" id="contact" name="contact" placeholder="Phone Number" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control address" id="address" name="address" rows="3" placeholder="Address" readonly></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" id="update_profile" class="btn btn-primary">Save changes</button> -->
                <!-- <input type="submit" value="Save Change" class="btn btn-primary"> -->
            </div>
        </div>
    </div>
</div>


<div id="dialog" title="Confirm Saving">
    <p>Are you sure you want to save this note?</p>
</div>

<div id="agentdialog" title="Confirm Saving">
    <p>Are you sure you want to reset this data?</p>
</div>

<div id="return-lead-dialog" title="Confirm Saving">
    <p>Are you sure you want to return the lead?</p>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmLogout">Logout</button>
            </div>
        </div>
    </div>
</div>


<!-- Required Js -->


<!-- Boostrap Modal Pop-Up -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<script>
    var base_url = "<?php echo base_url(); ?>";
    var site_url = "<?php echo site_url(); ?>";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="<?php echo base_url('datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>



<script src="<?php echo base_url('vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery-3.6.1.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery-1.10.2.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.7.1.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.5.1.slim.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery_2/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-ui.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/dataTables.fixedColumns.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/fixedColumns.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/sweetalert.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/moment-with-locales.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('bootstrap/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('bootstrap/vendors/moment/min/moment-timezone-with-data.min.js'); ?>"></script> -->
<script src="<?php echo base_url('datepicker/js/daterangepicker.js'); ?>"></script>



<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script> -->
<!-- <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script> -->

<script src="<?php echo base_url('assets/js/plugins/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/simplebar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/config.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pcoded.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/plugins/apexcharts.min.js'); ?>"></script>
<!-- <script src="<?php echo base_url('assets/js/pages/dashboard-default.js'); ?>"></script> -->

<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/vendor/bootstrap-datetimepicker/js/demo.js'); ?>"></script>


<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/simplebar.min.js'); ?>"></script>
<script src="<?php echo base_url('js/validatedaterangepicker.js'); ?>"></script>


<script src="<?php echo base_url('assets/js/config.js'); ?>"></script>
<!-- <script src="<?php echo base_url('assets/js/pcoded.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/vendor/DataTables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('inputpicker/jquery.inputpicker.js'); ?>"></script>
<script src="<?php echo base_url('js/validateactivity.js'); ?>"></script>
<script src="<?php echo base_url('js/validateuser.js'); ?>"></script>
<script src="<?php echo base_url('js/validatelead.js'); ?>"></script>
<script src="<?php echo base_url('js/validatetask.js'); ?>"></script>
<script src="<?php echo base_url('js/validateleadgenttask.js'); ?>"></script>
<script src="<?php echo base_url('js/validateappointment.js'); ?>"></script>
<script src="<?php echo base_url('js/validateagent.js'); ?>"></script>
<script src="<?php echo base_url('js/validatesalesleadgent.js'); ?>"></script>
<script src="<?php echo base_url('js/validatesagenttask.js'); ?>"></script>
<script src="<?php echo base_url('js/validatesremark.js'); ?>"></script>
<script src="<?php echo base_url('js/validatenotification.js'); ?>"></script>
<script src="<?php echo base_url('js/validatesoldauthors.js'); ?>"></script>



<script>
    $(document).ready(function() {
        $('.OpenModal').on('click', function() {
            $('#activityModal').addClass('slide-right');
            $('#activityModal').modal('show');
        });

    });
    var get_lead_id = '<?php echo $lead_id; ?>';
    var get_lead_status = '<?php echo $lead_status; ?>';


    $('#taskdatatable').DataTable().ajax.url(base_url + 'tasks/fetch_lead_limit_data?lead_id=' + get_lead_id).load();
    // $('#leadgentdatatable').DataTable().ajax.url(base_url + 'Leads/fetch_lead_limit_leadgent_data?lead_id=' + get_lead_id).load();
    $('#taskagentdatatable').DataTable().ajax.url(base_url + 'tasks/fetch_lead_agent_task_limit_data?lead_id=' + get_lead_id).load();

    $('#agentsdatatable').DataTable().ajax.url(base_url + 'leads/fetch_lead_limit_agent_data?lead_id=' + get_lead_id).load();

    $('#my_leads_leadgentdatatable').DataTable().ajax.url(base_url + 'leads/fetch_leadgen_limit_data?lead_status=' + get_lead_status).load();
    

</script>

<script>
    function updateOnlineStatus() {
        const notification = document.getElementById('notifications');
        if (navigator.onLine) {
            notification.style.display = 'none';
        } else {
            notification.style.display = 'block';
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    // Initial check
    updateOnlineStatus();
</script>

</body>
<!-- [Body] end -->
 

</html>