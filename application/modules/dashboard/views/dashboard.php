 <!-- [ Main Content ] start -->
 <div class="pc-container">
      <div class="pc-content">
        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-xl-4 col-md-6">
            <div class="card bg-secondary-dark dashnum-card text-white overflow-hidden">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-auto">
                    <div class="btn-group">
                      <!-- <a
                        type="button"
                        class="avtar bg-secondary dropdown-toggle arrow-none"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="ti ti-dots"></i>
                      </a> -->
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" type="button">Import Card</button></li>
                        <li><button class="dropdown-item" type="button">Export</button></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2"><span class="total_leads"><?=$total_leads;?></span> <i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                <p class="mb-0 opacity-50">Total Leads</p>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6">
            <div class="card bg-primary-dark dashnum-card text-white overflow-hidden">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-auto">
                    <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button
                          class="nav-link text-white active"
                          id="chart-tab-home-tab"
                          data-bs-toggle="pill"
                          data-bs-target="#chart-tab-home"
                          type="button"
                          role="tab"
                          aria-controls="chart-tab-home"
                          aria-selected="true"
                          >Month</button
                        >
                      </li>
                  
                    </ul>
                  </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-12 ">
                        <span class="text-white d-block f-34 f-w-500 my-2 sales_qouta">
                          $<?php echo $agent_qouta['total_qouta'] ?  modules::run("dashboard/formatNumber",$agent_qouta['total_qouta']) : '0.00' ?>
                        /<span><span class="text-white d-block f-34 f-w-500 ">$<?php echo $total_sales['total_sales'] ? modules::run("dashboard/formatNumber",$total_sales['total_sales']) : '0.00' ?>
                      <i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Qouta for the Month</p>
                      </div>
                      <div class="col-5">
                        <!-- <div id="tab-chart-1">
                          
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6">
            <div class="card bg-info dashnum-card text-white overflow-hidden">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-target"></i>
                    </div>
                  </div>
                  
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-10">
                        <span class="text-white d-block f-34 f-w-500 my-2"><span class="total_deals_month"><?=$total_deals_month;?></span><i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Sold Leads</p>
                      </div>
                      <div class="col-6">
                      </div>
                    </div>
                  </div>
                
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6">
            <div class="card dashnum-card text-white overflow-hidden" style="background-color: var(--teal);">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-credit-card"></i>
                    </div>
                  </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-10">
                        <span class="text-white d-block f-34 f-w-500 my-2">$<span class="total_sales"><?php echo $total_sales['total_sales'] ? modules::run("dashboard/formatNumber",$total_sales['total_sales']) : '0.00' ?></span><i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Total Sales</p>
                      </div>
                      <div class="col-3">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6">
            <div class="card dashnum-card text-white overflow-hidden" style="background-color: var(--gray);">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-user"></i>
                    </div>
                  </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-10">
                        <span class="text-white d-block f-34 f-w-500 my-2"><?=$all_sales;?><i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Active Agents</p>
                      </div>
                      <div class="col-6">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-xl-4 col-md-6">
            <div class="card bg-success dashnum-card text-white overflow-hidden">
              <span class="round small"></span>
              <span class="round big"></span>
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <div class="avtar avtar-lg">
                      <i class="text-white ti ti-files"></i>
                    </div>
                  </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-15">
                     <span class="text-white d-block f-22 f-w-500 my-2 mb-4">Closed Sale Response</span>
                     <a href="https://docs.google.com/spreadsheets/d/1Itfq9tqxCx4tdPtkXrpJ-sv0gKKw18LphNGmiOHN6k4/edit?resourcekey=&gid=1075856199#gid=1075856199" target="_blank" class="text-white ">
                       <p class="mb-0 opacity-50">View Google Sheet <i class="ti ti-arrow-right opacity-50"></i></p>
                     </a>
                   </div>
                   <div class="col-5">
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div> -->

        <div class="col-xl-8 col-md-12" style="width: 100%;">
            <div class="card">
              <div class="card-body">
                <div class="row mb-3 align-items-center">
                  <div class="col">
                    <small>Total Sales</small>
                    <h3>$<span class="total_sales"><?php echo $total_sales['total_sales'] ? modules::run("dashboard/formatNumber",$total_sales['total_sales']) : 0 ?>
                    </h3>
                  </div>
                  <div class="col-auto">
                    <!-- <select class="form-select p-r-35">
                      <option>Today</option>
                      <option selected>This Month</option>
                      <option>This Year</option>
                    </select> -->
                  </div>
                </div>
                <div class="growthchart"></div>
              </div>
            </div>
          </div> 
      
    
       <div class="col-xl-4 col-md-12">
         <div class="card">
          <div class="header_top rounded-top">
          <div class="user_online ">
             <h3>Users Online</h3>
           </div>
          </div>
           <div class="card-body">
            <div class="container_online">
            <?php if ($online_users > 0): $n = 1; ?>
            <?php foreach ($online_users as $row): ?>
              <div class="online_users">
                <div class="name_user">
                  <div class="img_user">
                    <img src="<?php echo base_url('assets/images/user/img_avatar.png '); ?>" alt="user-image" class="user-avtar" />
                  </div>
                  <div class="name_details">
                    <h2><?php echo ucwords($row['fname'] . ' ' . $row['lname']); ?></h2>
                    <span><?php echo modules::run("activity/timeAgo",$row['date_login']);?></span>
                  </div>
                </div>
                <div class="online_status">
                  <div></div>
                </div>
              </div>
             <?php endforeach; ?>
             <?php endif; ?>
            </div>
           </div>
           
         </div>
       </div>

       

       <!-- [ sample-page ] end -->
     </div>
     <!-- [ Main Content ] end -->
   </div>
 </div>
 <!-- [ Main Content ] end -->