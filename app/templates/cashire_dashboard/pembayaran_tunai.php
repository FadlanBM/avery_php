<!DOCTYPE html>

<html lang="id">
<?php include 'partials/includes/head.php'; ?>

<body class="bg-background text-on-background font-body antialiased overflow-x-hidden">
  <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
    <!-- SideNavBar -->
    <?php $activeMenu = 'scanqr'; ?>
    <?php include 'partials/includes/navbarslider.php'; ?>
    <!-- Main Content Area -->
    <main class="flex-1 min-w-0 lg:ml-64 flex flex-col relative overflow-y-auto overflow-x-hidden">
      <!-- TopNavBar -->
      <?php $pageTitle = 'Pembayaran Tunai'; ?>
      <?php include 'partials/includes/topheader.php'; ?>
      <div
        x-data="cashPaymentCalculator(155000, 200000)"
        @keydown.window="handleKey($event)"
        class="flex-1 p-4 sm:p-6 md:p-8 max-w-7xl mx-auto w-full overflow-x-hidden">
        <div class="mb-6 md:mb-8">
          <nav class="flex items-center gap-2 text-xs sm:text-sm text-outline mb-2 overflow-x-auto whitespace-nowrap pb-1">
            <span class="flex-shrink-0">Orders</span>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="flex-shrink-0">#ORD-2024-001</span>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-primary font-semibold flex-shrink-0">Payment</span>
          </nav>
          <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-on-surface tracking-tight">Proses Pembayaran Tunai</h1>
        </div>
        <!-- Three Column Bento-ish Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6 lg:gap-8 min-w-0">
          <!-- Left: Order Summary -->
          <section class="lg:col-span-4 flex flex-col gap-4 md:gap-6 min-w-0">
            <div class="bg-surface-container-low rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm">
              <div class="flex justify-between items-start mb-4 md:mb-6">
                <div>
                  <h2 class="text-base md:text-lg font-bold text-on-surface">Order Summary</h2>
                  <p class="text-xs md:text-sm text-on-surface-variant">MEJA T12 • 4 Guests</p>
                </div>
                <span class="bg-primary-container/10 text-primary-container px-2 md:px-3 py-1 rounded-full text-xs font-bold">#ORD-2024-001</span>
              </div>
              <div class="space-y-3 md:space-y-4 mb-6 md:mb-8">
                <div class="flex justify-between items-center gap-3 group">
                  <div class="flex gap-2 md:gap-3 min-w-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl overflow-hidden bg-surface-container-highest">
                      <img alt="Dish image" class="w-full h-full object-cover" data-alt="close up of a vibrant healthy poke bowl with salmon, avocado, and fresh greens in a ceramic bowl" src="<?= BASE_URL ?>/assets/images/employee_dashboard/poke_bowl.jpg" />
                    </div>
                    <div class="min-w-0">
                      <p class="font-bold text-on-surface text-sm md:text-base truncate">Salmon Steak Rice</p>
                      <p class="text-xs text-outline">x1 • Extra Sambal</p>
                    </div>
                  </div>
                  <span class="font-semibold text-on-surface text-sm md:text-base flex-shrink-0">Rp 85.000</span>
                </div>
                <div class="flex justify-between items-center gap-3 group">
                  <div class="flex gap-2 md:gap-3 min-w-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl overflow-hidden bg-surface-container-highest">
                      <img alt="Dish image" class="w-full h-full object-cover" data-alt="chilled citrus mocktail with fresh mint leaves and ice cubes in a tall elegant glass" src="<?= BASE_URL ?>/assets/images/employee_dashboard/citrus_mocktail.jpg" />
                    </div>
                    <div class="min-w-0">
                      <p class="font-bold text-on-surface text-sm md:text-base truncate">Iced Citrus Mint</p>
                      <p class="text-xs text-outline">x2 • Less Ice</p>
                    </div>
                  </div>
                  <span class="font-semibold text-on-surface text-sm md:text-base flex-shrink-0">Rp 56.000</span>
                </div>
              </div>
              <div class="border-t border-outline-variant/30 pt-4 md:pt-6 space-y-2 md:space-y-3">
                <div class="flex justify-between text-on-surface-variant">
                  <span class="text-xs md:text-sm">Subtotal</span>
                  <span class="font-medium text-sm md:text-base">Rp 141.000</span>
                </div>
                <div class="flex justify-between text-on-surface-variant">
                  <span class="text-xs md:text-sm">Tax (PB1 10%)</span>
                  <span class="font-medium text-sm md:text-base">Rp 14.100</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                  <span class="text-base md:text-lg font-bold text-on-surface">Grand Total</span>
                  <span class="text-xl md:text-2xl font-black text-primary tracking-tight" x-text="'Rp ' + formatMoney(total)">Rp 155.000</span>
                </div>
              </div>
            </div>
            <div class="bg-secondary-container/10 border border-secondary-container/20 p-3 md:p-4 rounded-xl md:rounded-2xl flex items-start gap-3">
              <span class="material-symbols-outlined text-secondary text-xl flex-shrink-0">info</span>
              <p class="text-xs text-on-secondary-container leading-relaxed">
                Pastikan jumlah uang yang diterima telah dihitung dengan benar sebelum memasukkan nominal ke sistem.
              </p>
            </div>
            <button class="w-full h-12 sm:h-14 bg-primary text-on-primary rounded-xl font-headline font-extrabold text-sm sm:text-base tracking-wide flex items-center justify-center gap-2 transition-all hover:shadow-lg hover:shadow-primary/10 active:scale-[0.97]">
              Batal
              <span class="material-symbols-outlined" data-icon="cancel">cancel</span>
            </button>
          </section>
          <!-- Center: Numeric Keypad -->
          <section class="lg:col-span-5 min-w-0">
            <div class="bg-surface-container-low rounded-2xl md:rounded-3xl p-4 md:p-6 lg:p-8 shadow-sm h-full overflow-hidden">
              <div class="mb-4 md:mb-6">
                <label class="text-xs md:text-sm font-bold text-outline block mb-2 uppercase tracking-widest">Uang Diterima</label>
                <div class="relative">
                  <div class="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 text-lg md:text-2xl font-black text-primary/40">Rp</div>
                  <input class="w-full bg-surface-container-lowest border-none rounded-2xl md:rounded-3xl py-4 md:py-6 pl-10 pr-11 md:pl-16 md:pr-16 text-xl sm:text-2xl md:text-4xl font-black text-on-surface focus:ring-4 focus:ring-primary/10 shadow-inner min-w-0" readonly="" type="text" :value="displayReceived" />
                  <button type="button" @click="backspace()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 p-1 md:p-2 text-outline hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-xl md:text-3xl">backspace</span>
                  </button>
                </div>
              </div>
              <!-- Keypad -->
              <div class="grid grid-cols-3 gap-2 md:gap-3 mb-4 md:mb-6">
                <button type="button" @click="append('1')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">1</button>
                <button type="button" @click="append('2')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">2</button>
                <button type="button" @click="append('3')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">3</button>
                <button type="button" @click="append('4')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">4</button>
                <button type="button" @click="append('5')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">5</button>
                <button type="button" @click="append('6')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">6</button>
                <button type="button" @click="append('7')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">7</button>
                <button type="button" @click="append('8')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">8</button>
                <button type="button" @click="append('9')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">9</button>
                <button type="button" @click="append('000')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">000</button>
                <button type="button" @click="append('0')" class="bg-surface-container-lowest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">0</button>
                <button type="button" @click="clear()" class="bg-surface-container-highest h-14 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl font-bold text-on-surface hover:bg-white active:scale-95 transition-all shadow-sm">C</button>
              </div>
              <!-- Quick Buttons -->
              <div class="grid grid-cols-2 gap-2 md:gap-3">
                <button type="button" @click="setReceived(total)" class="bg-secondary-container h-12 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center text-on-secondary-container font-bold text-xs sm:text-sm md:text-base hover:opacity-90 transition-opacity active:scale-95 shadow-sm">Uang Pas</button>
                <button type="button" @click="setReceived(200000)" class="bg-tertiary-fixed h-12 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center text-on-tertiary-fixed font-bold text-xs sm:text-sm md:text-base hover:opacity-90 transition-opacity active:scale-95 shadow-sm">Rp 200.000</button>
                <button type="button" @click="setReceived(160000)" class="bg-surface-container-highest h-12 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center text-on-surface font-bold text-xs sm:text-sm md:text-base hover:bg-white active:scale-95 transition-all shadow-sm">Rp 160.000</button>
                <button type="button" @click="setReceived(500000)" class="bg-surface-container-highest h-12 md:h-16 rounded-xl md:rounded-2xl flex items-center justify-center text-on-surface font-bold text-xs sm:text-sm md:text-base hover:bg-white active:scale-95 transition-all shadow-sm">Rp 500.000</button>
              </div>
            </div>
          </section>
          <!-- Right: Change & Final Action -->
          <section class="lg:col-span-3 flex flex-col gap-4 md:gap-6 min-w-0">
            <div
              :class="isPaidEnough ? 'bg-secondary text-on-secondary shadow-secondary/10' : 'bg-error-container text-on-error-container shadow-error/10'"
              class="rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-xl flex flex-col items-center justify-center text-center transition-colors">
              <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 rounded-full flex items-center justify-center mb-3 md:mb-4">
                <span class="material-symbols-outlined text-3xl md:text-4xl" style="font-variation-settings: 'FILL' 1;" x-text="isPaidEnough ? 'check_circle' : 'warning'">check_circle</span>
              </div>
              <h2 class="text-xs md:text-sm font-bold uppercase tracking-widest opacity-80 mb-1 md:mb-2" x-text="isPaidEnough ? 'Kembalian' : 'Kurang Bayar'">Kembalian</h2>
              <p class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight mb-1 md:mb-2" x-text="formatMoney(changeAbs)">45.000</p>
              <p class="text-base md:text-lg opacity-90 font-medium">Rupiah</p>
            </div>
            <div class="bg-surface-container-low rounded-2xl md:rounded-3xl p-4 md:p-6 border border-outline-variant/10">
              <h3 class="text-xs md:text-sm font-bold text-on-surface mb-3 md:mb-4">Metode Pembayaran Lain</h3>
              <div class="space-y-2 md:space-y-3">
                <button class="w-full flex items-center justify-between p-3 md:p-4 bg-surface-container-lowest rounded-xl md:rounded-2xl hover:bg-white transition-colors border border-transparent hover:border-primary/10">
                  <div class="flex items-center gap-2 md:gap-3 min-w-0">
                    <span class="material-symbols-outlined text-primary text-xl md:text-2xl">qr_code_2</span>
                    <span class="font-semibold text-on-surface text-sm md:text-base truncate">QRIS / Digital</span>
                  </div>
                  <span class="material-symbols-outlined text-outline">chevron_right</span>
                </button>
                <button class="w-full flex items-center justify-between p-3 md:p-4 bg-surface-container-lowest rounded-xl md:rounded-2xl hover:bg-white transition-colors border border-transparent hover:border-primary/10">
                  <div class="flex items-center gap-2 md:gap-3 min-w-0">
                    <span class="material-symbols-outlined text-primary text-xl md:text-2xl">credit_card</span>
                    <span class="font-semibold text-on-surface text-sm md:text-base truncate">Debit / Credit</span>
                  </div>
                  <span class="material-symbols-outlined text-outline">chevron_right</span>
                </button>
              </div>
            </div>
            <button
              type="button"
              :disabled="!isPaidEnough"
              :class="isPaidEnough ? 'bg-primary hover:bg-primary-container shadow-primary/30 active:scale-95' : 'bg-outline/30 shadow-none cursor-not-allowed'"
              class="w-full py-6 md:py-8 px-4 md:px-6 rounded-2xl md:rounded-3xl flex flex-col items-center justify-center gap-2 shadow-2xl group transition-all">
              <span class="material-symbols-outlined text-on-primary text-3xl md:text-4xl">print</span>
              <span class="text-on-primary font-bold text-base md:text-xl text-center leading-tight">Konfirmasi &amp; Cetak Struk</span>
            </button>
          </section>
        </div>
      </div>
    </main>
  </div>
  <script>
    function cashPaymentCalculator(total, initialReceived = 0) {
      return {
        total,
        receivedRaw: String(initialReceived),
        get received() {
          return Number(this.receivedRaw || 0);
        },
        get displayReceived() {
          return this.formatMoney(this.received);
        },
        get change() {
          return this.received - this.total;
        },
        get changeAbs() {
          return Math.abs(this.change);
        },
        get isPaidEnough() {
          return this.change >= 0;
        },
        formatMoney(value) {
          return Number(value || 0).toLocaleString('id-ID');
        },
        setReceived(value) {
          this.receivedRaw = String(Math.max(0, Number(value || 0)));
        },
        append(value) {
          const nextValue = (this.receivedRaw + value).replace(/^0+(?=\d)/, '');

          if (nextValue.length > 12) {
            return;
          }

          this.receivedRaw = nextValue === '' ? '0' : nextValue;
        },
        backspace() {
          this.receivedRaw = this.receivedRaw.slice(0, -1) || '0';
        },
        clear() {
          this.receivedRaw = '0';
        },
        handleKey(event) {
          if (event.ctrlKey || event.metaKey || event.altKey) {
            return;
          }

          if (/^\d$/.test(event.key)) {
            event.preventDefault();
            this.append(event.key);
            return;
          }

          if (event.key === 'Backspace') {
            event.preventDefault();
            this.backspace();
            return;
          }

          if (event.key === 'Escape' || event.key.toLowerCase() === 'c') {
            event.preventDefault();
            this.clear();
          }
        }
      };
    }
  </script>
</body>

</html>
