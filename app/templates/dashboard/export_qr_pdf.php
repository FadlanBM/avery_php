<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Cetak QR Code Meja | Saffron &amp; Sage</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#9c3800",
                        "on-primary": "#ffffff",
                        background: "#fef8f1",
                        "on-background": "#1d1b17",
                        surface: "#ffffff",
                        "on-surface": "#1d1b17",
                        outline: "#8c7167",
                        "outline-variant": "#e0c0b3"
                    },
                    fontFamily: {
                        headline: ["Plus Jakarta Sans"],
                        body: ["Be Vietnam Pro"]
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: #fef8f1;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Screen CSS for page groupings */
        .print-page {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            justify-items: center;
        }

        @media (min-width: 640px) {
            .print-page {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .qr-card {
            width: 95mm;
            height: 135mm;
            transition: all 0.2s ease-in-out;
        }

        .qr-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }

            .no-print {
                display: none !important;
            }

            .print-container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                background-color: #ffffff !important;
            }

            .print-page-break {
                page-break-before: always !important;
                break-before: page !important;
            }

            .print-page {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                grid-template-rows: repeat(2, 1fr) !important;
                gap: 8mm !important;
                row-gap: 8mm !important;
                height: 260mm !important;
                box-sizing: border-box !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-bottom: 0 !important;
            }

            .qr-card {
                width: 90mm !important;
                height: 125mm !important;
                box-shadow: none !important;
                border: 2px dashed #a8a29e !important;
                /* Stone-400 */
                background-color: #ffffff !important;
                margin: auto !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            @page {
                size: A4 portrait;
                margin: 15mm 10mm 15mm 10mm;
            }
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen pb-16">

    <!-- Top Bar & Controls (Screen Only) -->
    <header class="no-print bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-outline-variant/20 py-4 px-6 md:px-12 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="<?= BASE_URL ?>/dashboard/table-management" class="p-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 transition-colors flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-on-background flex items-center gap-2">
                    Cetak QR Code Meja
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">
                    <?= $area ? 'Area: <span class="font-bold text-primary">' . htmlspecialchars($area->name) . '</span>' : 'Semua Area' ?>
                    &bull; Total <?= count($tables) ?> Meja
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:opacity-90 transition-all text-sm active:scale-95">
                <span class="material-symbols-outlined text-base">print</span>
                Cetak Sekarang
            </button>
        </div>
    </header>

    <!-- Tips Banner (Screen Only) -->
    <div class="no-print max-w-5xl mx-auto mt-6 px-4">
        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-4 flex gap-3 text-stone-800">
            <span class="material-symbols-outlined text-primary text-2xl shrink-0">info</span>
            <div>
                <h4 class="font-bold text-sm text-primary mb-1">Tips Mencetak QR Code</h4>
                <ul class="text-xs space-y-1 text-stone-600 list-disc list-inside">
                    <li>Pilih printer Anda dan ubah tujuan ke <strong>"Simpan sebagai PDF" (Save as PDF)</strong> jika Anda ingin menyimpannya berupa file PDF.</li>
                    <li>Atur ukuran kertas ke <strong>A4</strong> dengan orientasi <strong>Potret (Portrait)</strong>.</li>
                    <li>Di bagian <strong>Setelan Lainnya (More Settings)</strong>, matikan opsi <strong>"Header dan footer"</strong> agar tampilan bersih tanpa tulisan tanggal & domain.</li>
                    <li>Aktifkan opsi <strong>"Grafik latar belakang" (Background graphics)</strong> agar border dan warna dekoratif tercetak dengan sempurna.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Printable Content Container -->
    <main class="print-container max-w-5xl mx-auto px-4 mt-8">

        <?php if (empty($tables)): ?>
            <!-- Empty State -->
            <div class="text-center py-20 bg-white rounded-3xl border border-stone-200/60 shadow-sm">
                <span class="material-symbols-outlined text-stone-300 text-6xl mb-3">table_restaurant</span>
                <h3 class="text-lg font-bold text-stone-700">Belum Ada Meja</h3>
                <p class="text-sm text-stone-500 mt-1">Silakan tambahkan meja terlebih dahulu di dashboard manajemen meja.</p>
                <a href="<?= BASE_URL ?>/dashboard/table-management" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-on-primary rounded-xl font-bold text-sm hover:opacity-90 transition-all">
                    Kembali ke Manajemen Meja
                </a>
            </div>
        <?php else: ?>
            <!-- QR Codes Grid Chunked into Pages of 4 -->
            <?php
            $chunks = array_chunk($tables, 4);
            foreach ($chunks as $pageIndex => $pageTables):
            ?>
                <div class="print-page <?= $pageIndex > 0 ? 'print-page-break' : '' ?>">
                    <?php foreach ($pageTables as $table): ?>
                        <?php
                        $qrData = $table['identity_code'];
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
                        ?>
                        <div class="qr-card bg-white border-2 border-dashed border-stone-300 rounded-[1.5rem] p-6 flex flex-col justify-between items-center text-center shadow-md relative overflow-hidden shrink-0">
                            <!-- Cut Line Indicator (For screen preview context) -->
                            <div class="no-print absolute top-2 left-2 text-[9px] font-bold text-stone-400 select-none uppercase tracking-wider flex items-center gap-1">
                                <span class="material-symbols-outlined text-[10px]">content_cut</span> Garis Potong
                            </div>

                            <!-- Card Top: Brand Header -->
                            <div class="w-full flex flex-col items-center mt-3">
                                <h2 class="text-lg font-black tracking-wider uppercase text-primary font-headline">
                                    <?= htmlspecialchars($restaurant->name ?? 'Saffron & Sage') ?>
                                </h2>
                                <div class="w-16 h-[2px] bg-primary/20 my-1"></div>
                                <span class="text-[10px] font-bold text-stone-500 tracking-widest uppercase">MENU DIGITAL</span>
                            </div>

                            <!-- Card Middle: QR Code Box -->
                            <div class="flex flex-col items-center justify-center bg-stone-50 border border-stone-100 p-4 rounded-2xl w-52 h-52 shadow-inner">
                                <img src="<?= $qrUrl ?>" alt="QR Code Meja <?= htmlspecialchars($table['identity_code']) ?>" class="w-44 h-44 object-contain" />
                            </div>

                            <!-- Card Bottom: Table Info & Instructions -->
                            <div class="w-full mb-3 flex flex-col items-center">
                                <div class="bg-primary text-on-primary px-5 py-1.5 rounded-full font-bold text-base font-headline uppercase tracking-wider shadow-sm mb-2.5">
                                    <?= htmlspecialchars($table['identity_code']) ?>
                                </div>

                                <p class="text-xs text-stone-700 font-medium px-4 leading-relaxed">
                                    Pindai QR Code untuk melihat menu &amp; memesan langsung dari smartphone Anda
                                </p>

                                <!-- Card Footer Extra Info -->
                                <?php if ($area): ?>
                                    <span class="text-[9px] font-bold text-stone-400 tracking-wider uppercase mt-3">
                                        Area: <?= htmlspecialchars($area->name) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>

</body>

</html>