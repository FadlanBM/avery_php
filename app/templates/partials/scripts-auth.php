    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    
        <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/app.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/app.init.overlay.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/app-style-switcher.js"></script>   
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/sidebarmenu.js"></script>  
    <!--Custom JavaScript -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/feather.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/custom.min.js"></script>           
    <!-- ############################################################### -->
    <!-- This Page Js Files Here -->
    <!-- ############################################################### -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/chartist/dist/chartist.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/echarts/dist/echarts.min.js"></script>
    <!--c3 charts -->
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/d3/dist/d3.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/libs/c3/c3.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/dashboard/dist/js/pages/dashboards/dashboard1.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('.toggle-password').on('click', function(e){
        e.preventDefault();
        var target = $(this).data('target');
        var $input = target ? $(target) : $(this).closest('.input-group').find('input[type="password"], input[type="text"]');
        if ($input.length) {
            var type = $input.attr('type') === 'password' ? 'text' : 'password';
            $input.attr('type', type);
            var $icon = $(this).find('i');
            if ($icon.length) {
                $icon.toggleClass('fa-eye fa-eye-slash');
            }
        }
    });
    </script>
