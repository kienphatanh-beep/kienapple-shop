<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kiên Apple')</title>
<style>
/* 🌈 Hiệu ứng vào trang mượt mà */
@keyframes fadeInBody {
  0% { opacity: 0; transform: translateY(20px) scale(0.98); filter: blur(6px); }
  100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
}

/* ✨ Header trượt xuống */
@keyframes slideDown {
  0% { opacity: 0; transform: translateY(-30px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* 💫 Main nội dung trượt nhẹ lên */
@keyframes slideUp {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* 🌟 Footer trượt lên mờ */
@keyframes slideFooter {
  0% { opacity: 0; transform: translateY(40px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Hiệu ứng chung */
.animate-body {
  animation: fadeInBody 1.2s ease-in-out forwards;
}
.animate-header {
  animation: slideDown 0.8s ease-out forwards;
}
.animate-main {
  animation: slideUp 1.1s ease-out forwards;
}
.animate-footer {
  animation: slideFooter 1s ease-in-out forwards;
}

/* Mượt mà khi cuộn */
html {
  scroll-behavior: smooth;
}
</style>

  <!-- Tailwind & Flowbite -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.0/flowbite.min.js"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- Google Fonts: Roboto -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
   <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-900" style="font-family: 'Roboto', Arial, Helvetica, sans-serif;">

  <!-- Header -->
  <header class="bg-yellow-400 shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <img src="{{ asset('assets/images/category/apple.png') }}"
             class="h-10 w-10" alt="Logo" />
        <span class="text-2xl font-bold text-black">Kiên Apple</span>
      </div>

<!-- Search (desktop - nhỏ gọn hơn) -->
<form action="{{ route('site.search') }}" method="GET" class="hidden md:flex flex-1 mx-4 max-w-md">
  <input
    type="text"
    name="q"
    placeholder="🔍 Tìm kiếm sản phẩm..."
    class="w-full rounded-full px-4 py-[6px] text-sm border border-yellow-300 bg-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-400 placeholder-gray-400 shadow-sm transition duration-200"
    value="{{ request('q') }}"
  />
</form>

<!-- Actions -->
<div class="flex items-center space-x-4 text-black font-medium relative">
<div class="relative" id="accountWrapper">
  <!-- Nút mở dropdown -->
  <button id="accountBtn"
          class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/80 backdrop-blur-sm shadow-sm border border-yellow-200 hover:bg-yellow-50 hover:shadow-md transition duration-200 focus:outline-none">
    <i class="fa-regular fa-user text-yellow-700"></i>
    @auth
      <span class="font-semibold text-gray-800">{{ Auth::user()->username }}</span>
    @else
      <span class="font-semibold text-gray-700">Tài Khoản</span>
    @endauth
    <i id="arrowIcon" class="fa-solid fa-chevron-down text-xs text-yellow-600 transition-transform duration-200"></i>
  </button>

<!-- Dropdown -->
<div id="accountDropdown"
     class="absolute right-0 mt-2 w-48 bg-white border border-yellow-200 rounded-xl shadow-lg opacity-0 scale-95 transform origin-top transition-all duration-300 hidden z-50">
  @auth
    {{-- 🛍️ Đơn hàng đã mua --}}
    <a href="{{ route('orders.history') }}" 
       class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 rounded-t-xl transition duration-150">
      🛍️ <span>Đơn đã mua</span>
    </a>

    {{-- ❤️ Danh sách yêu thích --}}
    <a href="{{ route('wishlist.index') }}" 
       class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition duration-150">
      ❤️ <span>Yêu thích</span>
    </a>

   {{-- ⚙️ Cài đặt --}}
<a href="{{ route('settings') }}" 
   class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition duration-150">
  ⚙️ <span>Cài đặt</span>
</a>


    {{-- 🚪 Đăng xuất --}}
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
              class="flex items-center gap-2 w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-b-xl transition duration-150">
        🚪 <span>Đăng xuất</span>
      </button>
    </form>

  @else
    {{-- ✨ Đăng ký --}}
    <a href="{{ route('register') }}" 
       class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition duration-150">
      ✨ <span>Đăng Ký</span>
    </a>

    {{-- 🔑 Đăng nhập --}}
    <a href="{{ route('login') }}" 
       class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 rounded-b-xl transition duration-150">
      🔑 <span>Đăng Nhập</span>
    </a>
  @endauth
</div>

</div>
<script>
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        const img = this.closest('.card, .product-item')?.querySelector('img');
        const cartIcon = document.querySelector('.fa-cart-shopping');

        if (!img || !cartIcon) {
            this.closest('form')?.submit();
            return;
        }

        const imgClone = img.cloneNode(true);
        const rect = img.getBoundingClientRect();
        const cartRect = cartIcon.getBoundingClientRect();

        imgClone.style.position = 'fixed';
        imgClone.style.left = rect.left + 'px';
        imgClone.style.top = rect.top + 'px';
        imgClone.style.width = rect.width + 'px';
        imgClone.style.height = rect.height + 'px';
        imgClone.style.borderRadius = '10px';
        imgClone.style.transition = 'all 1s cubic-bezier(0.45, 0, 0.55, 1)';
        imgClone.style.zIndex = 9999;
        document.body.appendChild(imgClone);

        setTimeout(() => {
            imgClone.style.left = cartRect.left + 'px';
            imgClone.style.top = cartRect.top + 'px';
            imgClone.style.width = '20px';
            imgClone.style.height = '20px';
            imgClone.style.opacity = '0.2';
        }, 10);

        setTimeout(() => {
            imgClone.remove();
            // ✅ Gửi form thêm giỏ hàng sau animation
            this.closest('form')?.submit();
        }, 900);
    });
});
</script>

<!-- ✅ Script toggle -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("accountBtn");
  const dropdown = document.getElementById("accountDropdown");
  const arrow = document.getElementById("arrowIcon");
  const wrapper = document.getElementById("accountWrapper");

  btn.addEventListener("click", (e) => {
    e.stopPropagation();

    const isHidden = dropdown.classList.contains("hidden");

    if (isHidden) {
      dropdown.classList.remove("hidden");
      setTimeout(() => {
        dropdown.classList.remove("opacity-0", "scale-95");
      }, 10);
      arrow.classList.add("rotate-180");
    } else {
      dropdown.classList.add("opacity-0", "scale-95");
      arrow.classList.remove("rotate-180");
      setTimeout(() => {
        dropdown.classList.add("hidden");
      }, 200);
    }
  });

  window.addEventListener("click", (e) => {
    if (!wrapper.contains(e.target)) {
      dropdown.classList.add("opacity-0", "scale-95");
      arrow.classList.remove("rotate-180");
      setTimeout(() => {
        dropdown.classList.add("hidden");
      }, 200);
    }
  });
});
</script>




 
<!-- Cart -->
@auth
  <a href="{{ route('cart.index') }}" class="relative flex items-center space-x-1 hover:text-gray-700">
      <i class="fa-solid fa-cart-shopping text-lg"></i>

      {{-- 🔢 Số lượng sản phẩm trong giỏ --}}
      @if(isset($cartCount) && $cartCount > 0)
          <span class="absolute -top-2 -right-3 bg-red-600 text-white text-[10px] font-bold rounded-full px-[6px] py-[1px] shadow-md">
              {{ $cartCount }}
          </span>
      @endif

      <span class="hidden md:inline">Giỏ hàng</span>
  </a>
@else
  <a href="{{ route('login') }}" class="relative flex items-center space-x-1 hover:text-gray-700">
      <i class="fa-solid fa-cart-shopping text-lg"></i>

      @if(isset($cartCount) && $cartCount > 0)
          <span class="absolute -top-2 -right-3 bg-red-600 text-white text-[10px] font-bold rounded-full px-[6px] py-[1px] shadow-md">
              {{ $cartCount }}
          </span>
      @endif

      <span class="hidden md:inline">Giỏ hàng</span>
  </a>
@endauth



  <!-- Location -->
  <a href="#"
     class="hidden md:flex items-center space-x-1 bg-yellow-300 px-3 py-1 rounded-full hover:bg-yellow-500 transition">
    <i class="fa-solid fa-location-dot"></i>
    <span>TP. Hồ Chí Minh</span>
  </a>
</div>


{{-- Search (mobile) --}}
<div class="block md:hidden px-4 pb-3">
  <form action="{{ route('site.search') }}" method="GET" class="flex gap-2">
    <input
      type="text"
      name="q"
      value="{{ request('q') }}"
      placeholder="Tìm kiếm sản phẩm..."
      class="w-full rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-600 js-search-input" />
    <button type="submit" class="px-4 py-2 rounded-full bg-yellow-600 text-white font-semibold">
      Tìm
    </button>
  </form>
</div>
</div>

    <!-- Navigation Menu -->
  <x-menu-component />
  </header>

  <!-- Main content -->
  <main class="flex-grow">
    {{-- Hỗ trợ 2 cách dùng: @section hoặc <x-layout-user> --}}
    @yield('content')
    {{ $slot ?? '' }}
  </main>
<!-- 💬 Floating Chat AI -->
<!-- 🌟 Nút hình ảnh trợ lý AI nổi -->
<button id="chat-ai-toggle"
        class="fixed bottom-6 right-6 w-16 h-16 rounded-full shadow-xl overflow-hidden border-2 border-yellow-400 bg-white hover:scale-110 hover:shadow-yellow-300 transition-all duration-300 z-50 animate-bounce">
    <img src="{{ asset('assets/images/troliai.png') }}" 
         alt="Trợ lý AI" 
         class="w-full h-full object-cover">
</button>

<!-- 💬 Hộp Chat AI -->
<div id="chat-ai-box"
     class="fixed bottom-24 right-6 w-80 bg-white border border-yellow-300 rounded-2xl shadow-2xl hidden flex-col overflow-hidden animate__animated animate__fadeInUp z-50">

    <!-- Header -->
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-bold px-4 py-3 flex justify-between items-center">
        <span>Trợ lý Kiên Apple 🤖</span>
        <button id="chat-ai-close" class="text-white hover:text-yellow-100 transition text-lg">✖</button>
    </div>

    <!-- Nội dung chat -->
    <div id="chat-ai-messages" class="flex-1 p-3 h-80 overflow-y-auto bg-yellow-50 space-y-2 text-sm"></div>

    <!-- Ô nhập -->
    <form id="chat-ai-form" class="flex border-t border-yellow-200">
        <input type="text" id="chat-ai-input"
               class="flex-1 p-2 outline-none text-gray-800"
               placeholder="Nhập câu hỏi...">
        <button type="submit"
                class="bg-yellow-500 text-white px-4 hover:bg-yellow-600 transition">Gửi</button>
    </form>
</div>

<!-- 💫 CSS hiệu ứng + khung chat -->
<style>
@keyframes slideIn {
  0% { transform: translateY(100px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}

#chat-ai-box.show {
  display: flex !important;
  animation: slideIn 0.4s ease forwards;
}

.message-user {
  text-align: right;
  background: #fde68a;
  padding: 8px 12px;
  border-radius: 14px 14px 0 14px;
  max-width: 80%;
  margin-left: auto;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  word-break: break-word;
}

.message-ai {
  text-align: left;
  background: #fff;
  padding: 8px 12px;
  border-radius: 14px 14px 14px 0;
  max-width: 80%;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  word-break: break-word;
}

/* 🌈 Hiệu ứng nút ảnh nổi nhẹ */
#chat-ai-toggle {
  animation: float 3s ease-in-out infinite;
}
@keyframes float {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-6px); }
}
</style>

