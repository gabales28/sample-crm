 <!-- [ Sidebar Menu ] start -->
 <nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="<?php echo site_url('dashboard/agent');?>" class="b-brand">
        <!-- ========   Change your logo from here   ============ -->
        <img src="<?php echo base_url('assets/images/nimlogo.jpg');?>" alt="" width="180px" height="45px" class="logo logo-lg" />
        </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Dashboard</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('dashboard/agent');?>" class="pc-link"><span class="pc-micon text-dark"><i class="ti ti-dashboard"></i></span><span
              class="pc-mtext text-dark">Dashboard</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('agent/Lead_Agent');?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-database"></i></span><span class="pc-mtext text-dark">Leads</span></a>
        </li>
      
        <li class="pc-item">
          <a href="<?php echo site_url('agent/view_lead_agent');?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-database"></i></span><span class="pc-mtext text-dark">Tasks</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('sold_author/sold_authoragent');?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-database"></i></span><span class="pc-mtext text-dark">Sold Author</span></a>
        </li>
        <li class="pc-item">
          <a href="<?php echo site_url('ringcentral/call_logs_agent');?>" class="pc-link"><span class="pc-micon text-dark">
          <i class="ti ti-database"></i></span><span class="pc-mtext text-dark">Call Logs</span></a>
        </li>

        </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
