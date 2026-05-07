<!DOCTYPE html>
<html lang="en">
<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-background h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    <?php $activeMenu = 'home'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>
    <!-- Main Content Area -->
    <main class="flex-grow lg:ml-64 h-screen flex flex-col overflow-hidden">
        <?php $pageTitle = 'Dashboard'; ?>
        <?php $dateRange = 'Jan 1, 2024 - Today'; ?>
        <?php include 'partials/includes/topheader.php'; ?>
        <div class="flex-1 overflow-y-auto p-4 lg:p-8 space-y-6 lg:space-y-8">
            <!-- Statistics Grid -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Sales -->
                <div class="bg-surface  -container-lowest p-6 rounded-xl border border-outline-variant/10 group hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-primary-fixed rounded-xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <span class="text-secondary font-bold text-xs bg-secondary-container px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            12%
                        </span>
                    </div>
                    <p class="text-stone-500 text-sm font-medium mb-1">Total Sales</p>
                    <h3 class="text-2xl font-extrabold text-on-surface">Rp 12.450.000</h3>
                    <p class="text-[10px] text-stone-400 mt-2 uppercase tracking-tighter">vs. Yesterday</p>
                </div>
                <!-- Orders -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 group hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-tertiary-fixed rounded-xl flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined">shopping_bag</span>
                        </div>
                        <span class="text-primary font-bold text-xs bg-primary-fixed px-2 py-1 rounded-full">Live Now</span>
                    </div>
                    <p class="text-stone-500 text-sm font-medium mb-1">Active Orders</p>
                    <h3 class="text-2xl font-extrabold text-on-surface">24 <span class="text-lg font-medium text-stone-400 italic">active</span></h3>
                    <p class="text-[10px] text-stone-400 mt-2 uppercase tracking-tighter">8 in preparation</p>
                </div>
                <!-- Ticket -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 group hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-secondary-fixed rounded-xl flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined">confirmation_number</span>
                        </div>
                    </div>
                    <p class="text-stone-500 text-sm font-medium mb-1">Average Ticket</p>
                    <h3 class="text-2xl font-extrabold text-on-surface">Rp 155.000</h3>
                    <p class="text-[10px] text-stone-400 mt-2 uppercase tracking-tighter">Per Customer</p>
                </div>
                <!-- Occupancy -->
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 group hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-stone-200 rounded-xl flex items-center justify-center text-stone-600">
                            <span class="material-symbols-outlined">chair_alt</span>
                        </div>
                        <div class="w-16 h-2 bg-stone-100 rounded-full mt-3 overflow-hidden">
                            <div class="w-[85%] h-full bg-secondary"></div>
                        </div>
                    </div>
                    <p class="text-stone-500 text-sm font-medium mb-1">Table Occupancy</p>
                    <h3 class="text-2xl font-extrabold text-on-surface">85%</h3>
                    <p class="text-[10px] text-stone-400 mt-2 uppercase tracking-tighter">Peak Capacity</p>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sales Performance -->
                <div
                    class="lg:col-span-2 bg-surface-container-low p-8 relative rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Monthly Sales
                        </h3>

                        <div x-data="{openDropDown: false}" class="relative h-fit">
                            <button
                                @click="openDropDown = !openDropDown"
                                :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'">
                                <svg
                                    class="fill-current"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                                        fill="" />
                                </svg>
                            </button>
                            <div
                                x-show="openDropDown"
                                @click.outside="openDropDown = false"
                                class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 top-full rounded-2xl shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                                <button
                                    class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                    View More
                                </button>
                                <button
                                    class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                        <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
                            <div
                                id="chartOne"
                                class="-ml-5 h-full min-w-[650px] pl-2 xl:min-w-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Popular Items (Editorial Style) -->
                <div class="bg-surface-container-lowest p-8 rounded-3xl border border-outline-variant/10">
                    <h3 class="text-xl font-bold mb-6">Popular Items</h3>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group">
                            <img alt="Saffron Risotto" class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform" src="<?php echo BASE_URL; ?>/assets/images/dashboard/saffron_risotto.jpg" />
                            <div class="flex-1">
                                <h4 class="font-bold text-sm">Saffron Risotto</h4>
                                <p class="text-xs text-stone-500">142 orders</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">Rp 12.5M</p>
                                <p class="text-[10px] text-secondary font-bold">+5%</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <img alt="Wagyu Steak" class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform" src="<?php echo BASE_URL; ?>/assets/images/dashboard/wagyu_steak.jpg" />
                            <div class="flex-1">
                                <h4 class="font-bold text-sm">Wagyu MB5+</h4>
                                <p class="text-xs text-stone-500">98 orders</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">Rp 34.2M</p>
                                <p class="text-[10px] text-stone-400 font-bold">--</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <img alt="Sage Burger" class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform" src="<?php echo BASE_URL; ?>/assets/images/dashboard/sage_burger.jpg" />
                            <div class="flex-1">
                                <h4 class="font-bold text-sm">Sage Burger</h4>
                                <p class="text-xs text-stone-500">85 orders</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">Rp 9.8M</p>
                                <p class="text-[10px] text-error font-bold">-2%</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <img alt="Truffle Pasta" class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform" src="<?php echo BASE_URL; ?>/assets/images/dashboard/truffle_pasta.jpg" />
                            <div class="flex-1">
                                <h4 class="font-bold text-sm">Truffle Pasta</h4>
                                <p class="text-xs text-stone-500">76 orders</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">Rp 11.4M</p>
                                <p class="text-[10px] text-secondary font-bold">+12%</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group">
                            <img alt="Lava Cake" class="w-14 h-14 rounded-xl object-cover group-hover:scale-105 transition-transform" src="<?php echo BASE_URL; ?>/assets/images/dashboard/lava_cake.jpg" />
                            <div class="flex-1">
                                <h4 class="font-bold text-sm">Lava Cake</h4>
                                <p class="text-xs text-stone-500">64 orders</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-primary text-sm">Rp 4.2M</p>
                                <p class="text-[10px] text-secondary font-bold">+15%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recent Orders Table -->
            <section class="bg-surface-container-low rounded-3xl overflow-hidden">
                <div class="px-8 py-6 flex justify-between items-center bg-surface-container-high/30">
                    <div>
                        <h3 class="text-xl font-bold">Pesanan Terbaru</h3>
                        <p class="text-sm text-stone-500">Real-time order monitoring</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-stone-400 font-black border-b border-stone-200/50">
                                <th class="px-8 py-4">Order ID</th>
                                <th class="px-4 py-4">Table #</th>
                                <th class="px-4 py-4">Items</th>
                                <th class="px-4 py-4">Total Price</th>
                                <th class="px-4 py-4">Status</th>
                                <th class="px-8 py-4 text-right">Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="hover:bg-surface-container-high/20 transition-colors">
                                <td class="px-8 py-5 font-bold">#ORD-8842</td>
                                <td class="px-4 py-5"><span class="bg-stone-200 px-2 py-1 rounded text-xs font-bold">TB-04</span></td>
                                <td class="px-4 py-5 text-stone-600">Saffron Risotto (x2), Iced Tea (x2)</td>
                                <td class="px-4 py-5 font-bold">Rp 340.000</td>
                                <td class="px-4 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-fixed text-primary font-bold text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> Cooking
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right text-stone-500">12:45 PM</td>
                            </tr>
                            <tr class="hover:bg-surface-container-high/20 transition-colors">
                                <td class="px-8 py-5 font-bold">#ORD-8841</td>
                                <td class="px-4 py-5"><span class="bg-stone-200 px-2 py-1 rounded text-xs font-bold">TB-12</span></td>
                                <td class="px-4 py-5 text-stone-600">Wagyu Steak (x1), Red Wine (x1)</td>
                                <td class="px-4 py-5 font-bold">Rp 890.000</td>
                                <td class="px-4 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary-fixed text-tertiary font-bold text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Ready
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right text-stone-500">12:42 PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-4 border-t border-stone-200/50 flex justify-center">
                    <button class="text-primary font-bold text-sm hover:underline">Lihat Semua Pesanan</button>
                </div>
            </section>
        </div>
    </main>
    <?php include 'partials/includes/js.php'; ?>
</body>

</html>