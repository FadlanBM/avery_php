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
                            <form class="form-horizontal mt-3 form-material" id="loginform"  action="<?php echo BASE_URL; ?>/register" method="POST">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" required="true" name="name"  placeholder="Full Name">
                                </div>
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" required="true" name="email" placeholder="Email">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input id="register-password" class="form-control" type="password" required="true" name="password" placeholder="Password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#register-password">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Register</button>
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
    <?php require_once __DIR__ . '/../partials/toast.php'; ?>
</body>
</html>
