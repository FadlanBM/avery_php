<!DOCTYPE html>
<html lang="en">

<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    <?php $activeMenu = 'menu-management'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>

    <!-- Main Content Area -->
    <main class="flex-grow lg:ml-64 h-screen flex flex-col overflow-hidden">
        <!-- TopAppBar -->
        <?php $pageTitle = 'Menu Management'; ?>
        <?php include 'partials/includes/topheader.php'; ?>

        <section class="flex-1 overflow-y-auto px-4 lg:px-10 pb-12">
            <!-- Action Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-1">
                    <p class="text-stone-500 font-medium">Kelola daftar hidangan dan ketersediaan menu Anda</p>
                </div>
                <a href="<?= BASE_URL ?>/dashboard/menu-management/add" class="bg-primary-container hover:opacity-90 text-on-primary-container px-6 py-3 rounded-xl font-bold flex items-center gap-2 transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">add</span>
                    Tambah Menu Baru
                </a>
            </div>

            <!-- Filter Section -->
            <div class="bg-surface-container-low rounded-2xl p-6 my-6">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <!-- Search Bar -->
                    <div class="relative w-full md:w-96">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">search</span>
                        <input class="w-full bg-surface-container-highest border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-primary/20 transition-all text-sm font-medium" placeholder="Cari nama hidangan..." type="text" />
                    </div>
                    <!-- Category Chips -->
                    <div class="flex gap-2 overflow-x-auto pb-1 w-full no-scrollbar">
                        <button class="px-5 py-2.5 bg-primary text-on-primary rounded-full text-sm font-semibold whitespace-nowrap">Semua</button>
                        <button class="px-5 py-2.5 bg-surface-container-highest text-on-surface-variant hover:bg-stone-200 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Makanan</button>
                        <button class="px-5 py-2.5 bg-surface-container-highest text-on-surface-variant hover:bg-stone-200 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Minuman</button>
                        <button class="px-5 py-2.5 bg-surface-container-highest text-on-surface-variant hover:bg-stone-200 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Dessert</button>
                        <button class="px-5 py-2.5 bg-surface-container-highest text-on-surface-variant hover:bg-stone-200 rounded-full text-sm font-medium whitespace-nowrap transition-colors">Promo</button>
                    </div>
                </div>
            </div>

            <!-- Bento Grid Layout for Menu Items -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Menu Card Item 1 -->
                <div class="bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10">
                    <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                        <img alt="Summer Quinoa Bowl" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="<?php echo BASE_URL; ?>/assets/images/menu/quinoa_bowl.jpg" />
                        <div class="absolute top-3 right-3 bg-secondary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider">Tersedia</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block">Makanan</span>
                                <h3 class="text-lg font-bold text-on-surface leading-tight">Summer Quinoa Bowl</h3>
                            </div>
                            <p class="text-lg font-bold text-[#C44900]">Rp 85k</p>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2">Perpaduan quinoa organik dengan sayuran musim panas dan dressing citrus segar.</p>
                        <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                            <div class="flex items-center gap-4">
                                <button class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-stone-400">Dilihat 1.2k kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Card Item 2 -->
                <div class="bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10">
                    <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                        <img alt="Sunset Lychee Mojito" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="<?php echo BASE_URL; ?>/assets/images/menu/lychee_mojito.jpg" />
                        <div class="absolute top-3 right-3 bg-secondary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider">Tersedia</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block">Minuman</span>
                                <h3 class="text-lg font-bold text-on-surface leading-tight">Sunset Lychee Mojito</h3>
                            </div>
                            <p class="text-lg font-bold text-[#C44900]">Rp 45k</p>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2">Minuman segar dengan lychee pilihan, mint, dan soda berkualitas tinggi.</p>
                        <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                            <div class="flex items-center gap-4">
                                <button class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-stone-400">Dilihat 842 kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Card Item 3 -->
                <div class="bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10">
                    <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                        <img alt="Dark Lava Fondue" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 grayscale-[50%]" src="<?php echo BASE_URL; ?>/assets/images/menu/lava_fondue.jpg" />
                        <div class="absolute top-3 right-3 bg-surface-container-highest/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-stone-400"></div>
                            <span class="text-[10px] font-bold text-stone-500 uppercase tracking-wider">Habis</span>
                        </div>
                    </div>
                    <div class="space-y-3 opacity-80">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block">Dessert</span>
                                <h3 class="text-lg font-bold text-on-surface leading-tight">Dark Lava Fondue</h3>
                            </div>
                            <p class="text-lg font-bold text-[#C44900]">Rp 65k</p>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2">Cake cokelat hangat dengan lelehan ganache premium di tengahnya.</p>
                        <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                            <div class="flex items-center gap-4">
                                <button class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-stone-400">Dilihat 2.5k kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Card Item 4 -->
                <div class="bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10">
                    <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                        <img alt="Wagyu Ribeye Steak" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="<?php echo BASE_URL; ?>/assets/images/menu/wagyu_steak.jpg" />
                        <div class="absolute top-3 right-3 bg-secondary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider">Tersedia</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block">Makanan</span>
                                <h3 class="text-lg font-bold text-on-surface leading-tight">Wagyu Ribeye Steak</h3>
                            </div>
                            <p class="text-lg font-bold text-[#C44900]">Rp 245k</p>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2">Daging wagyu pilihan dengan marbling tinggi, dipanggang sempurna.</p>
                        <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                            <div class="flex items-center gap-4">
                                <button class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-stone-400">Dilihat 3.8k kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Card Item 5 -->
                <div class="bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10">
                    <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                        <img alt="Berry Blast Smoothie" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="<?php echo BASE_URL; ?>/assets/images/menu/berry_blast_smoothie.jpg" />
                        <div class="absolute top-3 right-3 bg-secondary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                            <span class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider">Tersedia</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block">Minuman</span>
                                <h3 class="text-lg font-bold text-on-surface leading-tight">Berry Blast Smoothie</h3>
                            </div>
                            <p class="text-lg font-bold text-[#C44900]">Rp 55k</p>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2">Kombinasi berry segar dengan yogurt organik dan madu hutan.</p>
                        <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                            <div class="flex items-center gap-4">
                                <button class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                </button>
                                <button class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                    <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-stone-400">Dilihat 621 kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add New Card Placeholder -->
                <button class="border-2 border-dashed border-stone-200 dark:border-stone-800 rounded-2xl p-8 flex flex-col items-center justify-center gap-4 hover:border-primary-container/40 hover:bg-primary-container/5 transition-all group">
                    <div class="w-16 h-16 rounded-full bg-stone-100 dark:bg-stone-800 group-hover:bg-primary-container/10 flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-stone-400 group-hover:text-primary-container text-3xl">add_circle</span>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-stone-500 group-hover:text-primary-container transition-colors">Tambah Menu</p>
                        <p class="text-xs text-stone-400">Klik untuk menambah item baru</p>
                    </div>
                </button>
            </div>

            <!-- Footer Summary -->
            <div class="flex items-center justify-between pt-8 border-t border-stone-200/50 dark:border-stone-800/50">
                <p class="text-sm text-stone-500 font-medium">Menampilkan 5 dari 48 menu aktif</p>
                <div class="flex items-center gap-2">
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="w-10 h-10 rounded-full flex items-center justify-center bg-primary text-on-primary font-bold shadow-md shadow-primary/20">1</button>
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 font-bold transition-colors">2</button>
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 font-bold transition-colors">3</button>
                    <span class="px-2 text-stone-300">...</span>
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>
    </main>
    <?php include 'partials/includes/js.php'; ?>
</body>

</html>