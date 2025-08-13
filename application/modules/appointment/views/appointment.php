<div class="pc-container">
<div class="pc-content">

<div class="main-card-container">
        <div class="table-container">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Appointments</h6>
                    <!-- Button trigger modal for Add lEAD -->
                    
                    <div class="d-flex justify-content-end align-items-center">
                 
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AppointmentModal">Add Appointment</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover nowrap display" id="appointmentdatatable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Asigned to</th>
                                    <th>Appointment Status</th>
                                    <th>Appointment Remarks</th>
                                    <th>Appointment Schedule</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tableApp > 0): $n = 1; $customer_contact = ""; $customer_email = ""; ?>
                                    <?php foreach ($tableApp as $row): ?>
                                            <td><?php echo $n++; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo ucwords($row['fname'].' '.$row['lname']);?></td>
                                            <td><?php echo $row['appointment_status']; ?></td>
                                            <td><?php echo $row['appointment_remarks']; ?></td>
                                            <td><?php echo $row['appointment_schedule']; ?></td>
                                            <td><?php echo date('g:i A', strtotime($row['start_time'])); ?></td> <!-- Convert start_time to 12-hour format -->
                                            <td><?php echo date('g:i A', strtotime($row['end_time'])); ?></td> <!-- Convert end_time to 12-hour format -->
                                            <td>
                                                <!-- Button to trigger Edit User Modal -->
                                                <button type="button" class="btn btn-md btn-danger edit_appointment" data-appointment_id="<?php echo $row['appointment_id']; ?>" data-toggle="modal" data-target="#editAppointmentModal">Edit</button>
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

        <!-- Add Appointment Modal -->
                 <div class="modal fade" id="AppointmentModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Add Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <!-- Appointment Form Fields -->                                   
                                    <form id="appointment_form">  
                                    <div class="alert alert-success"><p></p></div> 
                                            <div class="form-row mb-3">
                                                <div class="form-group col-md-6">
                                                    <label for="title_app">Title</label>
                                                    <input type="text" class="form-control appointment-title title" value="0" name="title"/>
                                                  
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="assigned_to_app">Assigned to</label>
                                                    <select class="form-control assign_to" name="assign_to" required id="assign_to">
                                                        <option disabled selected>Select a Sales</option>
                                                        <?php foreach ($leadgent_users as $key => $user):?>
                                                           <option value="<?=$user['user_id'];?>"><?php echo ucwords($user['fname'].' '.$user['lname']);?></option>
                                                           <?php endforeach;?>
                                                    </select>  
                                                    <input type="hidden" readonly class="form-control" id="appointment_id" name="appointment_id">                                          
                                                </div>
                                            </div>                                           
                                            <div class="form-row mb-3">
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="appointment_schedule">Appointment Schedule</label>
                                                    <div class="input-group date" id="">
                                                        <input type="date" name="appointment_schedule" id="appointment_schedule"  placeholder="Add appointment schedule" class="form-control" required/>
                                                        <span class="input-group-addon">
                                                            <!-- <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> -->
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="start_time">Start Time</label>
                                                    <div class="input-group gap-1">
                                                        <select id="start_time" name="start_time" required class="form-control">
                                                            
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="form-row mb-3">
                                                    <div class="form-group col-md-6">
                                                        <label for="end_time">End Time</label>
                                                        <div class="input-group gap-1">
                                                            <select id="end_time" name="end_time" required class="form-control">
                                                                
                                                            </select>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                            <label for="appointment_remarks">Remarks</label>
                                                            <textarea class="form-control appointment_remarks" rows="3" id="appointment_remarks" required name="appointment_remarks" placeholder="Add remarks"></textarea>
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
                <!--Add appointment end -->


<!-- Edit Appointment Modal -->

<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Appointment Form Fields -->
                    <form id="Editappointment_form" class="Editappointment_form">
                        <div class="alert alert-success">
                            <p></p>
                        </div>
                        <div class="form-row">
                       

                            <div class="form-group col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control appointment-title2 titleApp" value="<?php echo $row ['title']?>"  name="title" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="assign_to">Assigned to</label>
                                <select class="form-control assign_to" name="assign_to" required id="assign_to">
                                    <option value="" selected>Select a Sales</option>
                                    <?php foreach ($leadgent_users as $key => $user):?>
                                    <option value="<?=$user['user_id'];?>">
                                        <?php echo ucwords($user['fname'].' '.$user['lname']);?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="appointment_status">Appointment Status</label>
                                <select class="form-control appointment_status" name="appointment_status"
                                    id="appointment_status">
                                    <option value="" disabled selected>Select a Status</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="appointment_schedule">Appointment Schedule</label>
                                <div class="input-group date" id="">
                                    <input type="date" name="appointment_schedule" id="appointment_schedule" class="form-control"
                                        placeholder="Enter schedule" />
                                    <span class="input-group-addon">
                                        <!-- <i class="glyphicon glyphicon-calendar fa fa-calendar"></i> -->
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="start_time">Start Time</label>
                                <select id="start_time" name="start_time" required class="start_time form-control">
                                
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_time">End Time</label>
                                <div class="input-group date" id="">
                                <select id="end_time" name="end_time" required class="form-control end_time">
                               
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="appointment_remarks">Remarks</label>
                                <textarea class="form-control appointment_remarks" rows="3" id="appointment_remarks"
                                    name="appointment_remarks" placeholder="Add remarks" required></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" value="Save changes" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- appointment end -->
 
         