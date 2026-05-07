<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="/assets/css/scanqr.css">

<body>

  <?php require_once __DIR__ . '/includes/navbar.php'; ?>

  <main class="main-content">
    <div class="container">
      <section class="hero-content">
        <div>
          <span class="badge">AKSES DIGITAL</span>
          <h1 class="hero-title">Akses Menu Digital</h1>
          <p class="hero-desc">
            Arahkan kode QR di meja Anda ke kamera komputer, atau gunakan ponsel Anda untuk pemindaian yang lebih mudah.
          </p>
        </div>

        <div class="action-group">
          <div class="relative flex w-full max-w-[320px] flex-1">
            <input class="w-full rounded-xl border-0 bg-[#ede7e0] px-6 py-4 pr-24 text-lg transition focus:outline-none focus:ring-2 focus:ring-[#9c3800]" placeholder="Masukkan Kode Meja" type="text" />
            <button class="absolute inset-y-2 right-2 rounded-lg bg-[#1d1b17] px-6 text-sm font-bold text-[#fef8f1] transition hover:bg-[#9c3800]">GO</button>
          </div>
          <button class="btn btn-text">
            Panduan Bantuan
          </button>
        </div>

        <div class="social-proof">
          <div class="avatar-group">
            <div class="avatar">
              <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZDruqwhej1pad7gUOr-M_kNkJ-by1B6SVbzhRgwOGGYCXa9huNJY3yDkMc7H1hC7j8UzAuBR454vWkJ6ARitwks806qE4BL1yhghm6hgTUzgIInshDi1a57q0wZsRTdUKUgE6wjNoJbuQYJyg3dDHLqQ-qYBTzdt9tzl0acfG8JeVT4xAZxeg7kiIYAjIm3WAOve9luoPqOt6bbMWsGivFmvmApqFZjGR0TRCtkqj8DHXmynsYFzPgnrAUlV6XRxYIcLem1qB4XoA" alt="Patron" />
            </div>
            <div class="avatar">
              <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0vqSyePb3gFWY7H1u2nM8ncnHgQT6FO2bhHkg8joCqNFMw4lcbPxXSiUX52ERwwjpvMAEu9xvgupfVJgzqxI7Fihj8iNQMd8yw7PCGWcluZQJ_53SR__x9D5UfiFuGA_GX7cbpUS9Wbpce1HH62jxC7ft1I_f-7vAjMw_-gC-yT4XquM_TpXtw6FFLcke89OkXPElp6102eFbgvxMht3YmtW6SNMtDid_v70IrP2rHETAhQ1Nfg26HCwV63xzQf4FSTRyC6N08VNT" alt="Patron" />
            </div>
            <div class="avatar avatar-plus">+1k</div>
          </div>
          <p class="proof-text">
            Bergabung dengan ribuan tamu yang menikmati kemudahan menu digital.
          </p>
        </div>
      </section>

      <section class="scanner-viewport">
        <div class="viewfinder-card">
          <div class="scanner-bg">
            <img src="/assets/images/qr-placeholder.png" alt="QR Scanner Background" onerror="this.style.display='none'">
          </div>
          <div id="qr-video" style="display: none; width: 100%; height: 100%;"></div>
          <div class="overlay-container">
            <div class="box-wrapper">
              <div class="laser-line"></div>
              <div class="qr-icon-hint">
                <span class="material-symbols-outlined">qr_code_scanner</span>
              </div>
            </div>
          </div>

          <div class="scanner-footer">
            <div class="status-label">
              <span class="dot-indicator">
                <span class="dot-pulse"></span>
                <span class="dot-core"></span>
              </span>
              <span class="label-text" id="scanner-status">Menyalakan kamera...</span>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <?php require_once __DIR__ . '/includes/footer.php'; ?>
  <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const statusLabel = document.getElementById('scanner-status');
      const placeholderImage = document.querySelector('.scanner-bg img');
      const videoElement = document.getElementById('qr-video');

      let html5QrCode = null;
      let isScanning = false;

      const setStatus = (message) => {
        statusLabel.textContent = message;
      };

      const setResult = (message) => {
        console.log(message)
      };

      const handleScan = (decodedText) => {
        if (!isScanning) return;

        isScanning = false;
        setStatus('QR terdeteksi');
        setResult(`Hasil scan: ${decodedText}`);

        html5QrCode.stop().then(() => {
          videoElement.style.display = 'none';
          if (placeholderImage) placeholderImage.style.display = 'block';
        }).catch((err) => console.log(err));

        try {
          const url = new URL(decodedText, window.location.origin);
          window.location.href = url.toString();
        } catch (error) {
          // Bukan URL, cukup tampilkan hasil scan.
        }
      };

      const startCamera = async () => {
        setResult('');
        setStatus('Meminta izin kamera...');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
          setStatus('Browser tidak mendukung kamera');
          setResult('Gunakan browser modern seperti Chrome atau Edge. Pastikan halaman diakses via HTTPS atau localhost.');
          return;
        }

        try {
          html5QrCode = new Html5Qrcode('qr-video');
          isScanning = true;

          await html5QrCode.start({
              facingMode: "environment"
            }, {
              fps: 10,
              qrbox: {
                width: 250,
                height: 250
              }
            },
            (decodedText) => {
              handleScan(decodedText);
            },
            () => {}
          );

          videoElement.style.display = 'block';
          if (placeholderImage) placeholderImage.style.display = 'none';
          setStatus('Kamera aktif - Arahkan ke QR Code');

        } catch (error) {
          isScanning = false;
          setStatus('Gagal membuka kamera');

          if (error.name === 'NotAllowedError') {
            setResult('Izin kamera ditolak. Silakan izinkan akses kamera di pengaturan browser.');
          } else if (error.name === 'NotFoundError') {
            setResult('Kamera tidak ditemukan. Pastikan perangkat memiliki kamera.');
          } else if (error.name === 'NotSupportedError') {
            setResult('Kamera memerlukan koneksi HTTPS. Gunakan localhost atau HTTPS.');
          } else {
            setResult(error.message || 'Terjadi kesalahan. Pastikan halaman diakses via HTTPS atau localhost.');
          }
        }
      };

      const stopCamera = () => {
        if (html5QrCode && isScanning) {
          html5QrCode.stop().then(() => {
            isScanning = false;
            videoElement.style.display = 'none';
            if (placeholderImage) placeholderImage.style.display = 'block';
          }).catch((err) => console.log(err));
        }
      };

      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          stopCamera();
        }
      });

      window.addEventListener('beforeunload', stopCamera);

      // Langsung buka kamera saat halaman dimuat
      startCamera();
    });
  </script>
</body>

</html>