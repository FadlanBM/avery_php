<?php
$pageTitle = $pageTitle ?? 'Ringkasan Dashboard';
?>
<!-- TopAppBar -->
<header class="sticky top-0 bg-[#fef8f1]/80 dark:bg-stone-950/80 backdrop-blur-xl flex items-center justify-between w-full px-4 lg:px-8 py-4">
    <div class="flex items-center gap-4">
        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h2 class="text-xl lg:text-2xl font-['Plus_Jakarta_Sans'] font-extrabold tracking-tight text-[#1d1b17] dark:text-stone-50"><?= htmlspecialchars($pageTitle) ?></h2>
        <?php if (isset($dateRange)): ?>
            <div class="hidden md:flex items-center gap-2 bg-surface-container-high px-4 py-2 rounded-full text-sm font-medium text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                <span><?= htmlspecialchars($dateRange) ?></span>
                <span class="material-symbols-outlined text-sm">expand_more</span>
            </div>
        <?php endif; ?>
    </div>
</header>