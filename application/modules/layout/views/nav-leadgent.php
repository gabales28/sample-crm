 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="<?php echo site_url('dashboard/leadgent');?>" class="b-brand">
        <!-- ========   Change your logo from here   ============ -->
        <img src="<?php echo base_url('assets/images/nimlogo.jpg');?>" alt="" width="180px" height="45px" class="logo logo-lg" />
      </a>
    </div>
    <div class="navbar-content bg-info">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Dashboard</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('dashboard/leadgent');?>" class="pc-link"><span class="pc-micon text-dark"><i class="ti ti-dashboard"></i></span><span
              class="pc-mtext text-dark">Dashboard</span></a>
        </li>

        <!-- <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-database"></i></span><span
              class="pc-mtext">Leads</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?php echo site_url('leadgent');?>">Leads/Bucket</a></li>
           \ <li class="pc-item"><a class="pc-link" href="../pages/register-v3.html">Collection Leads</a></li> -->
          <!-- </ul>
        </li> -->
        <li class="pc-item">
          <a href="<?php echo site_url('leadgent');?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-database"></i></span><span class="pc-mtext text-dark">Leads</span></a>
        </li>

        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon text-dark"><i class="ti ti-database"></i></span><span
              class="pc-mtext text-dark">Assign</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
          <!-- <li class="pc-item">
            <a href="<?php echo site_url('tasks/sales_agents');?>" class="pc-link"><span class="pc-micon text-dark">
            <i class="fa-solid fa-clipboard-check"></i></span><span class="pc-mtext text-dark">Tasks</span></a>
            </li> -->
            <li class="pc-item">
            <a href="<?php echo site_url('leadgent/View_Sales_Tasks');?>" class="pc-link"><span class="pc-micon text-dark">
            <i class="fa-solid fa-clipboard-check"></i></span><span class="pc-mtext text-dark">Tasks</span></a>
            </li>
            <li class="pc-item">
            <a href="<?php echo site_url('leadgent/sales_agent');?>" class="pc-link"><span class="pc-micon text-dark">
            <i class="fa-solid fa-user-group"></i></span><span class="pc-mtext text-dark">Agent</span></a>
            </li>
          </ul>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("sold_author/sold_author");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-user-check"></i></span><span class="pc-mtext text-dark">Sold Authors</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/LeadGen_Trash_Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-trash"></i></span><span class="pc-mtext text-dark">Deleted Leads</span></a>
        </li>
        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Mined Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-user-check"></i></span><span class="pc-mtext text-dark">Mined Leads</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Active Lead");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-toggle-on"></i></span><span class="pc-mtext text-dark">Active Leads</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Inactive Lead");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-toggle-off"></i></span><span class="pc-mtext text-dark">Inactive Leads</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Active Email");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-square-envelope"></i></span><span class="pc-mtext text-dark">Active Email</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Confirmed Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-circle-check"></i></span><span class="pc-mtext text-dark">Confirmed Leads</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Need to Confirm");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-regular fa-circle-check"></i></span><span class="pc-mtext text-dark">Need to Confirm</span></a>
        </li>
        <!-- <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Unconfirmed");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-circle-exclamation"></i></span><span class="pc-mtext text-dark">Unconfirmed</span></a>
        </li> -->
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Voice Mail Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-voicemail"></i></span><span class="pc-mtext text-dark">Voice Mail Leads</span></a>
        </li>
        <!-- <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Distributed Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-share-from-square"></i></span><span class="pc-mtext text-dark">Distributed Leads</span></a>
        </li> -->
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Disconnected");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="bi bi-telephone-x-fill"></i></span><span class="pc-mtext text-dark">Disconnected</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Wrong Email and Phone");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-square-xmark"></i></span><span class="pc-mtext text-dark">Wrong Email and Phone</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Special Leads");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-wand-magic-sparkles"></i></span><span class="pc-mtext text-dark">Special Leads</span></a>
        </li>
        <!-- <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Filtered Confirmed No.");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-list"></i></span><span class="pc-mtext text-dark">Filtered Confirmed No.</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Active Clients");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-users"></i></span><span class="pc-mtext text-dark">Active Clients</span></a>
        </li> -->
        <li class="pc-item">
          <a href="<?php echo site_url("leadgent/leads?status_lead=Deceased");?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="fa-solid fa-users-slash"></i></span><span class="pc-mtext text-dark">Deceased</span></a>
        </li>


        </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
