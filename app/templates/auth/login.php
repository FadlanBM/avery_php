<!DOCTYPE html>
<html dir="ltr">
    <?php require_once  __DIR__ . '/../partials/head.php'; ?>
<body class="fix-header">
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(../assets/images/background/login-register.jpg) no-repeat top center;">
            <div class="auth-box p-4 bg-white rounded">
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3">Sign In</h3>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <form class="form-horizontal mt-3 form-material" id="loginform" action="<?php echo BASE_URL; ?>/login" method="POST">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" type="password" name="password" required="" placeholder="Password">
                                </div>
                                <div class="form-group mb-3 d-flex">
                                    <div class="checkbox checkbox-info float-left pt-0 ml-2 mb-3">
                                        <input id="checkbox-signup" type="checkbox">
                                        <label for="checkbox-signup"> Remember me </label>
                                    </div> 
                                    <a href="javascript:void(0)" id="to-recover" class="text-dark ml-auto mb-3"><i class="fa fa-lock mr-1"></i> Forgot pwd?</a> 
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                                </div>
                                <div class="social mb-3 text-center">
                                    <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fab fa-facebook-f"></i> </a>
                                    <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fab fa-google-plus"></i> </a>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-center">
                                        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/register" class="text-info font-weight-normal ml-1">Sign Up</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <h3 class="font-weight-medium mb-3">Recover Password</h3>
                        <span>Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row mt-3">
                        <!-- Form -->
                        <form class="col-12 form-material" action="index.html">
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="email" required="" placeholder="Username">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-blo  ck btn-lg btn-primary text-uppercase" type="submit" name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . '/../partials/scripts-auth.php'; ?>
</body>

</html>