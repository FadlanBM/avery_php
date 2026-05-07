<?php
$activeMenu = $activeMenu ?? 'home';
$menuItems = [
    'home' => ['icon' => 'dashboard', 'label' => 'Home', 'url' => BASE_URL . '/dashboard'],
    'menu-management' => ['icon' => 'menu_book', 'label' => 'Manajemen Menu', 'url' => BASE_URL . '/dashboard/menu-management'],
    'table-management' => ['icon' => 'grid_view', 'label' => 'Denah Meja', 'url' => BASE_URL . '/dashboard/table-management'],
    'settings' => ['icon' => 'settings', 'label' => 'Settings', 'url' => BASE_URL . '/dashboard/settings'],
];
?>
<div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
<nav :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed left-0 top-0 h-screen w-64 bg-stone-50 dark:bg-stone-900 flex flex-col py-8 px-6 space-y-2 z-40 border-r border-stone-200/50 dark:border-stone-800/50 transition-transform duration-300">
    <div class="mb-10 px-2">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined">restaurant</span>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#9C3800]">Saffron &amp; Sage</h1>
                <p class="text-[10px] uppercase tracking-widest text-stone-500 font-bold">Management Portal</p>
            </div>
        </div>
    </div>
    <div class="space-y-1">
        <?php foreach ($menuItems as $key => $item): ?>
            <?php $isActive = $activeMenu === $key; ?>
            <a class="flex items-center gap-3 px-4 py-3 <?= $isActive ? 'text-[#9C3800] font-bold bg-[#9C3800]/10 scale-95' : 'text-stone-600 dark:text-stone-400 hover:text-stone-900 dark:hover:text-stone-100 hover:bg-stone-200 dark:hover:bg-stone-800' ?> transition-all rounded-lg duration-150 ease-in-out" href="<?= $item['url'] ?>">
                <span class="material-symbols-outlined" <?= $isActive ? "style=\"font-variation-settings: 'FILL' 1;\"" : '' ?>><?= $item['icon'] ?></span>
                <span class="font-['Plus_Jakarta_Sans'] text-sm font-medium"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="mt-auto pt-6 border-t border-stone-200 dark:border-stone-800">
        <div class="flex items-center gap-3 px-2">
            <img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="<?php echo BASE_URL; ?>/assets/images/admin/avatar_julian.jpg" />
            <div class="overflow-hidden">
                <p class="text-sm font-bold truncate">Chef Julian</p>
                <p class="text-xs text-stone-500">Executive Admin</p>
            </div>
        </div>
    </div>
</nav>