<!DOCTYPE html>
<html class="light" lang="id">
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="bg-surface text-on-surface" x-data="{ sidebarOpen: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
    <div class="flex">
        <!-- Sidebar -->
        <?php $activeMenu = 'table-management'; ?>
        <?php include __DIR__ . '/../partials/includes/navbarslider.php'; ?>
        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <?php $beforePageTitle = 'Denah Ruang'; ?>
            <?php $pageTitle = 'Tambah Meja Baru'; ?>
            <?php include __DIR__ . '/partials/header.php'; ?>

            <!-- Page Canvas -->
            <div class="p-4 lg:p-8 max-w-4xl mx-auto w-full flex-1">
                <div class="mb-10 text-center md:text-left">
                    <h1 class="text-4xl font-extrabold headline-font text-stone-900 tracking-tight">Tambah Meja Baru</h1>
                    <p class="text-stone-500 mt-2 text-lg">Konfigurasikan kapasitas dan lokasi meja untuk optimalisasi alur pelayanan.</p>
                </div>

                <div class="space-y-8">
                    <!-- Form Section -->
                    <section class="bg-surface-container-lowest p-8 rounded-3xl shadow-[0_12px_40px_-12px_rgba(0,0,0,0.05)] border border-stone-100">
                        <div class="space-y-8">
                            <!-- Table Number & Capacity -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold headline-font text-stone-700 flex items-center gap-2 ml-1">
                                        Nomor Meja
                                        <span class="text-primary">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">pin</span>
                                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-high border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" placeholder="Contoh: T-01" type="text" />
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold headline-font text-stone-700 flex items-center gap-2 ml-1">
                                        Kapasitas
                                        <span class="text-primary">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">group</span>
                                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-high border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" placeholder="Jumlah orang" type="number" />
                                    </div>
                                </div>
                            </div>


                            <!-- Table Status -->
                            <div class="p-6 bg-surface-container-low rounded-2xl flex flex-col sm:flex-row items-center justify-between border border-primary/5 gap-4">
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <div class="w-12 h-12 bg-secondary-container/30 rounded-full flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    </div>
                                    <div>
                                        <p class="font-bold headline-font text-on-surface">Status Meja Aktif</p>
                                        <p class="text-sm text-stone-500">Meja langsung tersedia untuk reservasi &amp; pesanan</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                    <input checked="" class="sr-only peer" type="checkbox" value="" />
                                    <div class="w-14 h-7 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-secondary"></div>
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                                <button class="w-full sm:flex-1 bg-primary text-white py-4 rounded-2xl font-bold headline-font text-lg shadow-lg shadow-primary/30 hover:bg-primary-container transition-all active:scale-[0.98] hover:opacity-90">
                                    Simpan Konfigurasi Meja
                                </button>
                                <button class="w-full sm:w-auto px-8 py-4 text-stone-500 font-bold headline-font hover:text-red-600 transition-colors" onclick="window.history.back()">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Tips Section -->
                    <div class="bg-orange-50/50 p-6 rounded-3xl border border-orange-100 flex gap-4">
                        <span class="material-symbols-outlined text-orange-700 shrink-0">info</span>
                        <p class="text-sm text-orange-950/80 leading-relaxed italic">
                            <strong>Tips Editorial:</strong> Penomoran meja sebaiknya mengikuti pola searah jarum jam dari pintu masuk utama untuk memudahkan staf baru mengenali tata letak ruang dengan cepat.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>