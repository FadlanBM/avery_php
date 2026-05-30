<!DOCTYPE html>
<html class="light" lang="id">
<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed h-screen overflow-hidden" x-data="{ 
    sidebarOpen: false, 
    showAddPlaceModal: false, 
    showAddTableModal: false, 
    places: <?= htmlspecialchars(json_encode(array_map(fn($a) => ['id' => $a->id, 'name' => $a->name, 'description' => $a->description, 'tablesCount' => $a->tablesCount ?? 0, 'available' => $a->available ?? 0], $areas))) ?>, 
    selectedPlace: null, 
    newPlace: { id: '', name: '', description: '' },
    editPlaceMode: false,
    tables: [],
    newTable: { nomor_meja: '', kapasitas: 4, active: true, area_id: '' },
    async openEditPlace(id) {
        try {
            const response = await fetch('<?= BASE_URL ?>/dashboard/table-management/get-area?id=' + id);
            const text = await response.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Raw Response:', text);
                Swal.fire('Error', 'Format data tidak valid.', 'error');
                return;
            }

            if (data.success) {
                this.newPlace = {
                    id: data.area.id,
                    name: data.area.name,
                    description: data.area.description
                };
                this.editPlaceMode = true;
                this.showAddPlaceModal = true;
            } else {
                Swal.fire('Gagal', data.message || 'Gagal mengambil data', 'error');
            }
        } catch (e) {
            console.error(e);
            Swal.fire('Error', 'Terjadi kesalahan saat memuat data.', 'error');
        }
    },
    resetPlaceForm() {
        this.newPlace = { id: '', name: '', description: '' };
        this.editPlaceMode = false;
        this.showAddPlaceModal = true;
    },
    async fetchTables(placeId) {
        if (!placeId) return;
        try {
            const response = await fetch('<?= BASE_URL ?>/dashboard/table-management/get-tables?area_id=' + placeId);
            const data = await response.json();
            if (data.success) {
                this.tables = data.tables;
            } else {
                console.error(data.message);
            }
        } catch (e) {
            console.error(e);
        }
    },
    selectPlace(place) {
        this.selectedPlace = place;
        this.tables = [];
        if (place) {
            this.fetchTables(place.id);
        }
    },
    generateNextTableNumber() {
        if (!this.tables || this.tables.length === 0) {
            return 'T-01';
        }
        
        let maxNum = 0;
        let prefix = 'T-';
        let padLength = 2;
        
        // Coba deteksi format meja pertama
        const sample = this.tables[0].nomor_meja;
        const match = sample.match(/^([^\d]*?)(\d+)$/);
        if (match) {
            prefix = match[1];
            padLength = match[2].length;
        }
        
        this.tables.forEach(t => {
            const m = t.nomor_meja.match(/^([^\d]*?)(\d+)$/);
            if (m) {
                const num = parseInt(m[2], 10);
                if (num > maxNum) {
                    maxNum = num;
                }
            }
        });
        
        const nextNum = maxNum + 1;
        const paddedNum = String(nextNum).padStart(padLength, '0');
        return prefix + paddedNum;
    },
    openAddTable() {
        if (!this.selectedPlace) return;
        const nextNo = this.generateNextTableNumber();
        this.newTable = { nomor_meja: nextNo, kapasitas: 4, active: true, area_id: this.selectedPlace.id };
        this.showAddTableModal = true;
    },
    confirmDeleteTable(id, nomorMeja) {
        Swal.fire({
            title: 'Hapus Meja?',
            text: 'Apakah Anda yakin ingin menghapus meja ' + nomorMeja + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= BASE_URL ?>/dashboard/table-management/delete-table';
                
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = id;
                
                form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    },
    isTableActive(table) {
        return table.active === true || table.active == 1 || table.active === 't' || table.active === 'true';
    },
    isTableUsed(table) {
        return table.is_use === true || table.is_use == 1 || table.is_use === 't' || table.is_use === 'true';
    },
    showQrCode(table) {
        const tableUrl = table.identity_code;
        const qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(tableUrl);
        
        Swal.fire({
            title: 'QR Code Meja ' + table.nomor_meja,
            text: 'Scan untuk mengakses menu digital meja ' + table.nomor_meja,
            imageUrl: qrImageUrl,
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'QR Code Meja ' + table.nomor_meja,
            showDenyButton: true,
            confirmButtonText: 'Tutup',
            denyButtonText: 'Unduh QR',
            confirmButtonColor: '#9c3800',
            denyButtonColor: '#594238',
            background: '#fef8f1',
            color: '#1d1b17',
            customClass: {
                popup: 'rounded-[2rem] p-6 shadow-2xl border border-white/20',
                confirmButton: 'rounded-xl px-6 py-3 font-bold transition-all hover:scale-105 active:scale-95',
                denyButton: 'rounded-xl px-6 py-3 font-bold transition-all hover:scale-105 active:scale-95'
            }
        }).then((result) => {
            if (result.isDenied) {
                fetch(qrImageUrl)
                    .then(response => response.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = 'QR_Meja_' + table.nomor_meja + '.png';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                    })
                    .catch(err => {
                        console.error('Gagal mengunduh QR Code:', err);
                        window.open(qrImageUrl, '_blank');
                    });
            }
        });
    }
}">
    <?php $activeMenu = 'table-management'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>

    <!-- Modal Tambah/Edit Tempat -->
    <div x-show="showAddPlaceModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showAddPlaceModal = false">
        <div x-show="showAddPlaceModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-surface-container-lowest w-full max-w-md mx-4 rounded-3xl shadow-2xl overflow-hidden" @click.stop>
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-stone-200/50 bg-surface-container-low">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-on-surface font-headline" x-text="editPlaceMode ? 'Edit Tempat' : 'Tambah Tempat Baru'"></h3>
                    <button @click="showAddPlaceModal = false" class="p-2 rounded-full hover:bg-stone-200 transition-colors">
                        <span class="material-symbols-outlined text-stone-500">close</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form :action="editPlaceMode ? '<?= BASE_URL ?>/dashboard/table-management/update-area' : '<?= BASE_URL ?>/dashboard/table-management/create-area'" method="POST" class="p-6 space-y-5">
                <input type="hidden" name="id" :value="newPlace.id" />
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Nama Tempat</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">place</span>
                        <input name="name" x-model="newPlace.name" type="text" placeholder="Contoh: Rooftop Garden" class="w-full pl-12 pr-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" required />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Deskripsi</label>
                    <textarea name="description" x-model="newPlace.description" rows="3" placeholder="Deskripsi singkat tentang area ini..." class="w-full px-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400 resize-none"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showAddPlaceModal = false" class="flex-1 px-6 py-3 bg-surface-container-high text-on-surface-variant rounded-xl font-bold hover:bg-stone-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-primary text-on-primary rounded-xl font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-95" x-text="editPlaceMode ? 'Perbarui' : 'Simpan'">
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Meja -->
    <div x-show="showAddTableModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @click.self="showAddTableModal = false">
        <div x-show="showAddTableModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="bg-surface-container-lowest w-full max-w-md mx-4 rounded-3xl shadow-2xl overflow-hidden" @click.stop>
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-stone-200/50 bg-surface-container-low">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-on-surface font-headline">Tambah Meja Baru</h3>
                    <button @click="showAddTableModal = false" class="p-2 rounded-full hover:bg-stone-200 transition-colors">
                        <span class="material-symbols-outlined text-stone-500">close</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="<?= BASE_URL ?>/dashboard/table-management/create-table" method="POST" class="p-6 space-y-5">
                <input type="hidden" name="area_id" :value="newTable.area_id" />

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Nomor Meja</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">pin</span>
                        <input name="nomor_meja" x-model="newTable.nomor_meja" type="text" placeholder="Contoh: T-01" class="w-full pl-12 pr-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" required />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant ml-1">Kapasitas</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">group</span>
                        <input name="kapasitas" x-model="newTable.kapasitas" type="number" min="1" placeholder="Jumlah orang" class="w-full pl-12 pr-4 py-3 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-stone-400" required />
                    </div>
                </div>

                <input type="hidden" name="active" value="1" />

                <!-- Modal Footer -->
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showAddTableModal = false" class="flex-1 px-6 py-3 bg-surface-container-high text-on-surface-variant rounded-xl font-bold hover:bg-stone-200 transition-colors">
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
                    <button @click="resetPlaceForm()" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 active:scale-95 duration-200 hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined text-sm">add_circle</span>
                        Tambah Tempat Baru
                    </button>
                </div>
            </div>

            <!-- Places Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                <template x-for="place in places" :key="place.id">
                    <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/10 hover:shadow-xl hover:border-primary/20 transition-all cursor-pointer group" @click="selectPlace(place)">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-primary text-3xl">meeting_room</span>
                            </div>
                            <div class="flex gap-2">
                                <button @click.stop="openEditPlace(place.id)" class="p-2 rounded-full hover:bg-stone-100 transition-colors">
                                    <span class="material-symbols-outlined text-stone-400 text-xl">edit</span>
                                </button>
                                <button @click.stop="confirmDeleteArea(place.id, place.name)" class="p-2 rounded-full hover:bg-red-50 transition-colors">
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
                <div @click="resetPlaceForm()" class="border-2 border-dashed border-stone-200 rounded-3xl p-6 flex flex-col items-center justify-center gap-4 hover:border-primary hover:bg-primary/5 transition-all cursor-pointer group min-h-[200px]">
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
                        <a :href="'<?= BASE_URL ?>/dashboard/table-management/export-qr?area_id=' + selectedPlace?.id" target="_blank" class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:opacity-90 transition-all text-sm active:scale-95">
                            <span class="material-symbols-outlined text-base">qr_code_2</span>
                            Export QR
                        </a>
                        <button @click="openAddTable()" class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:opacity-90 transition-all text-sm active:scale-95">
                            <span class="material-symbols-outlined text-base">add</span>
                            Tambah Meja
                        </button>
                        <button @click="selectedPlace = null" class="px-4 py-2.5 bg-surface-container-high text-on-surface-variant rounded-xl font-bold hover:bg-stone-200 transition-colors text-sm">
                            Tutup
                        </button>
                    </div>
                </div>

                <!-- Tables in Selected Place -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Empty State for Tables -->
                    <template x-if="tables.length === 0">
                        <div class="col-span-full py-10 text-center bg-surface-container-lowest rounded-2xl border border-dashed border-stone-200/80">
                            <span class="material-symbols-outlined text-stone-400 text-4xl mb-2">table_restaurant</span>
                            <p class="text-stone-500 font-medium">Belum ada meja di area ini.</p>
                            <p class="text-xs text-stone-400 mt-1">Klik "+ Tambah Meja" untuk menambahkan meja baru.</p>
                        </div>
                    </template>

                    <template x-for="table in tables" :key="table.id">
                        <div class="bg-surface-container-lowest rounded-2xl p-4 border border-stone-200/50 hover:shadow-lg hover:border-primary/20 transition-all text-center cursor-pointer group relative">
                            <!-- Delete Button (Only visible on hover) -->
                            <button @click.stop="confirmDeleteTable(table.id, table.nomor_meja)" class="absolute top-2 right-2 p-1.5 bg-red-50 text-stone-400 hover:text-red-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                            <button @click.stop="showQrCode(table)" class="absolute top-2 right-10 p-1.5 bg-stone-50 text-stone-400 hover:text-primary rounded-full opacity-0 group-hover:opacity-100 transition-opacity" title="Lihat QR Code">
                                <span class="material-symbols-outlined text-sm">qr_code_2</span>
                            </button>

                            <div class="w-12 h-12 mx-auto rounded-xl flex items-center justify-center mb-3 transition-colors"
                                :class="isTableActive(table) ? (isTableUsed(table) ? 'bg-primary-container/20 text-primary' : 'bg-secondary-container/30 text-secondary') : 'bg-stone-100 text-stone-400'">
                                <span class="material-symbols-outlined">table_restaurant</span>
                            </div>
                            <h4 class="font-bold text-on-surface" x-text="table.nomor_meja"></h4>
                            <p class="text-xs text-stone-500" x-text="table.kapasitas + ' orang'"></p>
                            <span class="inline-block mt-2 px-2 py-0.5 text-[10px] font-bold rounded-full"
                                :class="isTableActive(table) ? (isTableUsed(table) ? 'bg-primary-container text-on-primary-container' : 'bg-secondary-container text-on-secondary-container') : 'bg-stone-100 text-stone-400'"
                                x-text="isTableActive(table) ? (isTableUsed(table) ? 'Terisi' : 'Tersedia') : 'Nonaktif'"></span>
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
                    <h4 class="text-2xl font-headline font-black text-on-surface" x-text="places.reduce((sum, p) => sum + Number(p.tablesCount), 0)"></h4>
                </div>
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-1">Tersedia</p>
                    <h4 class="text-2xl font-headline font-black text-secondary" x-text="places.reduce((sum, p) => sum + Number(p.available), 0)"></h4>
                </div>
                <div class="bg-surface-container p-5 rounded-2xl">
                    <p class="text-xs font-bold text-primary uppercase tracking-wider mb-1">Terisi</p>
                    <h4 class="text-2xl font-headline font-black text-primary" x-text="places.reduce((sum, p) => sum + (Number(p.tablesCount) - Number(p.available)), 0)"></h4>
                </div>
            </div>
        </section>
    </main>

    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 -z-10 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-0 lg:left-64 -z-10 w-[300px] h-[300px] bg-secondary/5 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Hidden Form for Area Deletion -->
    <form id="delete-area-form" action="<?= BASE_URL ?>/dashboard/table-management/delete-area" method="POST" class="hidden">
        <input type="hidden" name="id" id="delete-area-id">
    </form>

    <script>
        function confirmDeleteArea(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Area meja "' + name + '" akan dihapus permanen!',
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
                    document.getElementById('delete-area-id').value = id;
                    document.getElementById('delete-area-form').submit();
                }
            });
        }
    </script>

    <?php include 'partials/includes/js.php'; ?>
</body>

</html>