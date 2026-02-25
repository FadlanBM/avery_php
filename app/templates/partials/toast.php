<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Toastr Configuration
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    <?php
    use App\Helpers\FlashMessage;
    
    // Check if FlashMessage class exists (in case autoloader issue)
    if (class_exists('App\\Helpers\\FlashMessage')) {
        $messages = FlashMessage::get();
        foreach ($messages as $msg) {
            $type = $msg['type'];
            $text = addslashes($msg['message']);
            
            // Map 'danger' to 'error' for toastr
            if ($type === 'danger') {
                $type = 'error';
            }
            
            echo "toastr['{$type}']('{$text}');";
        }
    }
    ?>
</script>
