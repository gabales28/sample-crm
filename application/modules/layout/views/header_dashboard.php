<header class="pc-header">
  <div class="m-header">
    <a href="javascript::void();" class="b-brand">
      <!-- ========   change your logo hear   ============ -->
      <img src="<?php echo base_url('assets/images/nimlogo.jpg');?>" alt="" width="180px" height="45px" class="logo logo-lg" />
    </a>
    <!-- ======= Menu collapse Icon ===== -->
    <div class="pc-h-item">
      <a href="#" class="pc-head-link head-link-secondary m-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </div>
  </div>
<div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <li class="pc-h-item header-mobile-collapse">
      <a href="#" class="pc-head-link head-link-secondary ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>

    <!-- <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
        role="button" aria-haspopup="false" aria-expanded="false">
        <i class="ti ti-search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3">
          <div class="form-group mb-0 d-flex align-items-center">
            <i class="ti ti-search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here..." />
          </div>
        </form>
      </div>
    </li>  -->
    <li class="pc-h-item d-none d-md-inline-flex">
     <?php if ($this->session->userdata['userlogin']['usertype'] == "Admin" || $this->session->userdata['userlogin']['usertype'] == "Lead Gen." ):?>
      <form class="header-search">
        <select class="form-control" id="agent_user" name="agent_user" >
            <option value="" disabled="" selected="">Select an Agent</option>
            <option value="0">All</option>
              <?php if($active_sales !=false):?>
                <?php foreach($active_sales as $sales):?>
                   <option value="<?php echo $sales['user_id']; ?>"><?php echo ucfirst($sales['fname'] .' '. $sales['lname']); ?> (<?php echo ucfirst($sales['usertype']); ?>)</option>
                 <?php endforeach;?>  
              <?php endif;?>
         </select>     
      </form>
      <?php endif;?>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
      <?php if ($this->session->userdata['userlogin']['usertype'] == "Admin"):?>
    <li class="dropdown pc-h-item">
      <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0 notification-count-payment" data-bs-toggle="dropdown" href="#"
        role="button" aria-haspopup="false" aria-expanded="false">
        <i class="bi bi-credit-card-2-back-fill"><span class="badge bg-warning rounded-pill ms-1" id="notification-count-payment" style="position: absolute; right: -15px; top: 0px;"></span></i>
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <h5>Request Date Paid</h5>
        </div>
        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
          style="max-height: calc(100vh - 215px); overflow-y: auto;">
          <div class="list-group list-group-flush w-100">
            <div id="notification-list_of_payment">

            </div>
       
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="text-center py-2">
        </div>
        
      </div>
    </li>
     <?php endif;?>
    <li class="dropdown pc-h-item">
      <a class="pc-head-link head-link-secondary dropdown-toggle arrow-none me-0 notification-count" data-bs-toggle="dropdown" href="#"
        role="button" aria-haspopup="false" aria-expanded="false">
        <i class="ti ti-bell"><span class="badge bg-warning rounded-pill ms-1" id="notification-count" style="position: absolute; right: -15px; top: 0px;"></span></i>
      </a>
      <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <h5>All Notifications</h5>
        </div>
        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
          style="max-height: calc(100vh - 215px); overflow-y: auto;">
          <div class="list-group list-group-flush w-100">
            <div id="notification-list">

            </div>
       
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="text-center py-2">
          <a href="<?php echo site_url('notification') ;?>" class="link-primary">View all notifications</a>
        </div>
      </div>
    </li>
    <li class="dropdown pc-h-item header-user-profile">
      <a class="pc-head-link head-link-primary dropdown-toggle arrow-none gap-1 d-flex justify-content-evenly align-items-center" data-bs-toggle="dropdown" href="#"
        role="button" aria-haspopup="false" aria-expanded="false">
        <span  style="text-transform: uppercase;"><?php echo  $this->session->userdata['userlogin']['username'];?></span>
        <img src="<?php echo base_url('assets/images/user/avatar-2.jpg ');?>" alt="user-image" class="user-avtar"/>
       
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <h4>Hello, <span class="small text-muted"> <?php echo  $this->session->userdata['userlogin']['full_name'];?></span></h4>
          <!-- <form class="header-search">
            <i class="ti ti-search icon-search"></i>
            <input type="search" class="form-control" placeholder="Search profile options" />
          </form> -->
          <hr />
          <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 280px)">
            <!-- <hr />
            <div class="settings-block bg-light-primary rounded">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" />
                <label class="form-check-label" for="flexSwitchCheckDefault">Start DND Mode</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked />
                <label class="form-check-label" for="flexSwitchCheckChecked">Allow Notifications</label>
              </div>
            </div>
            <hr /> -->
            <a href="javascript::void();" data-toggle="modal" data-target="#userProfileModal" data-user_id=<?=$this->session->userdata['userlogin']['user_id'];?> class="dropdown-item edit_profile">
              <i class="ti ti-user"></i>
              <span>Profile</span>
            </a>
            <a href="<?php echo site_url('login/logout') ;?>" class="dropdown-item">
              <i class="ti ti-logout"></i>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div> </div>
</header>
<!-- [ Header ] end -->