 <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-xl-4 col-md-4">
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
          
                    </div>
                  </div>
                </div>
                <span class="text-white d-block f-34 f-w-500 my-2"><?=$total_leads;?>  <i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                <p class="mb-0 opacity-50">Total Leads</p>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-4">
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
                   
                  </div>
                </div>
                <div class="tab-content" id="chart-tab-tabContent">
                  <div class="tab-pane show active" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                    <div class="row">
                      <div class="col-6">
                        <span class="text-white d-block f-34 f-w-500 my-2"><?=$total_deals_month;?><i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Sold Leads</p>
                      </div>
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-10">
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
                        <span class="text-white d-block f-34 fw-bold my-2">$<?php echo $sales_qouta['quota'] ? modules::run("dashboard/formatNumber",$sales_qouta['quota']) : '0.00' ?>/</span><span class="text-white d-block f-34  fw-bold">$<?php echo $total_sales['total_sales'] ? modules::run("dashboard/formatNumber",$total_sales['total_sales'])  :  '0.00' ?><i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Quota for the Month</p>
                      </div>
                    </div>
                  </div>
                
                </div>
              </div>
            </div>
          </div>
     
          <!-- Total Sales -->
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
                        <span class="text-white d-block f-34 f-w-500 my-2">
                          $<?php echo $total_sales['total_sales'] ? modules::run("dashboard/formatNumber",$total_sales['total_sales']) : '0.00' ?>
                        <i class="ti ti-arrow-up-right-circle opacity-50"></i></span>
                        <p class="mb-0 opacity-50">Total Sales</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-xl-8 col-md-12" style="width: 100%;">
            <div class="card">
              <div class="card-body">
                <div class="row mb-3 align-items-center">
                  <div class="col">
                    <small>Total Sales</small>
                    <h3>$<?php echo $total_sales ? modules::run("dashboard/formatNumber",$total_sales['total_sales'])    : 0 ?></h3>
                  </div>
                  <div class="col-auto">
                  </div>
                </div>
                <div class="agent_sales"></div>
              </div>
            </div>
          </div>












          <!-- <div class="col-xl-4 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row mb-3 align-items-center">
                  <div class="col">
                    <h4>Popular Stocks</h4>
                  </div>
                  <div class="col-auto"> </div>
                </div>
                <div class="rounded bg-light-secondary overflow-hidden mb-3">
                  <div class="px-3 pt-3">
                    <div class="row mb-1 align-items-start">
                      <div class="col">
                        <h5 class="text-secondary mb-0">Bajaj Finery</h5>
                        <small class="text-muted">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0">$1839.00</h4>
                      </div>
                    </div>
                  </div>
                  <div id="bajajchart"></div>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-0">
                    <div class="row align-items-start">
                      <div class="col">
                        <h5 class="mb-0">Bajaj Finery</h5>
                        <small class="text-success">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0"
                          >$1839.00<span class="ms-2 align-top avtar avtar-xxs bg-light-success"
                            ><i class="ti ti-chevron-up text-success"></i></span
                        ></h4>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item px-0">
                    <div class="row align-items-start">
                      <div class="col">
                        <h5 class="mb-0">TTML</h5>
                        <small class="text-danger">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0"
                          >$100.00<span class="ms-2 align-top avtar avtar-xxs bg-light-danger"
                            ><i class="ti ti-chevron-down text-danger"></i></span
                        ></h4>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item px-0">
                    <div class="row align-items-start">
                      <div class="col">
                        <h5 class="mb-0">Reliance</h5>
                        <small class="text-success">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0"
                          >$200.00<span class="ms-2 align-top avtar avtar-xxs bg-light-success"
                            ><i class="ti ti-chevron-up text-success"></i></span
                        ></h4>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item px-0">
                    <div class="row align-items-start">
                      <div class="col">
                        <h5 class="mb-0">TTML</h5>
                        <small class="text-danger">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0"
                          >$189.00<span class="ms-2 align-top avtar avtar-xxs bg-light-danger"
                            ><i class="ti ti-chevron-down text-danger"></i></span
                        ></h4>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item px-0">
                    <div class="row align-items-start">
                      <div class="col">
                        <h5 class="mb-0">Stolon</h5>
                        <small class="text-danger">10% Profit</small>
                      </div>
                      <div class="col-auto">
                        <h4 class="mb-0"
                          >$189.00<span class="ms-2 align-top avtar avtar-xxs bg-light-danger"
                            ><i class="ti ti-chevron-down text-danger"></i></span
                        ></h4>
                      </div>
                    </div>
                  </li>
                </ul>
                <div class="text-center">
                  <a href="#!" class="b-b-primary text-primary">View all <i class="ti ti-chevron-right"></i></a>
                </div>
              </div>
            </div>
          </div> -->
          <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <!-- [ Main Content ] end -->
   