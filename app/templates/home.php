<!DOCTYPE html>
<html lang="id">
<?php require_once  __DIR__ . '/includes/header.php'; ?>

<body>
  <?php require_once __DIR__ . '/includes/navbar.php'; ?>
  <main class="pb-20 pt-24">
    <!-- Hero Section -->
    <section class="mx-auto grid min-h-[700px] max-w-[1280px] grid-cols-1 items-center gap-12 px-8 md:grid-cols-12">
      <div class="flex flex-col gap-8 md:col-span-6">
        <div class="inline-flex w-fit items-center gap-2 rounded-full bg-[#aeefb3] px-4 py-1.5 text-sm font-semibold text-[#336f3e]">
          <span class="material-symbols-outlined">restaurant_menu</span>
          DIGITAL CONCIERGE
        </div>
        <h1 class="text-6xl font-extrabold leading-[1.1] tracking-[-0.025em] text-[#1d1b17] md:text-[4.5rem] [font-family:'Plus_Jakarta_Sans',sans-serif]">
          Nikmati Rasa,<br />
          <span class="italic text-[#9c3800]">Tanpa Menunggu.</span>
        </h1>
        <p class="max-w-[32rem] text-xl font-light leading-[1.6] text-[#594238]">
          Saffron &amp; Sage menghadirkan kemudahan memesan langsung dari meja Anda. Cukup gunakan kode QR atau masukkan kode unik meja Anda.
        </p>
        <div class="flex flex-col gap-4 pt-4 sm:flex-row">
          <a href="/scan-qr" class="inline-flex items-center justify-center gap-3 rounded-xl bg-[#9c3800] px-8 py-4 text-lg font-bold text-white shadow-[0_8px_24px_-4px_rgba(196,73,0,0.06)] transition hover:-translate-y-0.5 hover:bg-[#c44900]">
            <span class="material-symbols-outlined">qr_code_scanner</span>Scan QR
          </a>
        </div>
      </div>

      <!-- Hero Visuals -->
      <div class="relative md:col-span-6">
        <div class="relative z-10 aspect-[4/5] overflow-hidden rounded-[2rem] shadow-[0_8px_24px_-4px_rgba(196,73,0,0.06)]">
          <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3SJ3UQH9L-9QO_DZC5-e-eRGLh6XbUJslIM0LI_kSVAMpb90Yn4pwY5f-Vdkf5CZgQeh50JbceGhsDbuOhWwJ0A1BIcXsSaQRnf5nTSImtFhAQaBOeUMVI-zpvvc6JstuJHtIg0_HQU9pn_PKRilTv5u74Wfk3Rp7qFGrVIPfzl3EQf8C1HJVNd36YPPmtRE8E5PpJ_7FX5fExgJdEHSuJ-iem2LlEEPc8E-ZWeKFfZAwkFQrPjC-iN30ztmNjbbkFJ3aQBFr5KdQ" alt="Restaurant Interior" />
          <div class="absolute inset-0 bg-gradient-to-t from-[rgba(156,56,0,0.4)] to-transparent"></div>
        </div>
        <!-- Overlapping Card -->
        <div class="absolute -bottom-10 left-0 z-20 max-w-[280px] rounded-3xl bg-white p-8 shadow-[0_8px_24px_-4px_rgba(196,73,0,0.06)] md:-left-10">
          <div class="mb-6 flex aspect-square w-full items-center justify-center rounded-2xl bg-[#f3ede6]">
            <img class="h-32 w-32 opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4bT4GUfk8xc9An0vtr2rxLXlie8sAtESqQ9T6YUkh_qwSrb5pEnxRodthcrA2bI1ecbzJ9bPpc_4Rqo1elp0HXYS56b3d2zhcUFX7fL_K7a8USyx92lS0VtyRX1FAS76my5MxBi4FcevuIOuL-eRONWiDn-abOvL48WB9aI4QF_XWSmq2H5sjLJV-VRoqFX8X2lVeD2bqHaeDDinXYozq_VGVGcv7FTYQv6hX1RO6NlZR0AJTAcF4dBR5RitVL1f74BPXb__qdNYn" alt="QR Code" />
          </div>
          <p class="text-lg font-bold text-[#1d1b17]">Pindai di Meja Anda</p>
          <p class="mt-2 text-sm leading-[1.4] text-[#594238]">Akses menu eksklusif kami secara instan melalui ponsel Anda.</p>
        </div>
        <!-- Decorative element -->
        <div class="absolute -right-6 -top-6 -z-10 h-32 w-32 rounded-full bg-[#ffdbce] opacity-30 blur-[32px]"></div>
      </div>
    </section>

    <!-- Instructions Section -->
    <section class="mt-32 bg-[#f9f3ec] py-24">
      <div class="mx-auto max-w-[1280px] px-8">
        <div class="mb-20 text-center">
          <h2 class="text-4xl font-extrabold tracking-[-0.025em] text-[#1d1b17] [font-family:'Plus_Jakarta_Sans',sans-serif]">Cara Memesan</h2>
          <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-[#9c3800]"></div>
        </div>
        <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
          <!-- Step 1 -->
          <div class="relative overflow-hidden rounded-[2.5rem] bg-white p-10 transition hover:-translate-y-[5px]">
            <div class="pointer-events-none absolute right-4 top-2 select-none text-8xl font-black text-[rgba(231,226,219,0.5)]">01</div>
            <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#c44900] text-white">
              <span class="material-symbols-outlined">qr_code_scanner</span>
            </div>
            <h3 class="mb-4 text-2xl font-bold [font-family:'Plus_Jakarta_Sans',sans-serif]">Pindai QR</h3>
            <p class="leading-[1.6] text-[#594238]">Gunakan kamera ponsel Anda untuk memindai kode QR yang tersedia di setiap meja Saffron &amp; Sage.</p>
          </div>
          <!-- Step 2 -->
          <div class="relative overflow-hidden rounded-[2.5rem] bg-white p-10 transition hover:-translate-y-[5px]">
            <div class="pointer-events-none absolute right-4 top-2 select-none text-8xl font-black text-[rgba(231,226,219,0.5)]">02</div>
            <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#2e6a3a] text-white">
              <span class="material-symbols-outlined">restaurant</span>
            </div>
            <h3 class="mb-4 text-2xl font-bold [font-family:'Plus_Jakarta_Sans',sans-serif]">Pilih Menu</h3>
            <p class="leading-[1.6] text-[#594238]">Jelajahi menu kurasi kami dengan deskripsi detail dan foto hidangan yang menggugah selera.</p>
          </div>
          <!-- Step 3 -->
          <div class="relative overflow-hidden rounded-[2.5rem] bg-white p-10 transition hover:-translate-y-[5px]">
            <div class="pointer-events-none absolute right-4 top-2 select-none text-8xl font-black text-[rgba(231,226,219,0.5)]">03</div>
            <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#8d6c00] text-[#fff5e8]">
              <span class="material-symbols-outlined">shopping_bag</span>
            </div>
            <h3 class="mb-4 text-2xl font-bold [font-family:'Plus_Jakarta_Sans',sans-serif]">Konfirmasi</h3>
            <p class="leading-[1.6] text-[#594238]">Selesaikan pesanan Anda langsung dari aplikasi. Tim kami akan segera menyiapkan hidangan Anda.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Feature Section -->
    <section class="mx-auto grid max-w-[1280px] grid-cols-1 items-center gap-16 px-8 py-32 md:grid-cols-2">
      <div class="grid grid-cols-2 gap-6 md:order-1">
        <img class="aspect-square w-full rounded-3xl object-cover shadow-[0_8px_24px_-4px_rgba(196,73,0,0.06)]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAYdRvp2QUacoras9WSyvslYZRjEWj7QPNFp_8_XqoSjaw77CnpoLKFHXBKMoseTFAaSLPX17hMScqD3F4S09mzmUBFhH7GAMeBjVFwG_yYRrq6tLUHF0vOsi7_1MPwmN40VKKcMr7DTa1GQcSP01bwrdyX4WUHMtTNXxPvpznMk--zuenKntGrgX8ssCEogRFhTD9eUTr_7j2rVbjN2fNv14vf4gHnnCY9wwy2BuBcAd_aZAxatT2W9YhhkJEgSHFdrNyXnnwaxAG" alt="Fine Dining Plate" />
        <img class="mt-12 aspect-square w-full rounded-3xl object-cover shadow-[0_8px_24px_-4px_rgba(196,73,0,0.06)]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDwXy-x3vaP4w6WxEPpQgKoHF6Xbw-trgKAkzMLP-REdcbC8LkOWUPYL-u5sVyi7Yv0Vxj7dR5bIznow__hsrfVTF3GApFokb5xVKxd9OUgBV7sMvt5kmdJ9qgnwfqVm06UnTQBp3y6Nq2w_kRdsUixsAtPiZyFzu09vz_wtG97Uy7GCWX_MQIFGeYO8BY1KNKMnyZmiMR_QDrHrA5eDHXISUAfPlwxZeCp0ktWIlpRo4eVYwC8b3EeNnyoF54kH6M0hg212wuJ8k1h" alt="Gourmet Detail" />
      </div>
      <div class="flex flex-col gap-8 md:order-2">
        <h2 class="text-5xl font-extrabold leading-[1.2] [font-family:'Plus_Jakarta_Sans',sans-serif]">Pengalaman Kuliner yang <span class="italic text-[#2e6a3a]">Pribadi.</span></h2>
        <p class="text-lg leading-[1.6] text-[#594238]">
          Setiap hidangan di Saffron &amp; Sage dibuat dengan bahan-bahan organik terbaik. Sistem pemesanan digital kami memastikan instruksi khusus Anda tersampaikan dengan akurat ke dapur kami.
        </p>
        <ul class="flex list-none flex-col gap-4">
          <li class="flex items-center gap-4 font-semibold">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#aeefb3] text-[#336f3e]">
              <span class="material-symbols-outlined">check</span>
            </div>
            Bebas Antrian di Kasir
          </li>
          <li class="flex items-center gap-4 font-semibold">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#aeefb3] text-[#336f3e]">
              <span class="material-symbols-outlined">check</span>
            </div>
            Pembayaran Digital yang Aman
          </li>
        </ul>
      </div>
    </section>
  </main>
  <?php require_once  __DIR__ . '/includes/footer.php'; ?>
</body>

</html>