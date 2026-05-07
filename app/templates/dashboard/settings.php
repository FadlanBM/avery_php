<!DOCTYPE html>
<html class="light" lang="id">
<?php include 'partials/includes/head.php'; ?>`

<body class="bg-background text-on-surface h-screen overflow-hidden" x-data="{ sidebarOpen: false, activeTab: 'restaurant-profile', showPaymentModal: false, showCategoryModal: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
    <div class="flex">
        <!-- Sidebar -->
        <?php $activeMenu = 'settings'; ?>
        <?php include 'partials/includes/navbarslider.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 h-screen flex flex-col overflow-hidden">
            <!-- Header -->
            <?php $pageTitle = 'Pengaturan Sistem'; ?>
            <?php include 'partials/includes/topheader.php'; ?>

            <!-- Page Canvas -->
            <div class="flex-1 overflow-y-auto p-4 lg:p-8 max-w-6xl mx-auto w-full">

                <!-- Main Layout Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <!-- Internal Nav / Tabs -->
                    <div class="lg:col-span-3 space-y-2 lg:sticky lg:top-0 lg:self-start">
                        <button
                            @click="activeTab = 'restaurant-profile'"
                            :class="activeTab === 'restaurant-profile' ? 'bg-surface-container-low text-primary border-primary font-bold' : 'text-on-surface-variant font-medium hover:bg-surface-container-low border-transparent'"
                            class="w-full flex items-center justify-between px-5 py-4 rounded-xl transition-all border-l-4 text-left">
                            <span>Profil Restoran</span>
                            <span class="material-symbols-outlined text-lg" :class="activeTab === 'restaurant-profile' ? '' : 'opacity-40'">chevron_right</span>
                        </button>
                        <button
                            @click="activeTab = 'employees'"
                            :class="activeTab === 'employees' ? 'bg-surface-container-low text-primary border-primary font-bold' : 'text-on-surface-variant font-medium hover:bg-surface-container-low border-transparent'"
                            class="w-full flex items-center justify-between px-5 py-4 rounded-xl transition-all border-l-4 text-left">
                            <span>Pengaturan Karyawan</span>
                            <span class="material-symbols-outlined text-lg" :class="activeTab === 'employees' ? '' : 'opacity-40'">chevron_right</span>
                        </button>
                        <button
                            @click="activeTab = 'static-data'"
                            :class="activeTab === 'static-data' ? 'bg-surface-container-low text-primary border-primary font-bold' : 'text-on-surface-variant font-medium hover:bg-surface-container-low border-transparent'"
                            class="w-full flex items-center justify-between px-5 py-4 rounded-xl transition-all border-l-4 text-left">
                            <span>Data Statis Restoran</span>
                            <span class="material-symbols-outlined text-lg" :class="activeTab === 'static-data' ? '' : 'opacity-40'">chevron_right</span>
                        </button>
                        <button
                            @click="activeTab = 'profile-setting'"
                            :class="activeTab === 'profile-setting' ? 'bg-surface-container-low text-primary border-primary font-bold' : 'text-on-surface-variant font-medium hover:bg-surface-container-low border-transparent'"
                            class="w-full flex items-center justify-between px-5 py-4 rounded-xl transition-all border-l-4 text-left">
                            <span>Setting Profile</span>
                            <span class="material-symbols-outlined text-lg" :class="activeTab === 'profile-setting' ? '' : 'opacity-40'">chevron_right</span>
                        </button>
                    </div>

                    <!-- Content Forms -->
                    <div class="lg:col-span-9 space-y-12">
                        <!-- Profil Restoran Tab -->
                        <div x-show="activeTab === 'restaurant-profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-12">
                            <!-- Profil Restoran Section -->
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
                                    </div>
                                    <h2 class="text-2xl font-bold tracking-tight">Profil Restoran</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Logo Upload Area -->
                                    <div class="md:col-span-2 flex items-center gap-8 p-6 bg-surface-container-low rounded-2xl border-2 border-dashed border-outline-variant/30">
                                        <div class="relative group">
                                            <div class="w-32 h-32 rounded-2xl overflow-hidden bg-white flex items-center justify-center shadow-inner">
                                                <img alt="Current Logo" class="w-full h-full object-cover" src="<?= BASE_URL ?>/assets/images/logo/logo_current.jpg" />
                                            </div>
                                            <button class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary text-on-primary rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </button>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface mb-1">Logo Restoran</h3>
                                            <p class="text-sm text-on-surface-variant mb-4">Gunakan file PNG atau JPG minimal 512x512px untuk hasil terbaik.</p>
                                            <button class="px-5 py-2 bg-white text-primary border border-primary/20 rounded-full text-sm font-bold hover:bg-primary/5 transition-colors">Unggah Logo Baru</button>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1">Nama Restoran</label>
                                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-primary focus:bg-white transition-all text-on-surface shadow-sm" type="text" value="<?= htmlspecialchars($restaurant->name ?? 'Saffron & Sage Kitchen') ?>" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1">Email Kontak</label>
                                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-primary focus:bg-white transition-all text-on-surface shadow-sm" type="email" value="<?= htmlspecialchars($restaurant->email ?? 'hello@saffronsage.id') ?>" />
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1">Alamat Lengkap</label>
                                        <textarea class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-primary focus:bg-white transition-all text-on-surface shadow-sm" rows="3"><?= htmlspecialchars($restaurant->address ?? 'Jl. Senopati No. 88, Kebayoran Baru, Jakarta Selatan, 12190') ?></textarea>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1">Nomor Telepon</label>
                                        <input class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-primary focus:bg-white transition-all text-on-surface shadow-sm" type="text" value="<?= htmlspecialchars($restaurant->phone_number ?? '+62 21 555 1234') ?>" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1">Kategori Utama</label>
                                        <select class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-primary focus:bg-white transition-all text-on-surface shadow-sm">
                                            <option>Modern Indonesian Cuisine</option>
                                            <option>Fine Dining</option>
                                            <option>Artisan Bakery</option>
                                        </select>
                                    </div>
                                </div>
                            </section>

                            <!-- Jam Operasional Section -->
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">schedule</span>
                                        </div>
                                        <h2 class="text-2xl font-bold tracking-tight">Jam Operasional</h2>
                                    </div>
                                    <div class="flex items-center gap-2 px-4 py-2 bg-surface-container-low rounded-full">
                                        <span class="text-xs font-bold text-on-surface-variant">Timezone: Asia/Jakarta</span>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <?php
                                    $defaultDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

                                    // Map existing settings for easy lookup
                                    $mappedSettings = [];
                                    if (!empty($openSettings)) {
                                        foreach ($openSettings as $setting) {
                                            $mappedSettings[$setting->day] = $setting;
                                        }
                                    }

                                    foreach ($defaultDays as $day):
                                        $setting = $mappedSettings[$day] ?? null;
                                        $isOpen = $setting ? ($setting->is_open === 'open' || $setting->is_open === '1') : ($day !== 'Minggu');
                                        $startTime = $setting->start_time ?? ($day === 'Minggu' ? '00:00' : '10:00');
                                        $endTime = $setting->end_time ?? ($day === 'Minggu' ? '00:00' : '22:00');
                                    ?>
                                        <div class="grid grid-cols-12 items-center gap-4 p-4 rounded-2xl hover:bg-surface-container-low transition-colors group <?= !$isOpen ? 'bg-surface-container-low' : '' ?>">
                                            <div class="col-span-3 font-bold text-on-surface <?= !$isOpen ? 'opacity-60' : '' ?>"><?= $day ?></div>
                                            <div class="col-span-6 flex items-center gap-3 <?= !$isOpen ? 'opacity-40' : '' ?>">
                                                <input class="bg-surface-container-high border-none rounded-lg px-3 py-2 text-sm focus:ring-primary shadow-sm" type="time" value="<?= substr($startTime, 0, 5) ?>" <?= !$isOpen ? 'disabled' : '' ?> />
                                                <span class="text-on-surface-variant">—</span>
                                                <input class="bg-surface-container-high border-none rounded-lg px-3 py-2 text-sm focus:ring-primary shadow-sm" type="time" value="<?= substr($endTime, 0, 5) ?>" <?= !$isOpen ? 'disabled' : '' ?> />
                                            </div>
                                            <div class="col-span-3 flex justify-end">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" class="sr-only peer" <?= $isOpen ? 'checked' : '' ?> />
                                                    <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                                    <span class="ms-3 text-xs font-bold text-on-surface-variant"><?= $isOpen ? 'Buka' : 'Tutup' ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        </div>

                        <!-- Employee Settings Tab -->
                        <div x-show="activeTab === 'employees'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-12">
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">badge</span>
                                    </div>
                                    <h2 class="text-2xl font-bold tracking-tight">Pengaturan Karyawan</h2>
                                </div>
                                <div class="text-center py-12">
                                    <p class="text-stone-500">Modul pengaturan karyawan sedang dalam pengembangan.</p>
                                </div>
                            </section>
                        </div>

                        <!-- Static Data Tab -->
                        <div x-show="activeTab === 'static-data'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                            <!-- Payment Methods Section -->
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold tracking-tight">Metode Pembayaran</h2>
                                            <p class="text-sm text-on-surface-variant">Kelola cara pelanggan membayar pesanan</p>
                                        </div>
                                    </div>
                                    <button @click="showPaymentModal = true" class="flex items-center gap-2 px-5 py-2 bg-primary/10 text-primary rounded-full text-sm font-bold hover:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-sm">add</span> Tambah Baru
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php if (empty($paymentMethods)): ?>
                                        <div class="md:col-span-2 text-center py-12 bg-surface-container-low rounded-2xl border-2 border-dashed border-outline-variant/30">
                                            <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mx-auto mb-4">
                                                <span class="material-symbols-outlined text-on-surface-variant text-3xl">payments</span>
                                            </div>
                                            <p class="text-on-surface-variant font-medium">Belum ada metode pembayaran.</p>
                                            <p class="text-xs text-on-surface-variant mt-1">Klik tombol di atas untuk menambahkan.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($paymentMethods as $method): ?>
                                            <div class="flex items-center justify-between p-5 bg-surface-container-low rounded-2xl border border-transparent hover:border-blue-200 transition-all group">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm">
                                                        <span class="material-symbols-outlined text-blue-600">payments</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-on-surface"><?= htmlspecialchars($method->name) ?></p>
                                                        <div class="flex items-center gap-2">
                                                            <span class="w-2 h-2 rounded-full <?= $method->is_active ? 'bg-secondary' : 'bg-outline-variant' ?>"></span>
                                                            <span class="text-[10px] font-bold <?= $method->is_active ? 'text-secondary' : 'text-on-surface-variant' ?> uppercase tracking-wider">
                                                                <?= $method->is_active ? 'Aktif' : 'Non-aktif' ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-1">
                                                    <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-full transition-all opacity-0 group-hover:opacity-100" title="Edit">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </button>
                                                    <form id="delete-payment-<?= $method->id ?>" action="<?= BASE_URL ?>/dashboard/settings/delete-payment-method" method="POST" class="inline">
                                                        <input type="hidden" name="id" value="<?= $method->id ?>">
                                                        <button type="button" onclick="confirmDelete('delete-payment-<?= $method->id ?>', 'Metode pembayaran <?= addslashes($method->name) ?> akan dihapus permanen!')" class="p-2 text-on-surface-variant hover:text-error hover:bg-error/10 rounded-full transition-all opacity-0 group-hover:opacity-100" title="Hapus">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </section>

                            <!-- Category Menu Section -->
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">category</span>
                                        </div>
                                        <div>
                                            <h2 class="text-2xl font-bold tracking-tight">Kategori Menu</h2>
                                            <p class="text-sm text-on-surface-variant">Kelompokkan menu agar mudah ditemukan</p>
                                        </div>
                                    </div>
                                    <button @click="showCategoryModal = true" class="flex items-center gap-2 px-5 py-2 bg-primary/10 text-primary rounded-full text-sm font-bold hover:bg-primary/20 transition-colors">
                                        <span class="material-symbols-outlined text-sm">add</span> Tambah Kategori
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php if (empty($categories)): ?>
                                        <div class="md:col-span-2 text-center py-12 bg-surface-container-low rounded-2xl border-2 border-dashed border-outline-variant/30">
                                            <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mx-auto mb-4">
                                                <span class="material-symbols-outlined text-on-surface-variant text-3xl">category</span>
                                            </div>
                                            <p class="text-on-surface-variant font-medium">Belum ada kategori menu.</p>
                                            <p class="text-xs text-on-surface-variant mt-1">Klik tombol di atas untuk menambahkan.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($categories as $category): ?>
                                            <div class="flex items-center justify-between p-5 bg-surface-container-low rounded-2xl border border-transparent hover:border-orange-200 transition-all group">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm text-primary">
                                                        <span class="material-symbols-outlined">category</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-on-surface"><?= htmlspecialchars($category->name) ?></p>
                                                        <p class="text-[10px] text-on-surface-variant"><?= htmlspecialchars($category->description) ?></p>
                                                    </div>
                                                </div>
                                                <button @click="showCategoryModal = true" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-full transition-all opacity-0 group-hover:opacity-100" title="Edit">
                                                    <span class="material-symbols-outlined">edit</span>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </section>
                        </div>

                        <!-- Profile Setting Tab -->
                        <div x-show="activeTab === 'profile-setting'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-12">
                            <section class="bg-surface-container-lowest rounded-[2rem] p-8 custom-shadow border border-orange-50/50">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
                                    </div>
                                    <h2 class="text-2xl font-bold tracking-tight">Setting Profile</h2>
                                </div>
                                <div class="text-center py-12">
                                    <p class="text-stone-500">Modul profil pengguna sedang dalam pengembangan.</p>
                                </div>
                            </section>
                        </div>

                        <!-- Final CTA Area -->
                        <div class="flex items-center justify-between p-8 bg-surface-container-high/50 rounded-3xl backdrop-blur-sm border border-white/40">
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-secondary">info</span>
                                <p class="text-sm">Perubahan akan langsung berdampak pada aplikasi pelanggan.</p>
                            </div>
                            <div class="flex gap-4">
                                <button class="px-8 py-3 bg-white text-on-surface font-bold rounded-2xl hover:bg-stone-50 transition-all border border-stone-200">Batal</button>
                                <button class="px-10 py-3 bg-primary text-on-primary font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Payment Method Modal -->
    <template x-teleport="body">
        <div x-show="showPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showPaymentModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showPaymentModal = false"></div>
            <div x-show="showPaymentModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative bg-surface-container-lowest w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            <h3 class="text-2xl font-bold">Metode Pembayaran</h3>
                        </div>
                        <button @click="showPaymentModal = false" class="w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form action="<?= BASE_URL ?>/dashboard/settings/create-payment-method" method="post" enctype="multipart/form-data" class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1">Nama Metode</label>
                            <input name="name" type="text" placeholder="Contoh: Digital Wallet, Cash" class="w-full bg-surface-container-high border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary focus:bg-white transition-all text-on-surface" />
                        </div>
                        <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-2xl border border-transparent">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary">verified</span>
                                <p class="font-bold text-on-surface">Status Aktif</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" class="sr-only peer" checked />
                                <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showPaymentModal = false" class="flex-1 py-4 rounded-2xl font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Batal</button>
                            <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all active:scale-95">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Category Menu Modal -->
    <template x-teleport="body">
        <div x-show="showCategoryModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="showCategoryModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showCategoryModal = false"></div>
            <div x-show="showCategoryModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative bg-surface-container-lowest w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">category</span>
                            </div>
                            <h3 class="text-2xl font-bold">Kategori Menu</h3>
                        </div>
                        <button @click="showCategoryModal = false" class="w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1">Nama Kategori</label>
                            <input type="text" placeholder="Contoh: Makanan Utama, Minuman" class="w-full bg-surface-container-high border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary focus:bg-white transition-all text-on-surface" />
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1">Deskripsi Singkat</label>
                            <textarea rows="3" placeholder="Jelaskan kategori ini..." class="w-full bg-surface-container-high border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary focus:bg-white transition-all text-on-surface resize-none"></textarea>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="button" @click="showCategoryModal = false" class="flex-1 py-4 rounded-2xl font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Batal</button>
                            <button type="submit" class="flex-1 py-4 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all active:scale-95">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
    <?php include 'partials/includes/js.php'; ?>
</body>

</html>