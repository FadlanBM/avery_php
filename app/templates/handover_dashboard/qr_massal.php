<!DOCTYPE html>

<html lang="id">
<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-background min-h-screen overflow-hidden">
    <!-- TopAppBar -->
    <?php $pageTitle = 'Scan QR'; ?>
    <?php include 'partials/includes/topheader.php'; ?>
    <!-- SideNavBar -->
    <?php $activeMenu = 'scanqr'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>
    <!-- Main Content Canvas -->
    <main class="ml-64 p-8 h-[calc(100vh-64px)] flex gap-8">
        <!-- Scanning Viewport Area -->
        <section class="flex-1 flex flex-col gap-6">
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-on-surface tracking-tight mb-1">Pindai Massal</h1>
                    <p class="text-on-surface-variant font-medium">Arahkan kamera ke satu atau beberapa kode QR pesanan sekaligus.</p>
                </div>
                <div class="flex gap-3">
                    <span class="flex items-center gap-2 bg-secondary/10 text-secondary px-4 py-2 rounded-full text-sm font-semibold">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                        </span>
                        Sistem Aktif
                    </span>
                </div>
            </div>
            <!-- The Camera Viewfinder Container -->
            <div class="relative flex-1 rounded-[2rem] overflow-hidden bg-stone-900 shadow-2xl group border-4 border-surface-container-low">
                <img class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" data-alt="High-angle view of a restaurant table with several printed QR codes and a smartphone camera lens effect in a dark moody atmosphere" src="<?= BASE_URL ?>/assets/images/handover_dashboard/qr_massal_bg.jpg" />
                <!-- Scanning Overlays -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-80 h-80 scanning-reticle border-primary/40 rounded-3xl relative">
                        <div class="absolute inset-x-0 h-1 bg-primary/40 shadow-[0_0_15px_rgba(156,56,0,0.8)] animate-pulse" style="top: 20%;"></div>
                    </div>
                </div>
                <!-- Detected QR Markers (Visual Indicators) -->
                <div class="absolute top-[25%] left-[30%] animate-pulse">
                    <div class="relative">
                        <div class="w-24 h-24 border-2 border-secondary rounded-xl bg-secondary/10 backdrop-blur-sm"></div>
                        <div class="absolute -top-8 left-0 bg-secondary text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-lg flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            TABLE 12 - DETECTED
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-[35%] right-[25%] opacity-80 scale-90">
                    <div class="relative">
                        <div class="w-20 h-20 border-2 border-primary rounded-xl bg-primary/10 backdrop-blur-sm"></div>
                        <div class="absolute -top-8 left-0 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-lg flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px] animate-spin">sync</span>
                            PROCESSING...
                        </div>
                    </div>
                </div>
                <!-- Viewfinder Controls -->
                <div class="absolute bottom-8 inset-x-0 flex justify-center gap-4">
                    <button class="bg-white/10 backdrop-blur-md text-white px-6 py-3 rounded-full flex items-center gap-2 hover:bg-white/20 transition-all border border-white/20">
                        <span class="material-symbols-outlined">zoom_in</span>
                        <span class="text-sm font-semibold">Zoom 2x</span>
                    </button>
                    <button class="bg-white/10 backdrop-blur-md text-white px-6 py-3 rounded-full flex items-center gap-2 hover:bg-white/20 transition-all border border-white/20">
                        <span class="material-symbols-outlined">flashlight_on</span>
                        <span class="text-sm font-semibold">Senter</span>
                    </button>
                </div>
            </div>
        </section>
        <!-- Side Panel: Validation Queue -->
        <aside class="w-[400px] bg-surface-container-low rounded-[2rem] flex flex-col shadow-sm">
            <div class="p-8 pb-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-bold tracking-tight text-on-surface">Antrean Validasi</h2>
                    <span class="bg-primary/10 text-primary text-xs font-bold px-2 py-1 rounded-full">3 Baru</span>
                </div>
                <p class="text-sm text-on-surface-variant font-medium">Daftar kode yang berhasil dipindai</p>
            </div>
            <!-- Queue List -->
            <div class="flex-1 overflow-y-auto px-6 space-y-4 py-4">
                <!-- Item 1: Pending -->
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-transparent hover:border-primary/20 transition-all group">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-primary tracking-widest">ORDER #8821</span>
                            <span class="text-lg font-bold text-on-surface">Meja 12</span>
                        </div>
                        <span class="material-symbols-outlined text-secondary opacity-0 group-hover:opacity-100 transition-opacity">info</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest overflow-hidden">
                                <img class="w-full h-full object-cover" data-alt="Gourmet salad with fresh greens and grilled chicken in a ceramic bowl" src="<?= BASE_URL ?>/assets/images/handover_dashboard/gourmet_salad.jpg" />
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest overflow-hidden">
                                <img class="w-full h-full object-cover" data-alt="Artisanal veggie bowl with vibrant vegetables and hummus" src="<?= BASE_URL ?>/assets/images/handover_dashboard/veggie_bowl.jpg" />
                            </div>
                            <div class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container flex items-center justify-center text-[10px] font-bold">
                                +3
                            </div>
                        </div>
                        <button class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
                            Validasi
                        </button>
                    </div>
                </div>
                <!-- Item 2: Validating -->
                <div class="bg-surface-container-lowest/60 p-5 rounded-2xl border border-secondary/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-2">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                        </span>
                    </div>
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-secondary tracking-widest">ORDER #8819</span>
                            <span class="text-lg font-bold text-on-surface">Meja 05</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-secondary font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                            Memvalidasi...
                        </p>
                        <button class="bg-secondary/10 text-secondary border border-secondary/20 px-4 py-2 rounded-xl text-sm font-bold">
                            Tunggu
                        </button>
                    </div>
                </div>
                <!-- Item 3: Success -->
                <div class="bg-secondary/5 p-5 rounded-2xl border border-secondary/10">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-on-surface-variant tracking-widest">ORDER #8815</span>
                            <span class="text-lg font-bold text-on-surface line-through decoration-on-surface-variant opacity-60">Meja 09</span>
                        </div>
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-on-surface-variant font-medium italic">Handover selesai</p>
                        <span class="text-xs font-bold text-secondary bg-secondary-container px-3 py-1 rounded-full uppercase">Selesai</span>
                    </div>
                </div>
                <!-- Placeholder Empty -->
                <div class="border-2 border-dashed border-outline-variant/30 rounded-2xl p-8 flex flex-col items-center justify-center text-center opacity-40">
                    <span class="material-symbols-outlined text-4xl mb-2">qr_code_2</span>
                    <p class="text-sm font-medium">Menunggu pemindaian selanjutnya...</p>
                </div>
            </div>
            <!-- Sticky Actions -->
            <div class="p-8 bg-surface-container-low border-t border-surface-container-high space-y-3 rounded-b-[2rem]">
                <button class="w-full py-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-3 shadow-xl shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95">
                    <span class="material-symbols-outlined">done_all</span>
                    Selesaikan Semua (3)
                </button>
                <button class="w-full py-3 bg-transparent text-on-surface-variant hover:text-primary rounded-xl font-bold text-sm transition-colors">
                    Batal
                </button>
            </div>
        </aside>
    </main>
</body>

</html>