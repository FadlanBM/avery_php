<!DOCTYPE html>
<html class="light" lang="id">
<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed h-screen overflow-hidden" x-data="{ sidebarOpen: false, showAddPlaceModal: false, showAddTableModal: false, places: [
    { id: 1, name: 'Main Hall', description: 'Area utama restoran', tablesCount: 10, available: 6 },
    { id: 2, name: 'VIP Room', description: 'Ruangan privat untuk acara khusus', tablesCount: 4, available: 2 },
    { id: 3, name: 'Terrace', description: 'Area luar ruangan dengan pemandangan', tablesCount: 6, available: 4 },
    { id: 4, name: 'Bar Lounge', description: 'Area bar dan lounge santai', tablesCount: 4, available: 2 }
], selectedPlace: null, newPlace: { name: '', description: '' } }">
    <?php $activeMenu = 'table-management'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>

    <!-- Modal Tambah Tempat -->
    <div x-show="showAddPlaceModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showAddPlaceModal = false">
        <div x-show="showAddPlaceModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-surface-container-lowest w-full max-w-md mx-4 rounded-3xl shadow-2xl overflow-hidden" @click.stop>
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-stone-200/50 bg-surface-container-low">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-on-surface font-headline">Tambah Tempat Baru</h3>
                    <button @click="showAddPlaceModal = false" class="p-2 rounded-full hover:bg-stone-200 transition-colors">
                        <span class="material-symbols-outlined text-stone-500">close</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form class="p-6 space-y-5" @submit.prevent="places.push({ id: Date.now(), name: newPlace.name, description: newPlace.description, tablesCount: 0, available: 0 }); newPlace = { name: '', description: '' }; showAddPlaceModal = false;">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Nama Tempat</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">place</span>
                        <input x-model="newPlace.name" type="text" placeholder="Contoh: Rooftop Garden" class="w-full pl-12 pr-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" required />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Deskripsi</label>
                    <textarea x-model="newPlace.description" rows="3" placeholder="Deskripsi singkat tentang area ini..." class="w-full px-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400 resize-none"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showAddPlaceModal = false" class="flex-1 px-6 py-3 bg-surface-container-high text-on-surface-variant rounded-xl font-bold hover:bg-stone-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary text-on-primary rounded-xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-95">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-grow lg:ml-64 h-screen flex flex-col overflow-hidden">
        <!-- TopNavBar -->
        <?php $pageTitle = 'Manajemen Meja'; ?>
        <?php include 'partials/includes/topheader.php'; ?>

        <!-- Page Content -->
        <section class="flex-1 overflow-y-auto px-4 lg:px-10 pb-12">
            <!-- Title and Actions -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
                <div>
                    <p class="text-sm text-stone-500 mt-1">Kelola area dan meja restoran Anda</p>
                </div>
                <div class="flex gap-3">
                    <button @click="showAddPlaceModal = true" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 active:scale-95 duration-200 hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Tempat Baru
                    </button>
                </div>
            </div>

            <!-- Places Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                <template x-for="place in places" :key="place.id">
                    <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/10 hover:shadow-xl hover:border-primary/20 transition-all cursor-pointer group" @click="selectedPlace = place">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-primary text-3xl">meeting_room</span>
                            </div>
                            <div class="flex gap-2">
                                <button @click.stop class="p-2 rounded-full hover:bg-stone-100 transition-colors">
                                    <span class="material-symbols-outlined text-stone-400 text-xl">edit</span>
                                </button>
                                <button @click.stop class="p-2 rounded-full hover:bg-red-50 transition-colors">
                                    <span class="material-symbols-outlined text-stone-400 hover:text-red-500 text-xl">delete</span>
                                </button>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-on-surface font-headline mb-1" x-text="place.name"></h3>
                        <p class="text-sm text-stone-500 mb-4 line-clamp-2" x-text="place.description"></p>
                        <div class="flex items-center justify-between pt-4 border-t border-stone-100">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-stone-400 text-lg">table_restaurant</span>
                                    <span class="text-sm font-bold text-on-surface" x-text="place.tablesCount + ' Meja'"></span>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-bold rounded-full" x-text="place.available + ' Tersedia'"></span>
                        </div>
                    </div>
                </template>

                <!-- Add New Place Card -->
                <div @click="showAddPlaceModal = true" class="border-2 border-dashed border-stone-200 rounded-3xl p-6 flex flex-col items-center justify-center gap-4 hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group min-h-[200px]">
                    <div class="w-16 h-16 rounded-full bg-stone-100 group-hover:bg-primary/10 flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-stone-400 group-hover:text-primary text-3xl transition-colors">add_circle</span>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-stone-500 group-hover:text-primary transition-colors">Tambah Tempat Baru</p>
                        <p class="text-xs text-stone-400 mt-1">Klik untuk menambah area</p>
                    </div>
                </div>
            </div>

            <!-- Selected Place Detail - Tables Section -->
            <div x-show="selectedPlace" x-transition class="bg-surface-container-low rounded-3xl p-6 mb-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-on-surface font-headline" x-text="selectedPlace?.name"></h3>
                        <p class="text-sm text-stone-500" x-text="selectedPlace?.description"></p>
                    </div>
                    <div class="flex gap-3">
                        <a :href="'<?= BASE_URL ?>/dashboard/table-management/add?place=' + selectedPlace?.id" class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:opacity-90 transition-all text-sm">
                            <span class="material-symbols-outlined text-base">add</span>
                            Tambah Meja
                        </a>
                        <button @click="selectedPlace = null" class="px-4 py-2.5 bg-surface-container-high text-on-surface-variant rounded-xl font-bold hover:bg-stone-200 transition-colors text-sm">
                            Tutup
                        </button>
                    </div>
                </div>

                <!-- Tables in Selected Place -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <template x-for="i in 6">
                        <div class="bg-surface-container-lowest rounded-2xl p-4 border border-transparent hover:shadow-lg hover:border-primary/20 transition-all text-center cursor-pointer">
                            <div class="w-12 h-12 mx-auto bg-secondary-container/30 rounded-xl flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-secondary">table_restaurant</span>
                            </div>
                            <h4 class="font-bold text-on-surface" x-text="'T-' + (i < 10 ? '0' + i : i)"></h4>
                            <p class="text-xs text-stone-500">4 orang</p>
                            <span class="inline-block mt-2 px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full">Tersedia</span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Footer Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-outline uppercase tracking-wider mb-1">Total Area</p>
                    <h4 class="text-2xl font-headline font-black text-on-surface" x-text="places.length"></h4>
                </div>
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-outline uppercase tracking-wider mb-1">Total Meja</p>
                    <h4 class="text-2xl font-headline font-black text-on-surface" x-text="places.reduce((sum, p) => sum + p.tablesCount, 0)"></h4>
                </div>
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-1">Tersedia</p>
                    <h4 class="text-2xl font-headline font-black text-secondary" x-text="places.reduce((sum, p) => sum + p.available, 0)"></h4>
                </div>
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-primary uppercase tracking-wider mb-1">Terisi</p>
                    <h4 class="text-2xl font-headline font-black text-primary" x-text="places.reduce((sum, p) => sum + (p.tablesCount - p.available), 0)"></h4>
                </div>
            </div>
        </section>
    </main>

    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 -z-10 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-0 lg:left-64 -z-10 w-[300px] h-[300px] bg-secondary/5 rounded-full blur-[100px] pointer-events-none"></div>
    <?php include 'partials/includes/js.php'; ?>
</body>

</html>