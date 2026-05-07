<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-container": "#aeefb3",
                    "background": "#fef8f1",
                    "tertiary-container": "#8d6c00",
                    "surface": "#fef8f1",
                    "on-error": "#ffffff",
                    "on-secondary-fixed-variant": "#135225",
                    "surface-container-low": "#f9f3ec",
                    "inverse-primary": "#ffb598",
                    "tertiary-fixed-dim": "#ecc156",
                    "on-background": "#1d1b17",
                    "on-tertiary-fixed-variant": "#5a4400",
                    "surface-container-highest": "#e7e2db",
                    "surface-container-lowest": "#ffffff",
                    "primary-fixed": "#ffdbce",
                    "surface-tint": "#a53c00",
                    "on-secondary-fixed": "#002109",
                    "on-primary-fixed-variant": "#7e2c00",
                    "surface-dim": "#dfd9d2",
                    "secondary-fixed": "#b1f2b5",
                    "surface-container-high": "#ede7e0",
                    "on-tertiary-container": "#fff5e8",
                    "on-secondary": "#ffffff",
                    "surface-variant": "#e7e2db",
                    "on-primary": "#ffffff",
                    "error": "#ba1a1a",
                    "primary-fixed-dim": "#ffb598",
                    "on-primary-container": "#fff5f2",
                    "secondary": "#2e6a3a",
                    "surface-bright": "#fef8f1",
                    "on-surface": "#1d1b17",
                    "outline-variant": "#e0c0b3",
                    "on-surface-variant": "#594238",
                    "tertiary": "#6f5500",
                    "tertiary-fixed": "#ffdf97",
                    "on-tertiary-fixed": "#251a00",
                    "on-error-container": "#93000a",
                    "secondary-fixed-dim": "#96d69b",
                    "on-primary-fixed": "#360f00",
                    "on-tertiary": "#ffffff",
                    "primary": "#9c3800",
                    "inverse-on-surface": "#f6f0e9",
                    "error-container": "#ffdad6",
                    "surface-container": "#f3ede6",
                    "outline": "#8c7167",
                    "on-secondary-container": "#336f3e",
                    "primary-container": "#c44900",
                    "inverse-surface": "#32302c"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Plus Jakarta Sans"],
                    "display": ["Plus Jakarta Sans"],
                    "body": ["Be Vietnam Pro"],
                    "label": ["Be Vietnam Pro"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .order-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: #fef8f1;
        }
        h1, h2, h3, .font-jakarta {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-background text-on-surface flex h-screen overflow-hidden">
<!-- Sidebar Navigation -->
<aside class="flex flex-col h-full p-4 gap-2 bg-[#fef8f1] dark:bg-stone-950 w-64 shrink-0">
<div class="mb-8 px-4 py-2">
<h1 class="text-2xl font-bold tracking-tight text-[#9C3800] dark:text-[#C44900] font-jakarta">Saffron &amp; Sage</h1>
<p class="text-xs text-stone-500 font-medium">Sensory Hearth KDS</p>
</div>
<nav class="flex-1 space-y-2">
<!-- Active Navigation Item -->
<a class="flex items-center gap-3 px-4 py-3 bg-[#9C3800] text-white rounded-xl shadow-lg shadow-[#9C3800]/20 scale-95 active:scale-90 transition-transform font-jakarta text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
                Pesanan Aktif
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-stone-600 dark:text-stone-400 hover:text-[#9C3800] hover:bg-orange-50 dark:hover:bg-stone-800 rounded-xl transition-all font-jakarta text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="history">history</span>
                Riwayat
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-stone-600 dark:text-stone-400 hover:text-[#9C3800] hover:bg-orange-50 dark:hover:bg-stone-800 rounded-xl transition-all font-jakarta text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                Stok Bahan
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-stone-600 dark:text-stone-400 hover:text-[#9C3800] hover:bg-orange-50 dark:hover:bg-stone-800 rounded-xl transition-all font-jakarta text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="restaurant_menu">restaurant_menu</span>
                Manajemen
            </a>
</nav>
<div class="mt-auto p-4 bg-surface-container-low rounded-2xl flex items-center gap-3">
<img alt="Chef de Cuisine" class="w-10 h-10 rounded-full object-cover shadow-sm" data-alt="portrait of a professional chef in white uniform with a focused expression in a dimly lit commercial kitchen" src="<?= BASE_URL ?>/assets/images/kitchen_dashboard/chef_headshot.jpg"/>
<div>
<p class="text-sm font-bold font-jakarta text-on-surface">Dapur Utama</p>
<p class="text-xs text-stone-500">Station 1</p>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-surface-container-low dark:bg-stone-900 rounded-l-[2.5rem]">
<!-- Top App Bar -->
<header class="flex justify-between items-center w-full px-8 py-6">
<div class="flex items-center gap-4">
<h2 class="text-2xl font-bold font-jakarta text-on-surface">Monitor Pesanan</h2>
<span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-bold uppercase tracking-wider">8 Aktif</span>
</div>
<div class="flex items-center gap-6">
<div class="relative flex items-center bg-surface-container-lowest rounded-full px-4 py-2 w-64 shadow-sm">
<span class="material-symbols-outlined text-stone-400 text-lg mr-2" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-stone-400" placeholder="Cari Order ID..." type="text"/>
</div>
<div class="flex gap-2">
<button class="p-2 text-stone-500 hover:bg-stone-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-stone-500 hover:bg-stone-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
</div>
</div>
</header>
<!-- KDS Grid Dashboard -->
<section class="flex-1 overflow-y-auto p-8 pt-2">
<div class="order-card-grid">
<!-- Order Card 1 (Active) -->
<div class="bg-surface-container-lowest rounded-[2rem] p-6 shadow-sm flex flex-col h-full hover:shadow-xl transition-shadow duration-300">
<div class="flex justify-between items-start mb-6">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="w-2 h-2 bg-primary rounded-full"></span>
<p class="text-xs font-bold text-primary uppercase tracking-widest font-jakarta">Sedang Dimasak</p>
</div>
<h3 class="text-xl font-extrabold font-jakarta">Meja 08</h3>
<p class="text-xs text-stone-400 font-medium tracking-tight">ID: #SS-9281</p>
</div>
<div class="bg-surface-container-low px-3 py-2 rounded-2xl flex flex-col items-end">
<span class="text-[10px] text-stone-500 font-bold uppercase">Elapsed</span>
<span class="text-sm font-bold font-jakarta text-on-surface">12:45</span>
</div>
</div>
<div class="flex-1 space-y-4 mb-6">
<div class="flex items-start gap-3 group">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5 transition-all" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">Nasi Goreng Saffron Signature</p>
<p class="text-xs text-stone-500 mt-0.5">Note: Ekstra Pedas, No Telur</p>
</div>
</div>
<div class="flex items-start gap-3 opacity-60">
<input checked="" class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight line-through">Es Teh Sereh Madu</p>
</div>
</div>
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">Sate Ayam Bumbu Sage (10)</p>
</div>
</div>
</div>
<button class="w-full py-4 bg-secondary text-white rounded-2xl font-bold font-jakarta text-sm shadow-lg shadow-secondary/20 hover:brightness-110 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
                        Ready for Delivery
                    </button>
</div>
<!-- Order Card 2 (New/Waiting) -->
<div class="bg-surface-container-lowest rounded-[2rem] p-6 shadow-sm flex flex-col h-full border-2 border-primary/10">
<div class="flex justify-between items-start mb-6">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="w-2 h-2 bg-stone-300 rounded-full animate-pulse"></span>
<p class="text-xs font-bold text-stone-500 uppercase tracking-widest font-jakarta">Menunggu</p>
</div>
<h3 class="text-xl font-extrabold font-jakarta">Meja 12</h3>
<p class="text-xs text-stone-400 font-medium tracking-tight">ID: #SS-9285</p>
</div>
<div class="bg-primary/5 px-3 py-2 rounded-2xl flex flex-col items-end">
<span class="text-[10px] text-primary/70 font-bold uppercase">Just In</span>
<span class="text-sm font-bold font-jakarta text-primary">02:10</span>
</div>
</div>
<div class="flex-1 space-y-4 mb-6">
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight font-jakarta">Bebek Betutu Sage Crust</p>
<span class="inline-block mt-1 px-2 py-0.5 bg-tertiary/10 text-tertiary text-[10px] rounded-md font-bold uppercase">Chef's Recommend</span>
</div>
</div>
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight font-jakarta">Plecing Kangkung</p>
</div>
</div>
</div>
<button class="w-full py-4 bg-primary text-white rounded-2xl font-bold font-jakarta text-sm shadow-lg shadow-primary/20 hover:brightness-110 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="local_fire_department">local_fire_department</span>
                        Start Cooking
                    </button>
</div>
<!-- Order Card 3 -->
<div class="bg-surface-container-lowest rounded-[2rem] p-6 shadow-sm flex flex-col h-full">
<div class="flex justify-between items-start mb-6">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="w-2 h-2 bg-primary rounded-full"></span>
<p class="text-xs font-bold text-primary uppercase tracking-widest font-jakarta">Sedang Dimasak</p>
</div>
<h3 class="text-xl font-extrabold font-jakarta">Meja 02</h3>
<p class="text-xs text-stone-400 font-medium tracking-tight">ID: #SS-9278</p>
</div>
<div class="bg-error/5 px-3 py-2 rounded-2xl flex flex-col items-end">
<span class="text-[10px] text-error font-bold uppercase tracking-tighter">Overdue</span>
<span class="text-sm font-bold font-jakarta text-error">24:18</span>
</div>
</div>
<div class="flex-1 space-y-4 mb-6">
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">Grilled Salmon with Sage Butter</p>
<p class="text-xs text-stone-500 mt-0.5">Note: Medium Well</p>
</div>
</div>
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">Mashed Potato Truffle</p>
</div>
</div>
</div>
<button class="w-full py-4 bg-secondary text-white rounded-2xl font-bold font-jakarta text-sm shadow-lg shadow-secondary/20 hover:brightness-110 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="check_circle">check_circle</span>
                        Ready for Delivery
                    </button>
</div>
<!-- Order Card 4 (Large Takeaway Order) -->
<div class="bg-surface-container-lowest rounded-[2rem] p-6 shadow-sm flex flex-col h-full md:col-span-1">
<div class="flex justify-between items-start mb-6">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="w-2 h-2 bg-orange-400 rounded-full"></span>
<p class="text-xs font-bold text-orange-400 uppercase tracking-widest font-jakarta">Takeaway</p>
</div>
<h3 class="text-xl font-extrabold font-jakarta">Web Order</h3>
<p class="text-xs text-stone-400 font-medium tracking-tight">ID: #SS-9289</p>
</div>
<div class="bg-surface-container-low px-3 py-2 rounded-2xl flex flex-col items-end">
<span class="text-[10px] text-stone-500 font-bold uppercase">Elapsed</span>
<span class="text-sm font-bold font-jakarta text-on-surface">08:22</span>
</div>
</div>
<div class="flex-1 space-y-4 mb-6">
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">3x Paket Bento Premium</p>
<p class="text-xs text-stone-500 mt-0.5">Include: Cutlery, Sambal Extra</p>
</div>
</div>
<div class="flex items-start gap-3">
<input class="mt-1 rounded border-stone-300 text-primary focus:ring-primary h-5 w-5" type="checkbox"/>
<div class="flex-1">
<p class="text-sm font-bold text-on-surface leading-tight">2x Jus Alpukat Kocok</p>
</div>
</div>
</div>
<button class="w-full py-4 bg-primary text-white rounded-2xl font-bold font-jakarta text-sm shadow-lg shadow-primary/20 hover:brightness-110 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="local_fire_department">local_fire_department</span>
                        Start Cooking
                    </button>
</div>
</div>
</section>
<!-- Bottom Status Bar (Simplified) -->
<footer class="bg-white/80 dark:bg-stone-900/80 backdrop-blur-md px-8 py-4 flex justify-between items-center z-10">
<div class="flex gap-8">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-stone-400 text-sm" data-icon="hourglass_top">hourglass_top</span>
<span class="text-xs font-bold uppercase tracking-wider text-stone-500">Antrean: 3</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-sm" data-icon="local_fire_department">local_fire_department</span>
<span class="text-xs font-bold uppercase tracking-wider text-primary">Masak: 5</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-sm" data-icon="check_circle">check_circle</span>
<span class="text-xs font-bold uppercase tracking-wider text-secondary">Selesai: 12 (Hari Ini)</span>
</div>
</div>
<div class="flex items-center gap-4 text-xs font-medium text-stone-400">
<span>Last Updated: Just now</span>
<button class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></button>
</div>
</footer>
</main>
<!-- Mobile Bottom Navigation (Visible on mobile only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-end px-6 pb-6 bg-white/80 dark:bg-stone-900/80 backdrop-blur-md shadow-[0_-8px_24px_-4px_rgba(156,56,0,0.06)] rounded-t-3xl">
<div class="flex flex-col items-center justify-center bg-[#9C3800] text-white rounded-2xl p-3 mb-2 animate-pulse-slow">
<span class="material-symbols-outlined" data-icon="hourglass_top">hourglass_top</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Antrean</span>
</div>
<div class="flex flex-col items-center justify-center text-stone-400 dark:text-stone-500 p-2 hover:text-[#9C3800]">
<span class="material-symbols-outlined" data-icon="local_fire_department">local_fire_department</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Masak</span>
</div>
<div class="flex flex-col items-center justify-center text-stone-400 dark:text-stone-500 p-2 hover:text-[#9C3800]">
<span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Saji</span>
</div>
</nav>
</body></html>