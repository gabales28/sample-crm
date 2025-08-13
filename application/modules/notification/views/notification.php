
<div class="pc-container">
<div class="pc-content">
<div class="main-card-container">
    <div class="table-container">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Notifications</h6>
                <!-- Button trigger modal for Add User -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-hover nowrap display" width="20%" cellspacing="0">
                    <tbody>
                        <?php  if($view_all_notifications > 0):?>
                            <?php foreach($view_all_notifications as $view_all_notifications): ?>
                          <tr>
                            <td><img src="https://www.pikpng.com/pngl/m/108-1083508_facebook-notification-icon-vector-wwwimgkidcom-the-logo-linkedin.png" class="img-circle" style="width:70px;height:70px;"></td>
                            <td><h6><?php echo $view_all_notifications['user_charge']." - ".$view_all_notifications['remarks']." - ". modules::run("activity/timeAgo",$view_all_notifications['date_added']);?></h6></a></td>
                          </tr>
                            <?php endforeach;?>
                          <?php endif;?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>



