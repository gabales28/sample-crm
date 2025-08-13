<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="index.html" class="b-brand">
        <!-- ========   Change your logo from here   ============ -->
        <img src="<?php echo base_url('assets/images/nimlogo.jpg'); ?>" alt="" width="180px" height="45px"
          class="logo logo-lg" />
      </a>
    </div>
    <div class="navbar-content" style="background-color:teal;">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Dashboard</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('dashboard'); ?>" class="pc-link"><span class="pc-micon"><i
                class="ti ti-dashboard"></i></span><span class="pc-mtext">Dashboard</span></a>
        </li>
        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-database"></i></span><span
              class="pc-mtext">Leads</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('leads'); ?>">Leads/Bucket</a></li>
            <!-- <li class="pc-item"><a class="pc-link"  href="../pages/register-v3.html">Collection Leads</a></li> -->
          </ul>
        </li>
        <!-- <li class="pc-item">
          <a href="<?php echo site_url('tasks'); ?>" class="pc-link"><span class="pc-micon">
          <i class="ti ti-clipboard-check"></i></span><span class="pc-mtext">Tasks</span></a>
        </li> -->


        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="fa-solid fa-list-check"></i></span><span
              class="pc-mtext">Tasks</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('tasks'); ?>">Agent & Lead Gen.</a></li>
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('tasks/agents'); ?>">Agent </a></li>

          </ul>
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-database"></i></span><span
              class="pc-mtext">Assign</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <!-- <li class="pc-item"><a class="pc-link"  href="<?php echo site_url('tasks'); ?>">Task</a></li> -->
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('tasks/leadgent'); ?>">Leads - Lead Gen.
              </a></li>
            <!-- <li class="pc-item"><a class="pc-link"  href="<?php echo site_url('tasks/agents'); ?>">Agent </a></li> -->
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('tasks/sales_Leadgent'); ?>">Lead Gen. -
                Agent </a></li>

          </ul>
        </li>

        
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-database"></i></span><span
              class="pc-mtext">Previous Agent Leads</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item">
              <a href="<?php echo site_url('recycle/recycled_leads'); ?>" class="pc-link"><span class="pc-micon"><i
                    class="ti ti-recycle"></i></span><span class="pc-mtext">Recycle</span></a>
            </li>
            <li class="pc-item">
              <a href="<?php echo site_url('recycle'); ?>" class="pc-link"><span class="pc-micon"><i
                    class="ti ti-recycle"></i></span><span class="pc-mtext">Pipe and Sold</span></a>
            </li>
          </ul>
        
          <li class="pc-item">
          <a href="<?php echo site_url('ringcentral/call_logs'); ?>" class="pc-link"><span class="pc-micon"><i
                class="ti ti-phone"></i></span><span class="pc-mtext">Call Logs</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("sold_author/sold_authors");?>" class="pc-link"><span class="pc-micon">
          <i class="fa-solid fa-user-check"></i></span><span class="pc-mtexta">Sold Authors</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('leads/Trash_Leads'); ?>" class="pc-link"><span class="pc-micon"><i
                class="ti ti-trash"></i></span><span class="pc-mtext">Trash Leads</span></a>
        </li>
        <li class="pc-item pc-caption">
          <label>Accounts</label>
          <i class="ti ti-apps"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="fa-solid fa-users"></i></span><span
              class="pc-mtext">Users</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item">
              <a href="<?php echo site_url('account/users'); ?>" class="pc-link"><span class="pc-mtext">Users</span></a>
            </li>
            <li class="pc-item">
              <a href="<?php echo site_url('account/user_logs'); ?>" class="pc-link"><span class="pc-mtext">Users
                  Log</span></a>
            </li>
          </ul>
        </li>



      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->