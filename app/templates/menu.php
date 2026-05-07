<?php
// Menu Catalog View
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/navbar.php'; ?>
<body class="page-shell font-body">
    <!-- TopAppBar -->
    <header class="top-header">
        <div class="header-container">
            <div class="logo">
                <span>Saffron & Sage</span>
            </div>
            <nav class="main-nav">
                <a href="#" class="active">Menu</a>
                <a href="#">Riwayat</a>
                <a href="#">Bantuan</a>
            </nav>
            <div class="header-actions">
                <div class="table-info">
                    <span class="material-symbols-outlined icon">table_restaurant</span>
                    <span>Meja T12</span>
                </div>
                <button class="action-btn">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </button>
                <button class="action-btn">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
            </div>
        </div>
        <div class="header-divider"></div>
    </header>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Selamat Datang</h2>
            <p>Nikmati hidangan premium kami</p>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="active list-item">
                <span class="material-symbols-outlined">restaurant_menu</span>
                <span>Menu</span>
            </a>
            <a href="#" class="list-item">
                <span class="material-symbols-outlined">local_bar</span>
                <span>Minuman</span>
            </a>
            <a href="#" class="list-item">
                <span class="material-symbols-outlined">icecream</span>
                <span>Dessert</span>
            </a>
            <a href="#" class="list-item">
                <span class="material-symbols-outlined">loyalty</span>
                <span>Promo</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <button class="cart-btn">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                <span>Keranjang Saya</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Editorial Header Section -->
        <section class="editorial-header">
            <div class="header-text-container">
                <div class="text-group">
                    <span class="subtitle">Koleksi Musim Ini</span>
                    <h1>Simfoni Rasa dalam <span class="italic-highlight">Setiap Gigitan</span></h1>
                </div>
                <div class="tags">
                    <span class="tag tag-primary">Populer</span>
                    <span class="tag tag-secondary">Vegetarian</span>
                    <span class="tag tag-secondary">Bebas Gluten</span>
                </div>
            </div>

            <!-- Hero Bento-style Highlight -->
            <div class="hero-bento">
                <div class="hero-image-container">
                    <img alt="Signature Dish" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVSSw9zy-0IAyJav4gI-Js97Z_BejsG_PX9OiBtxncuXaURktxT5v_6ma5Qv4aKjA4r84LI75fVfBWeGnXHg9fp6szEA_t9uxMTtM5K6wcdyl8ukFqE-Lm7CGHipQ4dP6PsBQTZnVc7VD1vbCKiBj5j2geAl6qB9JgDijK18hIJWNq7qSv6JvqNF-cys-Dll_pAdDRg73_Z9RwRAuj4kVhFOb_801hNRxH3xt1LVlU5I7CHRf2R524RFwKg0HFh3quI0AngulmV2YE">
                    <div class="hero-overlay"></div>
                    <div class="hero-text">
                        <span class="badge">Rekomendasi Chef</span>
                        <h3>Lamb Shank & Saffron Glaze</h3>
                        <p>Daging domba pilihan yang dimasak perlahan selama 12 jam dengan rempah eksotis dan saus saffron premium.</p>
                    </div>
                </div>
                <div class="promo-bento">
                    <div class="promo-content">
                        <span class="promo-subtitle">Penawaran Spesial</span>
                        <h3>Diskon 25%</h3>
                        <p>Untuk pemesanan pertama Anda melalui aplikasi Saffron & Sage.</p>
                    </div>
                    <button class="promo-btn inline-flex items-center justify-center rounded-full px-5 py-3 font-semibold shadow-soft transition hover:-translate-y-0.5">Klaim Promo</button>
                    <div class="promo-bg-deco"></div>
                </div>
            </div>
        </section>

        <!-- Menu Grid -->
        <section class="menu-grid">
            <!-- Item 1 -->
            <div class="menu-card group">
                <div class="image-wrapper">
                    <img alt="Healthy Bowl" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5rnM0DUwn9IivRu5RFaGmKzQ5lJU3zvlGHK93PkExpazJmFlxDZEIFQZOd41Xx4bD02rrizekPR6klKKV0PkCxrdVZ2eEHcki5iIpECuO62Zx052_H8uMmNUofLtRMu3dhBmip86HL0HHLJNSRt9gwynck4AdEYmtbh04L5MmI3lV8osrNGk3QCnjd4X-5J1R7GQeBLEOIXTlIoJ4dx-fI61YUfCr43w7IcVU7eAeyn71T7B53V9efYefQVqrz-IAHeXUytg3HKVP">
                    <button class="fav-btn"><span class="material-symbols-outlined">favorite</span></button>
                </div>
                <div class="menu-info">
                    <div class="title-price">
                        <h4>Green Harvest Bowl</h4>
                        <span class="price">Rp 85k</span>
                    </div>
                    <p class="desc">Campuran segar quinoa organik, alpukat mentega, sayuran hijau musim dingin, dan saus lemon-tahini.</p>
                    <div class="action-row">
                        <div class="rating"><span class="material-symbols-outlined icon">star</span> <strong>4.8 (120+)</strong></div>
                        <button class="add-btn"><span class="material-symbols-outlined">add</span> Tambah</button>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="menu-card group">
                <div class="image-wrapper">
                    <img alt="Mediterranean Salad" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvLLWsS2f5wj_bntv4Wzm-AEuHEGRGexx_6i60kgf6oAGYLxFBqECYvO-SARMuUJE1oLbWuJOlXgGFYnFiwLkzB4s_MPxDcVXE3RA5iWaw6HcnXn7ZH0nuo5N8e9_zNoU1vzrMuLFZq_uYrj2HhOck9e1-Hy0ukZBXHwcd5CIucf-CF7cZTaAczkMPQfYeZ_9xWRnVDQEaHsrDSQS5xUCZXa3UonDuHz3mOEjwi32sNoD7Gn895lCCgXHl9RgRQxcrhWFE2L08228s">
                    <button class="fav-btn"><span class="material-symbols-outlined">favorite</span></button>
                    <span class="left-badge badge-fav">Favorit Pelanggan</span>
                </div>
                <div class="menu-info">
                    <div class="title-price">
                        <h4>Sage Feta Salad</h4>
                        <span class="price">Rp 72k</span>
                    </div>
                    <p class="desc">Keju feta Yunani otentik dengan zaitun Kalamata, tomat ceri organik, dan dressing balsamic rahasia chef.</p>
                    <div class="action-row">
                        <div class="rating"><span class="material-symbols-outlined icon">star</span> <strong>4.9 (240+)</strong></div>
                        <button class="add-btn"><span class="material-symbols-outlined">add</span> Tambah</button>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="menu-card group">
                <div class="image-wrapper">
                    <img alt="Truffle Pasta" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsSsdQ341KH9tG6du3hdwcRyrptkwLcMw1-S1gF1a31s89Cn7h76iXiTcypcK_5PD-GxdFA_Go1Ck6rPNJ6Th-4d8mJiAzx8VxduSCJYiuPPib_mL21nk0y4Xu2xZSqpyN_tHewVwrGpROPsbe8sCgSQjFae-hzzMStY0Gd4QR0NHxH7kgt3EPJF_pjxivO2ggtmYqI5rqxwuGi3SGCt4Lm3Y112zhjx2dPQcMn2U5AY-EzN1o1TeiDi38H_b7wJmUOXtOirL1BJCv">
                    <button class="fav-btn"><span class="material-symbols-outlined">favorite</span></button>
                    <span class="left-badge top-badge badge-new">Baru</span>
                </div>
                <div class="menu-info">
                    <div class="title-price">
                        <h4>Truffle Cream Tagliatelle</h4>
                        <span class="price">Rp 145k</span>
                    </div>
                    <p class="desc">Pasta buatan tangan dengan saus krim truffle hitam Italia, jamur liar, dan keju Grana Padano berumur 24 bulan.</p>
                    <div class="action-row">
                        <div class="rating"><span class="material-symbols-outlined icon">star</span> <strong>5.0 (45)</strong></div>
                        <button class="add-btn"><span class="material-symbols-outlined">add</span> Tambah</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>

</html>