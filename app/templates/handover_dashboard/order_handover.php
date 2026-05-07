<!DOCTYPE html>

<html class="light" lang="id">

<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-surface antialiased">
    <!-- SideNavBar -->
    <?php $activeMenu = 'scanqr'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>
    <main class=" min-h-screen">
        <!-- TopNavBar -->
        <?php $pageTitle = 'Scan QR'; ?>
        <?php include 'partials/includes/topheader.php'; ?>
        <!-- Content Canvas -->
        <div class="p-8 max-w-7xl mx-auto">
            <!-- Hero Header -->
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Pesanan Siap Saji</h1>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-secondary-fixed text-on-secondary-fixed text-xs font-bold rounded-full">8 Pesanan Menunggu Handover</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-300"></span>
                        <span class="text-stone-500 text-sm">Terakhir diperbarui: 14:20 WIB</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button class="flex items-center gap-2 px-6 py-3 bg-surface-container-high rounded-xl text-on-surface font-semibold hover:bg-surface-container-highest transition-colors">
                        <span class="material-symbols-outlined text-lg">filter_list</span>
                        Filter Meja
                    </button>
                    <button class="flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-xl font-bold shadow-lg shadow-primary/30 hover:scale-[1.02] transition-transform">
                        <span class="material-symbols-outlined text-lg">qr_code_scanner</span>
                        Mulai Scan Massal
                    </button>
                </div>
            </div>
            <!-- Handover Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                <!-- Order Card 1 -->
                <div class="bg-surface-container-lowest rounded-3xl p-6 flex flex-col shadow-[0_8px_24px_-4px_rgba(156,56,0,0.06)] relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="bg-secondary text-on-secondary text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">READY</span>
                    </div>
                    <div class="mb-6">
                        <p class="text-primary font-bold text-sm uppercase tracking-tighter mb-1">Meja 12</p>
                        <h3 class="text-2xl font-extrabold text-on-surface leading-tight">Rizky Ramadhan</h3>
                        <p class="text-stone-400 text-xs mt-1">Order #2409-AS82</p>
                    </div>
                    <div class="flex-1 space-y-4 mb-8">
                        <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-2xl">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" data-alt="vibrant signature saffron risotto with golden hues, garnish of microgreens on a white ceramic plate" src="<?= BASE_URL ?>/assets/images/handover_dashboard/saffron_risotto.jpg" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">1x Signature Saffron Risotto</p>
                                <p class="text-[10px] text-stone-500 italic">Chef Special • No Mushrooms</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-2xl opacity-70">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" data-alt="cold refreshing artisan soda with citrus slices and fresh mint leaves in a crystal glass" src="<?= BASE_URL ?>/assets/images/handover_dashboard/artisan_soda.jpg" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">2x Sparkling Sage Lemonade</p>
                                <p class="text-[10px] text-stone-500 italic">Less Ice</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full py-4 bg-primary-container text-on-primary-container rounded-2xl font-extrabold flex items-center justify-center gap-3 group-hover:scale-[0.98] transition-transform">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        SCAN QR HANDOVER
                    </button>
                </div>
                <!-- Order Card 2 -->
                <div class="bg-surface-container-lowest rounded-3xl p-6 flex flex-col shadow-[0_8px_24px_-4px_rgba(156,56,0,0.06)] relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="bg-secondary text-on-secondary text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">READY</span>
                    </div>
                    <div class="mb-6">
                        <p class="text-primary font-bold text-sm uppercase tracking-tighter mb-1">Meja 05</p>
                        <h3 class="text-2xl font-extrabold text-on-surface leading-tight">Sarah Widjaja</h3>
                        <p class="text-stone-400 text-xs mt-1">Order #2409-ZK11</p>
                    </div>
                    <div class="flex-1 space-y-4 mb-8">
                        <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-2xl">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" data-alt="grilled herb-crusted salmon with asparagus spears and a lemon wedge on an elegant slate platter" src="<?= BASE_URL ?>/assets/images/handover_dashboard/grilled_salmon.jpg" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">1x Herb-Crusted Salmon</p>
                                <p class="text-[10px] text-stone-500 italic">Medium Well</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full py-4 bg-primary-container text-on-primary-container rounded-2xl font-extrabold flex items-center justify-center gap-3 group-hover:scale-[0.98] transition-transform">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        SCAN QR HANDOVER
                    </button>
                </div>
                <!-- Order Card 3 (Empty/Ghost Slot Style) -->
                <div class="bg-surface-container-low border-2 border-dashed border-stone-200 rounded-3xl p-6 flex flex-col items-center justify-center text-center opacity-80">
                    <div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-stone-400 text-3xl">restaurant</span>
                    </div>
                    <p class="font-bold text-stone-500">Menunggu Pesanan Selanjutnya</p>
                    <p class="text-xs text-stone-400 max-w-[180px] mt-2 italic">Dapur sedang memproses 12 pesanan lainnya...</p>
                </div>
                <!-- Order Card 4 -->
                <div class="bg-surface-container-lowest rounded-3xl p-6 flex flex-col shadow-[0_8px_24px_-4px_rgba(156,56,0,0.06)] relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="bg-secondary text-on-secondary text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">READY</span>
                    </div>
                    <div class="mb-6">
                        <p class="text-primary font-bold text-sm uppercase tracking-tighter mb-1">VIP 02</p>
                        <h3 class="text-2xl font-extrabold text-on-surface leading-tight">Ananda Putri</h3>
                        <p class="text-stone-400 text-xs mt-1">Order #2409-PP04</p>
                    </div>
                    <div class="flex-1 space-y-4 mb-8">
                        <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-2xl">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" data-alt="slice of gourmet margherita pizza with fresh basil leaves and melted mozzarella on a rustic board" src="<?= BASE_URL ?>/assets/images/handover_dashboard/margherita_pizza.jpg" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">3x Artisan Margherita</p>
                                <p class="text-[10px] text-stone-500 italic">Extra Basil</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full py-4 bg-primary-container text-on-primary-container rounded-2xl font-extrabold flex items-center justify-center gap-3 group-hover:scale-[0.98] transition-transform">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        SCAN QR HANDOVER
                    </button>
                </div>
                <!-- Order Card 5 -->
                <div class="bg-surface-container-lowest rounded-3xl p-6 flex flex-col shadow-[0_8px_24px_-4px_rgba(156,56,0,0.06)] relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="bg-secondary text-on-secondary text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">READY</span>
                    </div>
                    <div class="mb-6">
                        <p class="text-primary font-bold text-sm uppercase tracking-tighter mb-1">Meja 28</p>
                        <h3 class="text-2xl font-extrabold text-on-surface leading-tight">Budi Santoso</h3>
                        <p class="text-stone-400 text-xs mt-1">Order #2409-KL99</p>
                    </div>
                    <div class="flex-1 space-y-4 mb-8">
                        <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-2xl">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover" data-alt="fresh garden salad with vibrant vegetables, cherry tomatoes, and a light balsamic drizzle in a ceramic bowl" src="<?= BASE_URL ?>/assets/images/handover_dashboard/garden_salad.jpg" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">1x Saffron Garden Salad</p>
                                <p class="text-[10px] text-stone-500 italic">Dressing on side</p>
                            </div>
                        </div>
                    </div>
                    <button class="w-full py-4 bg-primary-container text-on-primary-container rounded-2xl font-extrabold flex items-center justify-center gap-3 group-hover:scale-[0.98] transition-transform">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                        SCAN QR HANDOVER
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Contextual Quick Action Floating (Optional) -->
    <button class="fixed bottom-8 right-8 w-16 h-16 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:rotate-12 transition-all group z-50">
        <span class="material-symbols-outlined text-3xl">add</span>
        <span class="absolute right-20 bg-inverse-surface text-inverse-on-surface px-4 py-2 rounded-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl">Manual Dispatch</span>
    </button>
</body>

</html>