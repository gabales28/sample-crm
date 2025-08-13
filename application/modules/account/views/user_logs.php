<div class="pc-container">
    <div class="pc-content">
        <div class="main-card-container">
            <div class="table-container">
                <div class="card shadow mb-4">

                    <div class="card-header py-3" style="display: flex; align-items: center; justify-content: space-between;">
                        <h6 class="m-0 font-weight-bold text-primary">List of Users Logs</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap display" id="userdatatable_logs" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>User IP Address</th>
                                        <th>Log date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if  ($user_id > 0 ): $n = 1; ?>
                                        <?php foreach ($user_id as $row): ?>
                                            <tr>
                                                <td><?php echo $n++; ?></td>
                                                <td><?php echo ucwords($row['fname'] . ' ' . $row['lname']); ?></td>
                                                <td><?php echo $row['ip_address'] ?></td>
                                                <td><?php echo date('Y/m/d h:i:s', strtotime($row['log_date'])); ?></td>
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