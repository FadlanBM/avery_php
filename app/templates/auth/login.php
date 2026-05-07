<?php
// Get values from session or other sources if needed
$email_value = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
?>
<!DOCTYPE html>
<html class="light" lang="id">
<?php require_once __DIR__ . '/includes/head.php'; ?>


<body class="min-h-screen flex flex-col text-on-surface">
    <!-- Main Content: Login Shell -->
    <main class="flex-grow flex items-center justify-center pt-32 pb-20 px-6 relative overflow-hidden">
        <!-- Asymmetric Background Elements -->
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>

        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-surface-container-lowest rounded-[2rem] overflow-hidden editorial-shadow relative z-10">
            <!-- Left Side: Editorial Image & Branding -->
            <div class="hidden md:block relative h-full min-h-[600px]">
                <img class="absolute inset-0 w-full h-full object-cover" alt="Saffron-infused risotto" src="<?php echo BASE_URL; ?>/assets/images/auth/login_bg.jpg" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-12">
                    <h2 class="text-surface-container-lowest font-display font-extrabold text-4xl leading-tight mb-4">
                        Kelezatan yang<br />Menunggu Anda
                    </h2>
                    <p class="text-stone-200 font-body text-lg max-w-xs">
                        Masuk kembali ke dunia cita rasa premium Saffron &amp; Sage.
                    </p>
                </div>
            </div>
            <!-- Right Side: Login Form -->
            <div class="p-8 md:p-16 flex flex-col justify-center bg-surface-container-lowest">
                <div class="mb-10">
                    <h1 class="font-display font-bold text-3xl text-on-surface mb-2">Selamat Datang</h1>
                    <p class="text-on-surface-variant font-body">Silakan masuk untuk melanjutkan pesanan Anda.</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="bg-error-container text-on-error-container p-4 rounded-xl mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined">error</span>
                        <p class="text-sm font-medium"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <form class="space-y-6" action="<?php echo BASE_URL; ?>/login" method="POST">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface-variant px-1" for="username">Username</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">mail</span>
                            <input class="w-full pl-12 pr-4 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface placeholder-outline/60 transition-all outline-none" id="username" name="username" placeholder="username" type="text" value="<?php echo $email_value; ?>" required />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="block text-sm font-semibold text-on-surface-variant" for="password">Kata Sandi</label>
                            <a class="text-sm font-medium text-primary hover:underline underline-offset-4" href="#">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input class="w-full pl-12 pr-4 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface placeholder-outline/60 transition-all outline-none" id="password" name="password" placeholder="••••••••" type="password" required />
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="togglePassword()">
                                <span class="material-symbols-outlined" id="password-toggle-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 px-1">
                        <input type="checkbox" id="remember" name="remember" value="1" class="rounded border-outline-variant text-primary focus:ring-primary">
                        <label for="remember" class="text-sm text-on-surface-variant">Ingat saya</label>
                    </div>

                    <button class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-on-primary font-display font-bold text-lg rounded-xl editorial-shadow hover:opacity-90 active:scale-[0.98] transition-all" type="submit">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.innerText = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.innerText = 'visibility';
            }
        }
    </script>
</body>

</html>