<x-layout-user>
    <main class="px-4 sm:px-6 md:px-10 lg:px-16 xl:px-24 bg-white">
        <section id="allPosts" 
            class="relative max-w-[1400px] mx-auto mt-12 mb-24 px-6 md:px-10 xl:px-16 py-12
                   bg-white rounded-3xl border border-gray-100">

            <!-- 🌟 Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 flex items-center gap-3">
                        <i class="fas fa-newspaper text-yellow-600"></i>
                        <span class="text-yellow-700">Tất cả bài viết</span>
                    </h1>
                    <p class="text-gray-600 mt-2 text-base">
                        Khám phá tin tức, đánh giá, hướng dẫn và xu hướng công nghệ mới nhất.
                    </p>
                </div>

                <!-- 🔍 Ô tìm kiếm -->
                <form action="{{ route('post.index') }}" method="GET" class="relative w-full md:w-auto">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Tìm kiếm bài viết..."
                        class="pl-4 pr-10 py-2 rounded-full border border-yellow-300 bg-white shadow-sm
                               focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none
                               w-full md:w-80 transition-all duration-300 placeholder:text-gray-400" />
                    <button type="submit" 
                            class="absolute right-4 top-2.5 text-yellow-600 hover:text-yellow-800 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- 🖼️ Bài viết nổi bật -->
            @if($posts->count())
            <div class="relative rounded-2xl overflow-hidden mb-10">
                @php $featured = $posts->first(); @endphp
                <a href="{{ route('post.show', $featured->slug) }}">
                    <img src="{{ asset('assets/images/post/' . $featured->thumbnail) }}" 
                        alt="{{ $featured->title }}" 
                        class="w-full h-80 object-cover rounded-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-sm md:text-base text-white/90 w-3/4">
                            {{ Str::limit($featured->description, 120) }}
                        </p>
                    </div>
                </a>
            </div>
            @endif

            <!-- 🧩 Danh sách bài viết -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts->skip(1) as $post)
                <a href="{{ route('post.show', $post->slug) }}" 
                class="post-card block bg-white rounded-2xl overflow-hidden 
                       shadow hover:shadow-lg border border-gray-100 
                       transition-all duration-300 hover:-translate-y-1 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/images/post/' . $post->thumbnail) }}" 
                            alt="{{ $post->title }}" 
                            class="w-full h-52 object-cover transform group-hover:scale-105 
                                   transition-transform duration-700 ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t 
                                    from-black/40 via-transparent to-transparent opacity-0 
                                    group-hover:opacity-100 transition-all duration-500"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 line-clamp-2 
                                   group-hover:text-yellow-600 transition-colors">
                            {{ $post->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-3">
                            {{ Str::limit($post->description, 100, '...') }}
                        </p>
                        <div class="mt-3 flex justify-between items-center text-sm text-gray-500">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>{{ $post->created_at->format('d/m/Y') }}
                            </span>
                            <span class="text-yellow-600 font-semibold hover:text-yellow-700 transition">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- 🔁 Phân trang -->
            <div class="mt-12 text-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </section>
    </main>

    <!-- 💅 CSS -->
    <style>
    .line-clamp-2 {
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box; -webkit-line-clamp: 3;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    </style>
</x-layout-user>
