<x-layout-user>
    <x-slot:title>Đăng Nhập</x-slot:title>

    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 font-sans px-4 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none z-0">
            <canvas id="rainCanvas" class="w-full h-full"></canvas>
        </div>

        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-2xl z-10 relative animate-fadeInUp">
            <div class="flex flex-col items-center mb-6">
                <i class="fa-solid fa-user-lock text-4xl text-blue-600 mb-2 animate-bounce"></i>
                <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white">Đăng Nhập</h2>
                <p class="text-gray-500 text-sm text-center">Chào mừng bạn quay trở lại!</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 px-4 py-2 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Tên đăng nhập hoặc Email
                    </label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Mật khẩu
                    </label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 text-gray-600 dark:text-gray-300">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>Ghi nhớ tôi</span>
                    </label>

                    <a href="{{ route('forgot.show') }}"
                       class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-all duration-200">
                        Quên mật khẩu?
                    </a>
                </div>

                <button type="submit"
                    class="w-full py-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-500
                           text-white font-semibold rounded-lg shadow-lg
                           hover:scale-105 active:scale-95 transition-all duration-300">
                    Đăng nhập
                </button>

                <p class="text-center text-gray-500 text-sm mt-3">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">
                        Đăng ký ngay
                    </a>
                </p>
            </form>
        </div>
    </div>

    {{-- Hiệu ứng mưa & sấm sét --}}
    <script>
        const canvas = document.getElementById('rainCanvas');
        const ctx = canvas.getContext('2d');
        let drops = [];
        let thunderTimer = 0;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        function createRainDrop() {
            return { x: Math.random() * canvas.width, y: Math.random() * canvas.height, length: Math.random() * 20 + 10, speed: Math.random() * 5 + 2 };
        }
        for (let i = 0; i < 200; i++) drops.push(createRainDrop());

        function drawRain() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.strokeStyle = 'rgba(255,255,255,0.3)';
            ctx.lineWidth = 1;

            for (let drop of drops) {
                ctx.beginPath();
                ctx.moveTo(drop.x, drop.y);
                ctx.lineTo(drop.x, drop.y + drop.length);
                ctx.stroke();

                drop.y += drop.speed;
                if (drop.y > canvas.height) {
                    drop.y = -drop.length;
                    drop.x = Math.random() * canvas.width;
                }
            }

            if (Math.random() < 0.02) thunderEffect();
            requestAnimationFrame(drawRain);
        }

        function thunderEffect() {
            if (thunderTimer === 0) {
                thunderTimer = Date.now();
                let thunderDuration = Math.random() * 1000 + 500;
                let thunderColor = 'rgba(255, 255, 255, 0.8)';

                let flash = setInterval(() => {
                    ctx.fillStyle = thunderColor;
                    ctx.globalAlpha = 0.8;
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.globalAlpha = 1;
                }, 100);

                setTimeout(() => {
                    clearInterval(flash);
                    thunderTimer = 0;
                }, thunderDuration);
            }
        }
        drawRain();
    </script>

    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease forwards;
        }
    </style>
</x-layout-user>
