<x-layout-user>
    <main class="px-4 sm:px-6 md:px-10 lg:px-16 xl:px-24 bg-[#fffef8]">
        <article id="postDetail" 
            class="max-w-5xl mx-auto mt-10 mb-24 bg-white rounded-3xl shadow-lg p-8 md:p-12 border border-yellow-100 relative overflow-hidden">

            <!-- ✨ Hiệu ứng ánh sáng viền -->
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-transparent via-yellow-50/60 to-transparent opacity-0 hover:opacity-100 transition-all duration-700 blur-2xl rounded-3xl"></div>

            <!-- 🌟 Tiêu đề -->
            <header class="text-center mb-10 relative z-10">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3 animate-fadeDown">
                    {{ $post->title }}
                </h1>
                <div class="flex justify-center items-center text-sm text-gray-500 gap-4 animate-fadeDown delay-100">
                    <span><i class="far fa-calendar-alt"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                    <span><i class="fas fa-user"></i> Admin</span>
                    <span><i class="fas fa-tag"></i> {{ $post->topic->name ?? 'Tin tức' }}</span>
                </div>
            </header>

            <!-- 🖼 Ảnh đại diện -->
            @if ($post->image)
            <div class="overflow-hidden rounded-2xl mb-10 shadow-sm animate-fadeZoom">
                <img src="{{ asset('assets/images/post/' . $post->thumbnail) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-[450px] object-cover transform hover:scale-105 transition-transform duration-700 ease-in-out">
            </div>
            @endif

            <!-- 📄 Nội dung -->
            <section class="prose max-w-none text-gray-800 leading-relaxed text-lg animate-fadeIn">
                {!! $post->detail !!}
            </section>

            <!-- 🧭 Thanh chia sẻ -->
            <div class="mt-10 flex flex-wrap justify-between items-center border-t border-yellow-100 pt-6 animate-fadeUp">
                <div class="flex items-center gap-3 text-gray-600">
                    <i class="fas fa-share-alt text-yellow-500"></i>
                    <span>Chia sẻ bài viết:</span>
                    <a href="#" class="hover:text-yellow-600 transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-yellow-600 transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-yellow-600 transition"><i class="fab fa-linkedin-in"></i></a>
                </div>

                <a href="{{ route('post.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white rounded-full shadow hover:bg-yellow-600 transition-all duration-300 font-semibold">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </article>

        <!-- 📰 Bài viết liên quan -->
        @if ($relatedPosts->count())
        <section class="max-w-6xl mx-auto mb-20">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
                <i class="fas fa-newspaper text-yellow-500"></i> Bài viết liên quan
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($relatedPosts as $related)
                <a href="{{ route('post.show', $related->slug) }}"
                   class="related-card bg-white rounded-2xl shadow-sm hover:shadow-xl border border-yellow-100 transition-all duration-500 hover:-translate-y-1 group overflow-hidden">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/post/' . $related->thumbnail) }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-800 line-clamp-2 group-hover:text-yellow-600 transition">
                            {{ $related->title }}
                        </h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                            {{ Str::limit($related->description, 100) }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </main>

    <!-- 💅 Style -->
    <style>
        .line-clamp-2 {
            display: -webkit-box; -webkit-line-clamp: 2;
            -webkit-box-orient: vertical; overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box; -webkit-line-clamp: 3;
            -webkit-box-orient: vertical; overflow: hidden;
        }

        @keyframes fadeDown { from {opacity:0; transform:translateY(-20px);} to {opacity:1; transform:translateY(0);} }
        @keyframes fadeUp { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
        @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
        @keyframes fadeZoom { from {opacity:0; transform:scale(0.95);} to {opacity:1; transform:scale(1);} }

        .animate-fadeDown { animation: fadeDown 0.8s ease-out both; }
        .animate-fadeUp { animation: fadeUp 0.8s ease-out both; }
        .animate-fadeIn { animation: fadeIn 1s ease-out both; }
        .animate-fadeZoom { animation: fadeZoom 1s ease-out both; }
    </style>

    <!-- ⚡ Hiệu ứng cuộn -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.related-card');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeUp');
                }
            });
        }, { threshold: 0.2 });

        cards.forEach(card => observer.observe(card));
    });
    </script>
</x-layout-user>
