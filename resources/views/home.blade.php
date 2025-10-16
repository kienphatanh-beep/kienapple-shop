<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Flash Sale - Yellow Theme</title>

  <!-- Tailwind CDN (dev) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for icons -->
  <script src="https://kit.fontawesome.com/a2d9f8b4bb.js" crossorigin="anonymous"></script>

  <style>
    /* small extra styles */
    .card:hover { transform: translateY(-8px); transition: transform .25s ease, box-shadow .25s ease; }
    .card { transition: transform .25s ease, box-shadow .25s ease; }
    /* custom scrollbar for carousel */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  </style>
</head>
<body class="bg-gray-100">

  <div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header / Flash sale banner -->
    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-b from-yellow-400 to-yellow-300 border border-yellow-500 p-6 shadow-lg">
      <div class="flex items-center justify-between">
        <h2 class="text-white font-extrabold text-xl md:text-2xl drop-shadow-lg">FLASH SALE HỌC SINH - SINH VIÊN</h2>

        <!-- Countdown -->
        <div class="flex items-center space-x-2">
          <span class="text-white font-semibold">BẮT ĐẦU SAU:</span>
          <div id="countdown" class="flex items-center space-x-2 text-black font-bold bg-white/90 px-3 py-1 rounded-lg"></div>
        </div>
      </div>

      <!-- Tabs (time slots) -->
      <div class="mt-4 flex items-center gap-3">
        <div id="tabs" class="flex gap-3">
          <button class="px-4 py-2 rounded-full bg-white text-yellow-600 font-semibold shadow">9h - 11h 23/09</button>
          <button class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">9h - 11h 24/09</button>
        </div>

        <!-- nav arrows positioned right -->
        <div class="ml-auto flex items-center gap-2">
          <button id="prevBtn" class="w-10 h-10 rounded-full bg-white/80 hover:bg-white shadow flex items-center justify-center">
            <i class="fa fa-chevron-left"></i>
          </button>
          <button id="nextBtn" class="w-10 h-10 rounded-full bg-white/80 hover:bg-white shadow flex items-center justify-center">
            <i class="fa fa-chevron-right"></i>
          </button>
        </div>
      </div>

      <!-- Carousel container -->
      <div class="mt-6 relative">
        <div id="carousel" class="flex gap-5 overflow-x-auto hide-scrollbar pb-4">
          <!-- Cards injected by JS -->
        </div>

        <!-- bottom CTA bar -->
        <div class="mt-6 bg-yellow-600/90 text-white rounded-full px-4 py-2 text-center font-semibold">
          Chỉ áp dụng thanh toán online thành công — Mỗi SĐT chỉ được mua 1 sản phẩm cùng loại
        </div>
      </div>
    </div>

  </div>

<script>
/* Sample products data — thay bằng dữ liệu thật từ API khi integrate */
const products = [
  {
    id:1,
    name: "Laptop HP Pavilion 15 - i5-1335U",
    specs: "16GB | 512GB | 15.6\" Full HD",
    img: "https://via.placeholder.com/300x200?text=HP+Pavilion",
    price: 14751000,
    original_price: 19990000,
    sold: 0,
    stock: 5,
    badge: "Giảm 26%"
  },
  {
    id:2,
    name: "Laptop ASUS Vivobook S 16 OLED",
    specs: "24GB | 512GB | 16.0\" 3K",
    img: "https://via.placeholder.com/300x200?text=ASUS+Vivobook",
    price: 25101000,
    original_price: 30990000,
    sold: 0,
    stock: 5,
    badge: "Giảm 19%"
  },
  {
    id:3,
    name: "Laptop ASUS Vivobook 15 X1504VA",
    specs: "16GB | 512GB | 15.6\" Full HD",
    img: "https://via.placeholder.com/300x200?text=ASUS+15",
    price: 13491000,
    original_price: 16990000,
    sold: 0,
    stock: 5,
    badge: "Giảm 20%"
  },
  {
    id:4,
    name: "Robot hút bụi lau nhà Roborock Q10 PF",
    specs: "Lực hút 10000Pa",
    img: "https://via.placeholder.com/300x200?text=Roborock",
    price: 4290000,
    original_price: 6990000,
    sold: 0,
    stock: 50,
    badge: "Giảm 38%"
  },
  {
    id:5,
    name: "Chuột không dây Bluetooth Ugreen M751",
    specs: "Pin AA",
    img: "https://via.placeholder.com/300x200?text=Ugreen+Mouse",
    price: 399000,
    original_price: 590000,
    sold: 0,
    stock: 20,
    badge: "Giảm 32%"
  },
];

/* Utils */
function formatVND(n){
  return new Intl.NumberFormat('vi-VN').format(n) + 'đ';
}

