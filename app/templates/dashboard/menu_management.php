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
                        <input id="search-input" class="w-full bg-surface-container-highest border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-primary/20 transition-all text-sm font-medium" placeholder="Cari nama hidangan..." type="text" />
                    </div>
                    <!-- Category Chips -->
                    <div class="flex gap-2 overflow-x-auto pb-1 w-full no-scrollbar" id="category-chips-container">
                        <button data-category-id="all" class="category-chip px-5 py-2.5 bg-primary text-on-primary rounded-full text-sm font-semibold whitespace-nowrap transition-colors">Semua</button>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <button data-category-id="<?= $category->id ?>" class="category-chip px-5 py-2.5 bg-surface-container-highest text-on-surface-variant hover:bg-stone-200 rounded-full text-sm font-medium whitespace-nowrap transition-colors">
                                    <?= htmlspecialchars($category->name) ?>
                                </button>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Bento Grid Layout for Menu Items -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="menu-cards-container">
                <!-- No Results Placeholder -->
                <div id="no-results-placeholder" class="col-span-full py-12 text-center text-stone-400 font-medium hidden">
                    Menu tidak ditemukan.
                </div>

                <?php if (!empty($menus)): ?>
                    <?php foreach ($menus as $menu):
                        $isAvailable = (bool)$menu->is_available;
                        $categoryName = $menu->getCategoryName();
                        $assets = $menu->getAssets();
                        $primaryImage = !empty($assets) ? BASE_URL . '/' . ltrim($assets[0]['file_path'], '/') : BASE_URL . '/assets/images/menu/placeholder.jpg';
                        $price = (float)$menu->price;
                        $priceFormatted = '';
                        if ($price >= 1000 && $price % 1000 === 0) {
                            $priceFormatted = 'Rp ' . ($price / 1000) . 'k';
                        } else {
                            $priceFormatted = 'Rp ' . number_format($price, 0, ',', '.');
                        }
                    ?>
                        <!-- Menu Card Item -->
                        <div class="menu-card bg-surface-container-lowest group relative rounded-2xl p-4 transition-all hover:shadow-[0_20px_50px_rgba(156,56,0,0.1)] overflow-hidden border border-outline-variant/10"
                            data-name="<?= htmlspecialchars(strtolower($menu->name)) ?>"
                            data-category-id="<?= $menu->category_id ?>">
                            <div class="relative h-48 mb-4 overflow-hidden rounded-xl">
                                <img alt="<?= htmlspecialchars($menu->name) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 <?= !$isAvailable ? 'grayscale-[50%]' : '' ?>" src="<?= $primaryImage ?>" />
                                <?php if ($isAvailable): ?>
                                    <div class="absolute top-3 right-3 bg-secondary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                                        <div class="w-1.5 h-1.5 rounded-full bg-secondary"></div>
                                        <span class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider">Tersedia</span>
                                    </div>
                                <?php else: ?>
                                    <div class="absolute top-3 right-3 bg-surface-container-highest/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5">
                                        <div class="w-1.5 h-1.5 rounded-full bg-stone-400"></div>
                                        <span class="text-[10px] font-bold text-stone-500 uppercase tracking-wider">Habis</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="space-y-3 <?= !$isAvailable ? 'opacity-80' : '' ?>">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-[10px] font-bold text-primary tracking-widest uppercase mb-1 block"><?= htmlspecialchars($categoryName) ?></span>
                                        <h3 class="text-lg font-bold text-on-surface leading-tight"><?= htmlspecialchars($menu->name) ?></h3>
                                    </div>
                                    <p class="text-lg font-bold text-[#C44900] whitespace-nowrap"><?= $priceFormatted ?></p>
                                </div>
                                <p class="text-sm text-stone-500 line-clamp-2"><?= htmlspecialchars($menu->description) ?></p>
                                <div class="pt-4 flex items-center justify-between border-t border-stone-100 dark:border-stone-800">
                                    <div class="flex items-center gap-4">
                                        <a href="<?= BASE_URL ?>/dashboard/menu-management/edit?id=<?= $menu->id ?>" class="text-stone-400 hover:text-primary transition-colors flex items-center gap-1 group/btn">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                            <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Edit</span>
                                        </a>
                                        <button onclick="confirmDeleteMenu(<?= $menu->id ?>, '<?= addslashes(htmlspecialchars($menu->name)) ?>')" class="text-stone-400 hover:text-error transition-colors flex items-center gap-1 group/btn">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                            <span class="text-xs font-bold opacity-0 group-hover/btn:opacity-100 transition-opacity">Hapus</span>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-stone-400">Stok: <?= (int)$menu->stock ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full py-12 text-center text-stone-400 font-medium">
                        Belum ada menu yang terdaftar.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Summary -->
            <div class="flex items-center justify-between pt-8 border-t border-stone-200/50 dark:border-stone-800/50">
                <p class="text-sm text-stone-500 font-medium">Menampilkan <span id="displayed-menu-count" class="font-bold text-on-surface">0</span> dari <span id="total-menu-count" class="font-bold text-on-surface"><?= count($menus) ?></span> menu aktif</p>
                <div class="flex items-center gap-2" id="pagination-container">
                    <!-- Pagination buttons are rendered dynamically -->
                </div>
            </div>
        </section>
    </main>
    <?php include 'partials/includes/js.php'; ?>

    <!-- Hidden Form for Menu Deletion -->
    <form id="delete-menu-form" action="<?= BASE_URL ?>/dashboard/menu-management/delete" method="POST" class="hidden">
        <input type="hidden" name="id" id="delete-menu-id">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const categoryChips = document.querySelectorAll('.category-chip');
            const menuCards = document.querySelectorAll('.menu-card');
            const noResultsPlaceholder = document.getElementById('no-results-placeholder');
            const displayedCountEl = document.getElementById('displayed-menu-count');
            const totalCountEl = document.getElementById('total-menu-count');
            const paginationContainer = document.getElementById('pagination-container');

            const ITEMS_PER_PAGE = 20;
            let currentPage = 1;
            let activeSearch = '';
            let activeCategory = 'all';

            function filterMenu() {
                // 1. Filter elements by Category and Search
                const matchingCards = [];
                menuCards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    const categoryId = card.getAttribute('data-category-id');

                    const matchesSearch = name.includes(activeSearch);
                    const matchesCategory = activeCategory === 'all' || categoryId === activeCategory;

                    if (matchesSearch && matchesCategory) {
                        matchingCards.push(card);
                    } else {
                        card.style.display = 'none';
                    }
                });

                // 2. Handle empty results
                const totalMatching = matchingCards.length;
                if (totalMatching === 0) {
                    if (menuCards.length > 0) {
                        noResultsPlaceholder.classList.remove('hidden');
                    }
                    if (displayedCountEl) displayedCountEl.innerText = '0';
                    if (totalCountEl) totalCountEl.innerText = '0';
                    if (paginationContainer) paginationContainer.style.display = 'none';
                    return;
                } else {
                    noResultsPlaceholder.classList.add('hidden');
                }

                // 3. Paginate filtered results
                const totalPages = Math.ceil(totalMatching / ITEMS_PER_PAGE);
                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                if (currentPage < 1) {
                    currentPage = 1;
                }

                const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
                const endIndex = Math.min(startIndex + ITEMS_PER_PAGE, totalMatching);

                matchingCards.forEach((card, index) => {
                    if (index >= startIndex && index < endIndex) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // 4. Update counters
                if (displayedCountEl) {
                    displayedCountEl.innerText = `${startIndex + 1}-${endIndex}`;
                }
                if (totalCountEl) {
                    totalCountEl.innerText = totalMatching;
                }

                // 5. Render pagination controls
                renderPaginationControls(totalPages);
            }

            function renderPaginationControls(totalPages) {
                if (!paginationContainer) return;
                paginationContainer.innerHTML = '';

                if (totalPages <= 1) {
                    paginationContainer.style.display = 'none';
                    return;
                }
                paginationContainer.style.display = 'flex';

                // Previous Button
                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.className = `w-10 h-10 rounded-full flex items-center justify-center transition-colors ${currentPage === 1 ? 'text-stone-300 cursor-not-allowed' : 'text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800'}`;
                prevBtn.innerHTML = '<span class="material-symbols-outlined">chevron_left</span>';
                if (currentPage > 1) {
                    prevBtn.addEventListener('click', () => {
                        currentPage--;
                        filterMenu();
                    });
                }
                paginationContainer.appendChild(prevBtn);

                // Page Number Buttons
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.type = 'button';
                    if (i === currentPage) {
                        pageBtn.className = 'w-10 h-10 rounded-full flex items-center justify-center bg-primary text-on-primary font-bold shadow-md shadow-primary/20';
                    } else {
                        pageBtn.className = 'w-10 h-10 rounded-full flex items-center justify-center text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 font-bold transition-colors';
                    }
                    pageBtn.innerText = i;
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        filterMenu();
                    });
                    paginationContainer.appendChild(pageBtn);
                }

                // Next Button
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = `w-10 h-10 rounded-full flex items-center justify-center transition-colors ${currentPage === totalPages ? 'text-stone-300 cursor-not-allowed' : 'text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800'}`;
                nextBtn.innerHTML = '<span class="material-symbols-outlined">chevron_right</span>';
                if (currentPage < totalPages) {
                    nextBtn.addEventListener('click', () => {
                        currentPage++;
                        filterMenu();
                    });
                }
                paginationContainer.appendChild(nextBtn);
            }

            // Search input listener
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    activeSearch = e.target.value.toLowerCase().trim();
                    currentPage = 1; // Reset to page 1 on search
                    filterMenu();
                });
            }

            // Category chips listener
            categoryChips.forEach(chip => {
                chip.addEventListener('click', function() {
                    // Update active classes
                    categoryChips.forEach(c => {
                        c.classList.remove('bg-primary', 'text-on-primary', 'font-semibold');
                        c.classList.add('bg-surface-container-highest', 'text-on-surface-variant', 'font-medium');
                    });

                    chip.classList.add('bg-primary', 'text-on-primary', 'font-semibold');
                    chip.classList.remove('bg-surface-container-highest', 'text-on-surface-variant', 'font-medium');

                    activeCategory = chip.getAttribute('data-category-id');
                    currentPage = 1; // Reset to page 1 on filter change
                    filterMenu();
                });
            });

            // Initial filter run
            filterMenu();
        });

        function confirmDeleteMenu(id, name) {
            Swal.fire({
                title: 'Hapus Menu?',
                text: 'Apakah Anda yakin ingin menghapus "' + name + '" dari daftar menu?',
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
                    document.getElementById('delete-menu-id').value = id;
                    document.getElementById('delete-menu-form').submit();
                }
            });
        }
    </script>
</body>

</html>