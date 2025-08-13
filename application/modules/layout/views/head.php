<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>NIMBUS CRM</title>
  <!-- [Meta] -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta
    name="description"
    content="Berry is made using Bootstrap 5 design framework. Download the free admin template & use it for your project." />
  <meta name="keywords" content="Berry, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template" />
  <meta name="author" content="CodedThemes" />

  <!-- [Favicon] icon -->
  <link rel="icon" href="<?php echo base_url('assets/images/Nimbus-fav1.png'); ?>">
  <!-- [Google Font] Family -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" />
  <!-- [Tabler Icons] https://tablericons.com -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fonts/tabler-icons.min.css'); ?>" />
  <!-- [Material Icons] https://fonts.google.com/icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fonts/material.css'); ?>" />
  <!-- [Template CSS Files] -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" id="main-style-link" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style-preset.css'); ?>" id="preset-style-link" />
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fontawesome/css/all.css'); ?>"/>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

  <link href="<?php echo base_url('public/css/style.css'); ?>" rel="stylesheet" />

  <link rel="shortcut icon" href="<?php echo base_url('assets/images/fav.png'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/loginstyle.css'); ?>"> -->
  <link href="<?php echo base_url('assets/vendor/DataTables/datatables.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('inputpicker/jquery.inputpicker.css'); ?>" rel="stylesheet">
  <!-- Tempus Dominus Bootstrap 4 CSS (datetimepicker) -->
  <link href="<?php echo base_url('assets/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" type="text/css" media="all" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.dataTables.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('datepicker/css/daterangepicker.css'); ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="<?php echo base_url('css/select2.min.css'); ?>" rel="stylesheet">
  <style>
    .alert {
      display: none;
    }

    .select2-container .select2-selection--single {
      height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 35px !important
    }

    .select2-container--open .select2-dropdown--below {
      width: 370px !important;
    }

    /* .select2-container {
      width: 30px !important;
    } */

    .inputpicker-overflow-hidden {
      overflow: inherit !important;
    }

    .inputpicker-arrow {
      top: 7px !important;
    }

    #addtaskform .inputpicker-div {
      width: 100% !important;
    }

    #appointment_form .inputpicker-div {
      width: 100% !important;
    }

    #Editappointment_form .inputpicker-div {
      width: 100% !important;
    }

    #activityModal {
      right: 0px;

    }

    .modal.slide-right {
      transform: translateX(100%);
      transition: transform 0.3s ease-in-out;
    }

    .modal.show.slide-right {
      transform: translateX(25%);
    }

    .pc-header .header-search .form-control {
      padding: 0rem 0rem 0rem 1rem !important;
      width: 300px;
    }
    /* Ensure that the demo table scrolls */
th, td { 
  white-space: nowrap !important; 
}
div.dataTables_wrapper {
    width: 800px !important;
    margin: 0 auto !important;
}
#notifications {
            display: none;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
        }
  .duplicate-row {
        background-color: red; /* Highlight color */
    }
  </style>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
<div id="notifications">No Internet Connection or Poor Internet Connectivity</div>
<div id="loadingSpinner" style="display:none; z-index:10000; position: absolute; top:50%; right:50%;">
                    <img src="<?php echo base_url('assets/images/loader.gif'); ?>" alt="Loading...">
                </div>