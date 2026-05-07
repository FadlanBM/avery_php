 <?php
    $beforePageTitle = $beforePageTitle ?? 'Menu';
    $pageTitle = $pageTitle ?? 'Ringkasan Dashboard';
    ?>

<header class="h-20 border-b border-stone-200/50 dark:border-stone-800/50 bg-white/80 dark:bg-stone-950/80 backdrop-blur-md sticky top-0 z-20 px-4 lg:px-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <nav class="flex items-center gap-2 text-xs font-medium text-stone-400 font-['Plus_Jakarta_Sans']">
            <?php if (isset($beforePageTitle)): ?>
                <span><?= htmlspecialchars($beforePageTitle) ?></span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <?php endif; ?>
            <span class="text-primary tracking-wide uppercase font-bold"><?= htmlspecialchars($pageTitle ?? 'Tambah') ?></span>
        </nav>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <span class="material-symbols-outlined text-stone-600 p-2 hover:bg-orange-50 rounded-full cursor-pointer transition-colors">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full border-2 border-white"></span>
        </div>
    </div>
</header>