/* Render cards into carousel */
const carousel = document.getElementById('carousel');

function buildCard(p){
  const soldCount = p.sold ?? 0;
  const stock = p.stock ?? 1;
  const soldPercent = Math.round((soldCount/stock)*100);

  const card = document.createElement('div');
  card.className = 'card min-w-[260px] max-w-[260px] bg-white rounded-2xl border shadow-sm p-3 flex flex-col';
  card.innerHTML = `
    <div class="relative">
      <img src="${p.img}" alt="${p.name}" class="w-full h-40 object-contain rounded-xl bg-gray-50" />
      <div class="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 text-xs rounded">${p.badge}</div>
    </div>
    <div class="mt-3 flex-1">
      <div class="text-xs text-gray-500">${p.specs}</div>
      <h3 class="mt-2 text-sm font-semibold text-gray-800">${p.name}</h3>
    </div>

    <div class="mt-3">
      <div class="flex items-baseline gap-3">
        <div class="text-lg font-extrabold text-yellow-600">${formatVND(p.price)}</div>
        <div class="text-sm line-through text-gray-400">${formatVND(p.original_price)}</div>
      </div>

      <div class="mt-3">
        <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
          <div class="h-3 bg-yellow-500" style="width: ${soldPercent}%;"></div>
        </div>
        <div class="mt-1 text-xs text-gray-500">Đã bán ${soldCount}/${stock} suất</div>
      </div>

      <div class="mt-3 flex gap-2">
        <button class="flex-1 py-2 rounded-full bg-yellow-600 text-white font-semibold hover:bg-yellow-700">Mua ngay</button>
        <button class="w-10 h-10 rounded-full border flex items-center justify-center text-yellow-600 hover:bg-yellow-50">
          <i class="fa fa-heart"></i>
        </button>
      </div>
    </div>
  `;
  return card;
}

function renderCarousel(){
  carousel.innerHTML = '';
  products.forEach(p => carousel.appendChild(buildCard(p)));
}

/* Carousel navigation */
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

prevBtn.addEventListener('click', ()=> {
  carousel.scrollBy({ left: -300, behavior: 'smooth' });
});
nextBtn.addEventListener('click', ()=> {
  carousel.scrollBy({ left: 300, behavior: 'smooth' });
});

/* enable mouse drag to scroll */
let isDown=false, startX, scrollLeft;
carousel.addEventListener('mousedown', (e)=>{
  isDown = true;
  carousel.classList.add('cursor-grabbing');
  startX = e.pageX - carousel.offsetLeft;
  scrollLeft = carousel.scrollLeft;
});
carousel.addEventListener('mouseleave', ()=> { isDown=false; carousel.classList.remove('cursor-grabbing'); });
carousel.addEventListener('mouseup', ()=> { isDown=false; carousel.classList.remove('cursor-grabbing'); });
carousel.addEventListener('mousemove', (e)=>{
  if(!isDown) return;
  e.preventDefault();
  const x = e.pageX - carousel.offsetLeft;
  const walk = (x - startX) * 1.2;
  carousel.scrollLeft = scrollLeft - walk;
});

/* Keyboard arrows */
document.addEventListener('keydown', (e)=>{
  if(e.key === 'ArrowRight') carousel.scrollBy({ left: 300, behavior: 'smooth' });
  if(e.key === 'ArrowLeft') carousel.scrollBy({ left: -300, behavior: 'smooth' });
});

/* Countdown timer example */
function startCountdown(durationSeconds){
  let remaining = durationSeconds;
  const el = document.getElementById('countdown');
  function tick(){
    if(remaining < 0) { el.textContent = '00 : 00 : 00'; return; }
    const h = Math.floor(remaining / 3600);
    const m = Math.floor((remaining % 3600) / 60);
    const s = remaining % 60;
    el.innerHTML = `
      <span class="bg-white px-2 py-1 rounded text-sm">${String(h).padStart(2,'0')}</span>
      <span class="text-white px-1">:</span>
      <span class="bg-white px-2 py-1 rounded text-sm">${String(m).padStart(2,'0')}</span>
      <span class="text-white px-1">:</span>
      <span class="bg-white px-2 py-1 rounded text-sm">${String(s).padStart(2,'0')}</span>
    `;
    remaining--;
  }
  tick();
  return setInterval(tick, 1000);
}

/* Init */
renderCarousel();
const countdownInterval = startCountdown(3600 * 2 + 15); // 2 hours + 15s

/* Example: responsive behavior - center first card on load on small screens */
window.addEventListener('load', ()=>{
  carousel.scrollLeft = 0;
});
</script>

</body>
</html>
