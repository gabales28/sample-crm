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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="adduserform">
                    <!-- Add User Form Fields -->
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="FirstName">First Name</label>
                            <input type="text" class="form-control" id="FirstName" name="fname" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="LastName">Last Name</label>
                            <input type="text" class="form-control" id="LastName" name="lname" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userPhone">Phone Number</label>
                            <input type="text" class="form-control" id="userPhone" name="contact" placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userEmail">Email Address</label>
                            <input type="email" class="form-control" id="userEmail" name="email_address" placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="username" placeholder="Enter username">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userType">User Type</label>
                            <select class="form-control" id="userType" name="usertype">
                                <option value="" disabled selected>Select user type</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-0">
                        <div class="form-group col-md-6">
                            <label for="userStatus">Status</label>
                            <select class="form-control" id="editUserType" name="status">
                                <option value="" disabled selected>Select user status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="userAddress">Address</label>
                            <textarea class="form-control" rows="3" id="address" name="address"></textarea>

                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="UserQuota">Quota</label>
                            <input type="text" class="form-control" id="UserQuota" placeholder="Enter sales quota">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Edit User Form Fields -->
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="editFirstName">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editLastName">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" placeholder="Enter last name">
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="editUserPhone">Phone Number</label>
                            <input type="text" class="form-control" id="editUserPhone" placeholder="Enter phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editUserEmail">Email Address</label>
                            <input type="email" class="form-control" id="editUserEmail" placeholder="Enter email address">
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" placeholder="Enter username">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editUserType">User Type</label>
                            <select class="form-control" id="editUserType">
                                <option value="" disabled selected>Select user type</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="editUserStatus">Status</label>
                            <select class="form-control" id="editUserType">
                                <option value="" disabled selected>Select user status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editUserAddress">Address</label>
                            <input type="text" class="form-control" id="editUserAddress" placeholder="Enter address">
                        </div>
                    </div>
                    <div class="form-row mb-3">
                        <div class="form-group col-md-6">
                            <label for="editUserQuota">Quota</label>
                            <input type="text" class="form-control" id="editUserQuota" placeholder="Enter sales quota">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


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

<div class="modal fade bd-example-modal-lg loadingModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
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
</script>


<script src="<?php echo base_url('vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery-3.6.1.min.js'); ?>"></script>
<script src="<?php echo base_url('vendor/jquery/jquery-1.10.2.js'); ?>"></script>

<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery_1/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.5.1.slim.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/dataTables.fixedColumns.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/fixedColumns.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/jquery-3.7.1.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/jquery/sweetalert.min.js'); ?>"></script>



<!-- <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script> -->
<!-- [Page Specific JS] start -->
<!-- Apex Chart -->
<script src="<?php echo base_url('assets/js/plugins/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/simplebar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/config.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pcoded.js'); ?>"></script>

<script src="<?php echo base_url('assets/js/plugins/apexcharts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/pages/dashboard-default.js'); ?>"></script>
<!-- [Page Specific JS] end -->

<!-- jQuery and Bootstrap JS -->
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>


<script src="<?php echo base_url('js/validateuser.js');?>"></script>
<script src="<?php echo base_url('js/validatenotification.js');?>"></script> 
<script src="<?php echo base_url('js/validatetask.js');?>"></script>
<script src="<?php echo base_url('js/validatedashboard.js');?>"></script>

<script>
    function renderChart(data) {
    var options = {
        chart: {
          type: 'bar',
          height: 480,
          stacked: true,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%'
          }
        },
        dataLabels: {
          enabled: false
        },
        colors: ['#017979'],
        series: [
          {
            name: 'Sales',
            data: data
          },
    
        ],
        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
              }
            }
          }
        ],
        xaxis: {
          type: 'category',
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        grid: {
          strokeDashArray: 4
        },
        tooltip: {
          theme: 'dark'
        }
      };
      var chart = new ApexCharts(document.querySelector('.agent_sales'), options);
      chart.render();
    }
    var payments = <?php echo $payments ? json_encode($payments) : 0; ?>;

    renderChart(payments);

    var get_lead_id = '<?php echo $lead_id ? $lead_id : 0; ?>';
    $('#taskdatatable').DataTable().ajax.url(base_url + 'tasks/fetch_lead_limit_data?lead_id=' + get_lead_id).load();
    $('#leadgentdatatable').DataTable().ajax.url(base_url + 'leads/fetch_lead_limit_leadgent_data?lead_id=' + get_lead_id).load();
    $('#agentsdatatable').DataTable().ajax.url(base_url + 'leads/fetch_lead_limit_agent_data?lead_id=' + get_lead_id).load();
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

<!-- 
<script>
  $(document).ready( function () {
    $('#userdatatable').DataTable();
} );
</script> -->


</body>
<!-- [Body] end -->

</html>