<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NIMBUS CRM</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link href="<?php echo base_url('public/css/style.css');?>" rel="stylesheet" />

    <link rel="icon" href="<?php echo base_url('assets/images/Nimbus-fav1.png'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loginstyle.css');?>">
    <link rel="stylesheet" href="https://www.markuptag.com/bootstrap/5/css/bootstrap.min.css" />
    <style>
    .alert{display:none;}
     </style>

</head>

<body>
    <div class="container-fluid bg-login">
    <div class="bg-login">
        <video autoplay loop muted>
                <source src="<?php echo base_url('assets/images/logo.mp4'); ?>" type="video/mp4">
            </video>
        <div class="container  py-5">
            <!-- <div class="row"> -->
                <!-- <div class="col-lg-9 col-md-12 login-card"> -->
                    <!-- <div class="row">
                        <div class="col-md-5 detail-part">
                            <h1>Welcome!</h1> -->
                            <!-- <p>Please use your credentials to login.
                                If you are not a member, please register. </p> -->
                        <!-- </div> -->
                        <div class="col-md-7  login-part py-4 ">
                            <div class="row py-5">
                                <div class="col-lg-10 col-md-12 mx-auto">
                                    <div class="logo-cover">
                                        <img src="<?php echo base_url('assets/images/logo.png');?>" alt="">
                                    </div>
                                    <div class="form-cover">
                                        <h6>Reset Password</h6>
                                        <form id="resetpasswordForm"  method="post">
                                            <div class="alert alert-success"><p></p></div> 
                                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                                            <input placeholder="Enter New Password" type="password" id="password" name="password" class="form-control" style="padding-right: 30px;">
                                            <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 25px; top: 80%; transform: translateY(-34%); cursor: pointer;"></i>

                                            <button type="button" id="reset" class="btn btn-primary">Reset</button>

                                        </form>
                                        <!-- <div class="row form-footer"> -->
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>var base_url = "<?php echo base_url(); ?>";</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

<script src="<?php echo base_url('js/validateuser.js');?>"></script>


</html>