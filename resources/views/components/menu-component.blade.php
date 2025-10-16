<nav class="relative h-[55px] bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-300 shadow-[0_3px_10px_rgba(255,200,0,0.3)] overflow-visible border-t border-yellow-500 select-none z-30">

 

  {{-- 🌟 Điện chạy nền --}}
  <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.3)_0%,transparent_70%)] animate-electric opacity-70"></div>

  {{-- 🌈 Menu chính --}}
  <div class="max-w-7xl mx-auto h-full flex items-center justify-center space-x-8 text-yellow-900 font-semibold text-[15px] relative z-20">
    @forelse($menus as $menu)
      <div class="group relative">
        <a href="{{ $menu->link ?? '#' }}"
           class="px-3 py-1 inline-block transition-all duration-200 hover:text-yellow-700 hover:scale-110 relative">
          <span class="relative z-10">{{ $menu->name }}</span>

          {{-- ⚡ Hiệu ứng viền vàng dưới --}}
          <span class="absolute left-0 bottom-0 w-0 h-[2px] bg-yellow-700 transition-all duration-300 group-hover:w-full rounded-full shadow-[0_0_6px_rgba(255,255,0,0.9)]"></span>

          {{-- 🌟 Hiệu ứng ánh sáng nền khi hover --}}
          <span class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-[radial-gradient(circle,rgba(255,255,0,0.15)_0%,transparent_70%)] blur-md transition-all duration-500"></span>
        </a>

        {{-- 🟡 Dropdown mượt mà --}}
        @if($menu->children->count())
          <div class="absolute left-1/2 -translate-x-1/2 mt-2 hidden group-hover:block bg-white shadow-[0_8px_16px_rgba(0,0,0,0.15)] rounded-xl border border-yellow-200 transform scale-95 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 ease-out min-w-[180px]">
            <ul class="py-2 text-gray-700">
              @foreach($menu->children as $child)
                <li>
                  <a href="{{ $child->link ?? '#' }}"
                     class="block px-4 py-2 hover:bg-yellow-100 hover:text-yellow-700 rounded-md transition-all duration-200 relative overflow-hidden group">
                    <span class="relative z-10">{{ $child->name }}</span>
                    <span class="absolute left-0 top-0 w-0 h-full bg-yellow-200 opacity-30 transition-all duration-300 group-hover:w-full"></span>
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    @empty
      <span class="text-gray-600 italic">Chưa có menu</span>
    @endforelse
  </div>
</nav>

<style>
/* 🏃 Pikachu chạy qua màn hình */
@keyframes pikachuRun {
  0%   { transform: translateX(-120px) scaleX(1); }
  45%  { transform: translateX(100vw) scaleX(1); }
  50%  { transform: translateX(100vw) scaleX(-1); }
  95%  { transform: translateX(-120px) scaleX(-1); }
  100% { transform: translateX(-120px) scaleX(1); }
}
.animate-pikachu {
  animation: pikachuRun 12s linear infinite;
}

/* ⚡ Hiệu ứng điện nền chớp */
@keyframes electricPulse {
  0%,100% { opacity: 0.5; filter: brightness(1); }
  50% { opacity: 0.9; filter: brightness(1.5); }
}
.animate-electric {
  animation: electricPulse 2.8s ease-in-out infinite;
}

/* ✨ Ánh sáng nhỏ khi hover menu */
nav a:hover {
  text-shadow: 0 0 6px rgba(255,255,150,0.9), 0 0 12px rgba(255,255,200,0.6);
}

/* 🧲 Hiệu ứng hover dropdown mềm mại */
nav .group:hover > div {
  transform: translateY(4px) scale(1.02);
  transition: all 0.3s ease-in-out;
}

/* 🔆 Thêm hiệu ứng sáng viền dưới Pikachu khi chạy */
#pikachu-run img {
  filter: drop-shadow(0 0 8px rgba(255,255,0,0.7)) drop-shadow(0 0 16px rgba(255,255,0,0.4));
}
</style>
