    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ApexCharts configuration
            if (document.getElementById('chartOne')) {
                new ApexCharts(document.getElementById('chartOne'), {
                    series: [{
                        name: 'Sales',
                        data: [44, 55, 41, 67, 22, 43, 65, 88, 52, 35, 78, 90]
                    }],
                    chart: {
                        type: 'line',
                        height: 310,
                        toolbar: { show: false },
                        zoom: { enabled: false }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                        colors: ['#9c3800']
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: { style: { colors: '#6b7280' } }
                    },
                    yaxis: {
                        labels: { style: { colors: '#6b7280' } }
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 4
                    },
                    markers: {
                        size: 4,
                        colors: ['#9c3800'],
                        strokeWidth: 0
                    }
                }).render();
            }

            // SweetAlert2 Flash Messages
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            <?php
            $flashMessages = \App\Helpers\FlashMessage::get();
            foreach ($flashMessages as $msg):
            ?>
                Toast.fire({
                    icon: '<?= $msg['type'] === 'error' ? 'error' : ($msg['type'] === 'success' ? 'success' : 'info') ?>',
                    title: '<?= addslashes($msg['message']) ?>'
                });
            <?php endforeach; ?>
        });

        // Global Delete Confirmation
        function confirmDelete(formId, message = 'Data ini akan dihapus permanen!') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9c3800',
                cancelButtonColor: '#594238',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fef8f1',
                color: '#1d1b17',
                borderRadius: '1.5rem',
                customClass: {
                    popup: 'rounded-[2rem] p-8 shadow-2xl border border-white/20',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold transition-all hover:scale-105 active:scale-95',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold transition-all hover:scale-105 active:scale-95'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>