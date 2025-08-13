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
    <link href="<?php echo base_url('public/css/style.css'); ?>" rel="stylesheet" />

    <link rel="icon" href="<?php echo base_url('assets/images/Nimbus-fav1.png'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/loginstyle.css'); ?>">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            list-style-type: none;
            text-decoration: none;
            outline: none;
            scroll-behavior: smooth;

        }

        .alert {
            display: none;
        }

        #video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            /* Ensure the video stays behind all other content */
            pointer-events: none;
            /* Prevent the video from interfering with any mouse events */
        }

        #Login {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;

        }

        .login_main {
            display: flex;
            align-items: center;
            justify-content: right;
            padding-right: 3rem;
            margin: 2rem;
        }

        .login_main_wrapper {
            background-color: #ffffffa8;
            padding: 3rem;
            width: 500px;
        }

        .form_container input {
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .login_main {
                display: flex;
                align-items: center;
                justify-content: center;
                padding-right: 0rem !important;
                margin: 2rem;
            }
        }
    </style>

</head>

<body>
    <section id="Login">
        <div class="login_main_container">
            <div class="login_main">
                <div class="login_main_wrapper">
                    <div class="logo-cover">
                        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="">
                    </div>
                    <div class="form_container">
                        <h6>Login Here</h6>
                        <form class="formlogin" method="post">
                            <div class="alert alert-success">
                                <p></p>
                            </div>
                            <div>
                                <input placeholder="Enter your email" type="text" name="email_address" class="form-control">
                            </div>
                            <div style="position: relative;">
                                <input Placeholder="Enter Password" id="password" type="password" name="password" class="form-control" style="padding-right: 30px;">
                                <!-- Eye Icon Positioned Inside the Password Field -->
                                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                            </div>
                            <button type="button" id="login" class="btn btn-primary">Login</button>

                        </form>
                        <!-- <div class="row form-footer"> -->
                        <!-- <button type="button" class="btn btn-primary mx-auto d-block mt-5"
                            data-toggle="modal" data-target="#forgotPasswordModal" style="background-color: royalblue; ">
                            Reset Password
                        </button> -->
                        <!-- Modal Start -->
                        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Your Password</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="forgotPasswordForm">
                                        <div class="modal-body">
                                            <div class="alert alert-success">
                                                <p></p>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                            </div>
                                            <div class="form-group">
                                                <small id="emailHelp" class="form-text text-muted">We'll send you a link to reset your password.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" id="reset" class="btn btn-primary">Send Reset Link</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal End -->
                    </div>

                </div>
            </div>
        </div>

        <video id="video-background" autoplay loop muted>
            <source src="<?php echo base_url('assets/images/logo.mp4'); ?>" type="video/mp4">
        </video>
    </section>

</body>
<script>
    var base_url = "<?php echo base_url(); ?>";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

<script src="<?php echo base_url('js/validateuser.js'); ?>"></script>


</html>