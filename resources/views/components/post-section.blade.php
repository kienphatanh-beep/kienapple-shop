<section id="postSection" 
         class="max-w-6xl mx-auto mt-12 mb-24 bg-gradient-to-b from-yellow-50 via-white to-yellow-100 rounded-3xl shadow-xl p-8 pb-20 overflow-hidden relative animate-fadeIn">

    <!-- 🌟 Header -->
    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <h2 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
            ✨ Mạng xã hội <span class="text-yellow-600 drop-shadow">applekien.com</span>
        </h2>
        <a href="{{ route('post.index') }}"
           class="text-yellow-700 hover:text-yellow-900 font-semibold text-sm flex items-center gap-1 transition-colors duration-300">
            Xem thêm 
            <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>

    <!-- 📰 Danh sách bài viết -->
    <div id="postGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($posts as $post)
            <a href="{{ route('post.show', $post->slug) }}"
               class="post-card group bg-white rounded-2xl shadow-md hover:shadow-2xl border border-yellow-100 transition-all duration-500 overflow-hidden relative hover:-translate-y-2 hover:border-yellow-300">

                <div class="relative overflow-hidden">
                  <img src="{!! htmlspecialchars_decode($post->thumbnail) !!}"
     alt="{{ $post->title }}"
     class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                </div>

                <div class="p-4 relative z-10">
                    <h3 class="text-base font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-yellow-700 transition-colors duration-300">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3 group-hover:text-gray-800 transition-colors duration-300">
                        {{ Str::limit($post->description, 100, '...') }}
                    </p>
                </div>

                <!-- ✨ Viền sáng -->
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-200/0 via-yellow-100/0 to-yellow-300/0 group-hover:from-yellow-100/30 group-hover:to-yellow-200/40 blur-xl opacity-0 group-hover:opacity-100 transition-all duration-700 rounded-2xl"></div>
            </a>
        @endforeach
    </div>


</section>

<!-- 💅 CSS -->
<style>
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(50px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeInUp 1s ease-out; }

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

<!-- ⚡ JavaScript hiệu ứng -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Fade-in từng bài viết
    const cards = document.querySelectorAll(".post-card");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => {
        card.style.opacity = 0;
        card.style.transform = "translateY(40px)";
        observer.observe(card);
    });

    // 🌊 Ripple button effect
    const btn = document.getElementById("moreBtn");
    btn.addEventListener("click", e => {
        const ripple = btn.querySelector(".ripple");
        const rect = btn.getBoundingClientRect();
        ripple.style.left = `${e.clientX - rect.left}px`;
        ripple.style.top = `${e.clientY - rect.top}px`;
        ripple.style.opacity = "1";
        ripple.style.transform = "scale(0)";
        ripple.animate([
            { transform: "scale(0)", opacity: 0.6 },
            { transform: "scale(3)", opacity: 0 }
        ], { duration: 700, easing: "ease-out" });
    });

    // ✨ Fade-in section khi load
    const section = document.getElementById("postSection");
    section.style.opacity = 0;
    section.style.transform = "translateY(50px)";
    setTimeout(() => {
        section.style.transition = "all 0.8s ease-out";
        section.style.opacity = 1;
        section.style.transform = "translateY(0)";
    }, 100);
});
</script>