<!-- 🧠 Script Chat -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("chat-ai-toggle");
    const box = document.getElementById("chat-ai-box");
    const closeBtn = document.getElementById("chat-ai-close");
    const form = document.getElementById("chat-ai-form");
    const input = document.getElementById("chat-ai-input");
    const messages = document.getElementById("chat-ai-messages");

    // 🌟 Mở / đóng chatbot
    toggle.addEventListener("click", () => {
        box.classList.toggle("show");
        toggle.classList.toggle("hidden");
    });
    closeBtn.addEventListener("click", () => {
        box.classList.remove("show");
        toggle.classList.remove("hidden");
    });

    // ✉️ Thêm tin nhắn
    function appendMessage(text, type) {
        const div = document.createElement("div");
        div.className = type === "user" ? "message-user" : "message-ai";
        div.textContent = text;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    // 🚀 Gửi tin nhắn
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const msg = input.value.trim();
        if (!msg) return;
        appendMessage(msg, "user");
        input.value = "";

        // Hiệu ứng đang phản hồi
        const typing = document.createElement("div");
        typing.className = "message-ai italic text-gray-400";
        typing.textContent = "🤖 Đang phản hồi...";
        messages.appendChild(typing);
        messages.scrollTop = messages.scrollHeight;

        try {
            const res = await fetch("{{ route('chat.ai') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: msg })
            });

            const data = await res.json();
            typing.remove();
            appendMessage(data.reply, "ai");

            // 💫 Viền sáng nhẹ khi có phản hồi
            box.classList.add("ring-2", "ring-yellow-400");
            setTimeout(() => box.classList.remove("ring-2", "ring-yellow-400"), 600);
        } catch (err) {
            typing.remove();
            appendMessage("❌ Lỗi kết nối đến ChatGPT API!", "ai");
        }
    });
});
</script>




  <!-- Footer -->
  <footer class="bg-yellow-400 text-black shadow-inner border-t border-yellow-500">
    <div class="max-w-6xl mx-auto py-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Giới thiệu -->
      <div>
        <h3 class="text-xl font-bold mb-3">🌟 Về chúng tôi</h3>
        <p class="text-sm leading-relaxed">
          Chúng tôi cung cấp những sản phẩm chất lượng với giá tốt nhất. Đảm bảo uy tín – nhanh chóng – chuyên nghiệp.
        </p>
      </div>

      <!-- Liên hệ -->
      <div>
        <h3 class="text-xl font-bold mb-3">📞 Liên hệ</h3>
        <ul class="text-sm space-y-1">
          <li>Email: <a href="mailto:support@shop.com" class="hover:underline">support@shop.com</a></li>
          <li>Điện thoại: <a href="tel:0123456789" class="hover:underline">0123-456-789</a></li>
          <li>Địa chỉ: 123 Đường ABC, TP.HCM</li>
        </ul>
      </div>

      <!-- Mạng xã hội -->
      <div>
        <h3 class="text-xl font-bold mb-3">📱 Theo dõi chúng tôi</h3>
        <div class="flex space-x-4 text-2xl">
          <a href="#" class="hover:text-blue-200 transition-transform transform hover:scale-110"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-sky-200 transition-transform transform hover:scale-110"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-pink-200 transition-transform transform hover:scale-110"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="bg-yellow-500 border-t border-yellow-600 text-center text-sm py-4">
      <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <span>© 2025 <a href="#" class="hover:underline">Apple Kien™</a>. All Rights Reserved.</span>
      </div>
    </div>
  </footer>

</body>
</html>
