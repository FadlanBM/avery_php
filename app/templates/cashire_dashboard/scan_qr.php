<!DOCTYPE html>

<html class="light" lang="id">

<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-background font-body antialiased overflow-x-hidden">
  <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
    <!-- SideNavBar Component (Shared) -->
    <?php $activeMenu = 'scanqr'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col relative overflow-y-auto overflow-x-hidden">
      <!-- TopNavBar Component (Shared Logic) -->
      <?php $pageTitle = 'Scan QR'; ?>
      <?php include 'partials/includes/topheader.php'; ?>
      <div class="flex-1 p-4 sm:p-6 md:p-8 lg:p-12 max-w-6xl mx-auto w-full overflow-x-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 items-start min-w-0">
          <!-- Viewfinder & Scanning Section -->
          <div class="lg:col-span-7 space-y-6 lg:space-y-8 min-w-0">
            <div class="relative group">
              <!-- Sensory Editorial Flourish -->
              <div class="absolute -top-6 -left-6 w-32 h-32 bg-tertiary-fixed/30 rounded-full blur-3xl"></div>
              <!-- Scanner Card -->
              <div class="relative bg-surface-container-low rounded-2xl sm:rounded-[2rem] p-3 sm:p-4 shadow-sm overflow-hidden">
                <div class="aspect-square w-full max-w-md mx-auto bg-stone-900 rounded-xl sm:rounded-[1.5rem] relative overflow-hidden flex items-center justify-center">
                  <!-- Camera Stream Placeholder -->
                  <div class="absolute inset-0 opacity-40 mix-blend-overlay">
                    <img alt="Background texture" class="w-full h-full object-cover grayscale" data-alt="abstract blurred view of a high-end restaurant kitchen with warm lighting and motion of chefs in white coats" src="<?= BASE_URL ?>/assets/images/employee_dashboard/kitchen_texture.jpg" />
                  </div>
                  <!-- QR Framing UI -->
                  <div class="relative z-10 w-48 h-48 sm:w-56 sm:h-56 md:w-64 md:h-64 border-2 border-white/20 rounded-2xl sm:rounded-3xl flex items-center justify-center">
                    <!-- Corners -->
                    <div class="absolute top-0 left-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 border-t-4 border-l-4 border-primary rounded-tl-lg sm:rounded-tl-xl -mt-1 -ml-1"></div>
                    <div class="absolute top-0 right-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 border-t-4 border-r-4 border-primary rounded-tr-lg sm:rounded-tr-xl -mt-1 -mr-1"></div>
                    <div class="absolute bottom-0 left-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 border-b-4 border-l-4 border-primary rounded-bl-lg sm:rounded-bl-xl -mb-1 -ml-1"></div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 border-b-4 border-r-4 border-primary rounded-br-lg sm:rounded-br-xl -mb-1 -mr-1"></div>
                    <!-- Scanning Animation Line -->
                    <div class="absolute w-full h-0.5 bg-primary/60 top-1/2 -translate-y-1/2 blur-[2px] shadow-[0_0_15px_#9c3800]"></div>
                    <span class="material-symbols-outlined text-white/40 text-4xl sm:text-5xl md:text-6xl" data-icon="qr_code_2">qr_code_2</span>
                  </div>
                  <div class="absolute bottom-4 sm:bottom-6 md:bottom-8 left-0 right-0 text-center">
                    <span class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-black/40 backdrop-blur-md rounded-full text-white text-xs sm:text-sm font-headline tracking-wide">
                      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                      Camera Active
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center space-y-2 px-2">
              <h2 class="font-headline font-extrabold text-xl sm:text-2xl md:text-3xl text-on-surface tracking-tight">Arahkan QR Code Pelanggan ke Kamera</h2>
              <p class="text-outline font-medium text-sm sm:text-base">Pastikan kode berada di dalam bingkai untuk proses verifikasi yang lebih cepat.</p>
            </div>
          </div>
          <!-- Manual Input & Contextual Info Section -->
          <div class="lg:col-span-5 space-y-6 lg:space-y-10 min-w-0">
            <!-- Manual Entry Card -->
            <section class="bg-surface-container-lowest rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 shadow-[0_8px_24px_-4px_rgba(156,56,0,0.06)] space-y-4 sm:space-y-6">
              <div class="space-y-1">
                <h3 class="font-headline font-bold text-lg sm:text-xl text-on-surface">Verifikasi Manual</h3>
                <p class="text-xs sm:text-sm text-on-surface-variant">Gunakan jika QR Code tidak terbaca atau rusak.</p>
              </div>
              <div class="space-y-4">
                <div class="space-y-2">
                  <label class="block text-xs font-headline font-bold uppercase tracking-widest text-outline">ID Pesanan</label>
                  <div class="relative">
                    <input class="w-full h-12 sm:h-14 bg-surface-container-high border-0 rounded-xl px-4 font-headline text-on-surface focus:ring-2 focus:ring-primary/20 placeholder:text-outline/50 transition-all text-sm sm:text-base" placeholder="Contoh: ORDER-88921" type="text" />
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline/40" data-icon="tag">tag</span>
                  </div>
                </div>
                <button class="w-full h-12 sm:h-14 bg-primary text-on-primary rounded-xl font-headline font-extrabold text-sm sm:text-base tracking-wide flex items-center justify-center gap-2 transition-all hover:shadow-lg hover:shadow-primary/10 active:scale-[0.97]">
                  Cari Pesanan
                  <span class="material-symbols-outlined" data-icon="search">search</span>
                </button>
              </div>
            </section>
            <!-- Instructional / Guide Bento -->
            <div class="grid grid-cols-1 gap-4">
              <div class="bg-secondary-container/20 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-secondary-container/30 flex items-start gap-3 sm:gap-4">
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-secondary text-on-secondary flex items-center justify-center flex-shrink-0">
                  <span class="material-symbols-outlined text-lg sm:text-xl" data-icon="lightbulb" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                </div>
                <div>
                  <h4 class="font-headline font-bold text-secondary text-xs sm:text-sm">Tips Pencahayaan</h4>
                  <p class="text-xs text-on-secondary-container leading-relaxed mt-1 italic">Sesuaikan kecerahan layar ponsel pelanggan jika kode sulit terbaca oleh lensa kamera.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Meta Info -->
      <footer class="mt-auto px-4 sm:px-8 md:px-12 py-4 sm:py-6 md:py-8 flex flex-wrap justify-center sm:justify-between items-center gap-2 sm:gap-4 text-[10px] uppercase tracking-[0.1em] sm:tracking-[0.2em] font-bold text-outline opacity-60">
        <div class="hidden sm:block">Terminal ID: POS-JKT-04-A</div>
        <div>System Status: Operational</div>
        <div class="hidden md:block">Server Time: 09:42:15 WIB</div>
      </footer>
    </main>
  </div>
</body>

</html>