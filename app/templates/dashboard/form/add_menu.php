<!DOCTYPE html>
<html class="light" lang="id">
<?php include __DIR__ . '/partials/head.php'; ?>

<body class="bg-background text-on-background min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
    <div class="flex">
        <!-- Sidebar (Copy from latest standard) -->
        <?php $activeMenu = 'menu-management'; ?>
        <?php include __DIR__ . '/../partials/includes/navbarslider.php'; ?>
        <!-- Main Content Area -->
        <main class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <?php $beforePageTitle = 'Management Menu'; ?>
            <?php $pageTitle = 'Tambah Menu Baru'; ?>
            <?php include __DIR__ . '/partials/header.php'; ?>
            <!-- Page Canvas -->
            <div class="p-4 lg:p-8 max-w-5xl mx-auto w-full">
                <!-- Content Grid -->
                <div class="flex flex-col gap-8">
                    <!-- Intro Header -->
                    <div>
                        <h2 class="text-3xl font-bold font-headline text-orange-900 tracking-tight">Buat Sajian Baru</h2>
                        <p class="text-stone-500 mt-1">Tambahkan detail hidangan baru ke dalam daftar menu digital Anda.</p>
                    </div>

                    <!-- Form Section -->
                    <section class="bg-surface-container-lowest p-8 rounded-3xl shadow-[0_8px_24px_-4px_rgba(156,56,0,0.04)] border border-orange-50/50">
                        <form action="<?= BASE_URL ?>/dashboard/menu-management/add" method="POST" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-orange-900 mb-2 font-headline ml-1">Nama Hidangan</label>
                                    <input name="name" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 text-on-surface placeholder:text-stone-400 shadow-sm focus:ring-1 focus:ring-primary focus:bg-white transition-all" placeholder="Misal: Rendang Wagyu Saffron" type="text" />
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-orange-900 font-headline ml-1">Kategori</label>
                                    <select name="category" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 text-on-surface shadow-sm focus:ring-1 focus:ring-primary focus:bg-white transition-all">
                                        <option>Pilih Kategori</option>
                                        <option>Hidangan Utama</option>
                                        <option>Appetizer</option>
                                        <option>Minuman</option>
                                        <option>Dessert</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-orange-900 font-headline ml-1">Harga (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-500 font-bold text-sm">Rp</span>
                                        <input name="price" class="w-full bg-surface-container-high border-none rounded-xl pl-12 pr-4 py-3 text-on-surface shadow-sm focus:ring-1 focus:ring-primary focus:bg-white transition-all" placeholder="0" type="number" />
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-orange-900 mb-2 font-headline ml-1">Deskripsi Menu</label>
                                    <textarea name="description" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 text-on-surface placeholder:text-stone-400 resize-none shadow-sm focus:ring-1 focus:ring-primary focus:bg-white transition-all" placeholder="Ceritakan keistimewaan rasa, aroma, dan bahan baku hidangan ini..." rows="5"></textarea>
                                </div>
                                <div class="md:col-span-2 flex flex-wrap gap-3 mt-2">
                                    <div class="flex items-center gap-2 bg-orange-50 px-4 py-2 rounded-full border border-orange-100 cursor-pointer hover:bg-orange-100 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-primary" style="font-variation-settings: 'FILL' 1;">restaurant</span>
                                        <span class="text-xs font-bold text-orange-900">Vegetarian</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-stone-100 px-4 py-2 rounded-full border border-transparent cursor-pointer hover:bg-orange-50 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-stone-500">local_fire_department</span>
                                        <span class="text-xs font-bold text-stone-600">Pedas</span>
                                    </div>
                                    <div class="flex items-center gap-2 bg-stone-100 px-4 py-2 rounded-full border border-transparent cursor-pointer hover:bg-orange-50 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-stone-500">star</span>
                                        <span class="text-xs font-bold text-stone-600">Chef's Choice</span>
                                    </div>
                                </div>
                            </div>
                    </section>

                    <!-- Media Section -->
                    <section class="bg-surface-container-lowest p-8 rounded-3xl shadow-[0_8px_24px_-4px_rgba(156,56,0,0.04)] border border-orange-50/50">
                        <h3 class="text-lg font-bold text-orange-900 mb-6 font-headline ml-1">Visual Hidangan</h3>
                        <div id="dropZone" class="border-2 border-dashed border-outline-variant rounded-3xl p-16 flex flex-col items-center justify-center gap-4 bg-surface-container-low hover:bg-orange-50/50 transition-all cursor-pointer group relative" onclick="document.getElementById('imageInput').click()">
                            <input type="file" id="imageInput" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(this)">
                            
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-primary">cloud_upload</span>
                            </div>
                            <div class="text-center">
                                <p class="font-headline font-bold text-orange-900">Klik atau seret foto ke sini</p>
                                <p class="text-sm text-stone-500 mt-1">Gunakan resolusi tinggi (min. 1200x800px) untuk hasil terbaik</p>
                                <p class="text-xs text-primary mt-2 font-bold" id="fileCountDisplay">Belum ada file terpilih</p>
                            </div>
                            <div class="mt-2 px-8 py-3 bg-white text-orange-900 border border-orange-100 rounded-full text-sm font-bold shadow-sm hover:bg-orange-50 transition-colors">
                                Pilih Berkas
                            </div>
                        </div>

                        <!-- Image Preview Container -->
                        <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6"></div>

                        <!-- Full Screen Preview Modal -->
                        <div id="previewModal" class="fixed inset-0 bg-black/90 z-[100] hidden items-center justify-center p-4" onclick="this.classList.add('hidden'); this.classList.remove('flex');">
                            <img id="modalImage" src="" class="max-w-full max-h-full rounded-lg shadow-2xl">
                            <button class="absolute top-6 right-6 text-white bg-white/20 p-2 rounded-full hover:bg-white/40 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>

                        <script>
                            let selectedFiles = [];
                            const dropZone = document.getElementById('dropZone');

                            // Drag and Drop Events
                            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, preventDefaults, false);
                            });

                            function preventDefaults(e) {
                                e.preventDefault();
                                e.stopPropagation();
                            }

                            ['dragenter', 'dragover'].forEach(eventName => {
                                dropZone.addEventListener(eventName, highlight, false);
                            });

                            ['dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, unhighlight, false);
                            });

                            function highlight(e) {
                                dropZone.classList.add('bg-orange-50', 'border-primary');
                                dropZone.classList.remove('bg-surface-container-low', 'border-outline-variant');
                            }

                            function unhighlight(e) {
                                dropZone.classList.remove('bg-orange-50', 'border-primary');
                                dropZone.classList.add('bg-surface-container-low', 'border-outline-variant');
                            }

                            dropZone.addEventListener('drop', handleDrop, false);

                            function handleDrop(e) {
                                const dt = e.dataTransfer;
                                const files = dt.files;
                                if (files && files.length > 0) {
                                    handleFiles(files);
                                }
                            }

                            function previewImages(input) {
                                if (input.files && input.files.length > 0) {
                                    handleFiles(input.files);
                                }
                            }

                            function handleFiles(files) {
                                const newFiles = Array.from(files);
                                // Filter only images
                                const imageFiles = newFiles.filter(file => file.type.startsWith('image/'));
                                if (imageFiles.length !== newFiles.length) {
                                    alert('Hanya file gambar yang diperbolehkan');
                                }
                                selectedFiles = [...selectedFiles, ...imageFiles];
                                updateInputAndPreview();
                            }

                            function updateInputAndPreview() {
                                const container = document.getElementById('imagePreviewContainer');
                                const countDisplay = document.getElementById('fileCountDisplay');
                                const input = document.getElementById('imageInput');
                                
                                container.innerHTML = '';
                                
                                // Update input.files using DataTransfer (so PHP receives the correct files)
                                const dt = new DataTransfer();
                                selectedFiles.forEach(file => dt.items.add(file));
                                input.files = dt.files;

                                countDisplay.innerText = selectedFiles.length > 0 ? selectedFiles.length + ' file terpilih' : 'Belum ada file terpilih';

                                selectedFiles.forEach((file, index) => {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        const div = document.createElement('div');
                                        div.className = 'relative group aspect-square rounded-2xl overflow-hidden border border-orange-100 shadow-sm bg-stone-100 animate-in fade-in zoom-in duration-300';
                                        div.innerHTML = `
                                            <img src="${e.target.result}" class="w-full h-full object-cover cursor-zoom-in" onclick="openPreview('${e.target.result}')">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center gap-3">
                                                <button type="button" onclick="openPreview('${e.target.result}')" class="w-10 h-10 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white backdrop-blur-sm transition-colors">
                                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                                </button>
                                                <button type="button" onclick="removeImage(${index})" class="w-10 h-10 bg-red-500/80 hover:bg-red-600 rounded-full flex items-center justify-center text-white backdrop-blur-sm transition-colors">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </div>
                                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/60 to-transparent">
                                                <span class="text-[10px] text-white font-bold px-2">Gambar ${index + 1}</span>
                                            </div>
                                        `;
                                        container.appendChild(div);
                                    }
                                    reader.readAsDataURL(file);
                                });
                            }

                            function removeImage(index) {
                                selectedFiles.splice(index, 1);
                                updateInputAndPreview();
                            }

                            function openPreview(src) {
                                const modal = document.getElementById('previewModal');
                                const modalImg = document.getElementById('modalImage');
                                modalImg.src = src;
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');
                                event.stopPropagation();
                            }
                        </script>
                    </section>

                    <!-- Action Row -->
                    <div class="flex items-center justify-end gap-6 mt-4">
                        <input type="hidden" name="status" value="available">
                        <button type="button" class="px-8 py-4 text-stone-500 font-bold hover:text-orange-900 transition-colors" onclick="window.history.back()">
                            Batalkan
                        </button>
                        <button type="submit" class="px-12 py-4 bg-primary text-on-primary rounded-2xl font-headline font-extrabold shadow-xl shadow-primary/20 flex items-center gap-3 active:scale-95 duration-200 hover:opacity-90">
                            Simpan ke Daftar Menu
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>