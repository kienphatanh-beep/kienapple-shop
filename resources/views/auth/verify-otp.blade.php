<x-layout-user>
    <x-slot:title>Xác minh mã OTP</x-slot:title>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-indigo-100 via-blue-100 to-purple-200 font-sans relative overflow-hidden">

        {{-- 🌧️ Hiệu ứng mưa ánh sáng --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div id="lightRain" class="absolute inset-0 opacity-30"></div>
        </div>

        {{-- 📦 Khung chính --}}
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-8 w-full max-w-md z-10 relative animate-fadeInUp">
            <h2 class="text-2xl font-extrabold text-center text-gray-800 mb-2">🔐 Xác minh mã OTP</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Nhập mã OTP được gửi đến email của bạn.</p>

            {{-- 🧾 Thông báo --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 text-sm rounded-lg px-4 py-2 mb-3 text-center">
                    {{ session('success') }}
                </div>
            @endif
            @error('otp')
                <div class="bg-red-100 border border-red-300 text-red-800 text-sm rounded-lg px-4 py-2 mb-3 text-center">
                    {{ $message }}
                </div>
            @enderror

            {{-- ✍️ Form nhập OTP --}}
            <form action="{{ route('forgot.verify') }}" method="POST">
                @csrf
                <input type="text" name="otp" maxlength="6"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-center text-lg font-semibold tracking-widest focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    placeholder="Nhập mã OTP 6 số" required>

                <div class="text-center mt-3 text-sm text-gray-600">
                    Mã có hiệu lực trong <span id="countdown" class="text-indigo-600 font-semibold">05:00</span>
                </div>

                <button type="submit"
                    class="w-full py-2 mt-5 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-xl shadow-lg hover:scale-105 active:scale-95 transition-all duration-300">
                    Xác nhận OTP
                </button>
            </form>
        </div>
    </div>

    {{-- 🔔 Toast hiển thị OTP ở góc trái màn hình --}}
    @if (session('otp_toast') || session('latest_otp'))
        <div id="otpToast"
            class="fixed bottom-6 left-6 bg-gradient-to-r from-green-500 to-emerald-400 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-medium opacity-0 translate-y-6 transition-all duration-500 z-50">
            📩 {{ session('otp_toast') ?? 'Mã OTP của bạn là: ' . session('latest_otp') . ' (hiệu lực 5 phút)' }}
        </div>
    @endif

    {{-- ⚙️ JS --}}
    <script>
        // 🌧️ Hiệu ứng nền
        const lightRain = document.getElementById('lightRain');
        function createLightParticle() {
            const p = document.createElement('div');
            p.className = 'absolute bg-gradient-to-t from-indigo-300 to-white rounded-full blur-[2px]';
            const size = Math.random() * 3 + 1;
            p.style.width = `${size}px`;
            p.style.height = `${size * 5}px`;
            p.style.left = `${Math.random() * 100}%`;
            p.style.top = '-10px';
            lightRain.appendChild(p);
            const duration = 3000 + Math.random() * 2000;
            p.animate([{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(110vh)', opacity: 0 }],
                { duration, easing: 'linear', fill: 'forwards' });
            setTimeout(() => p.remove(), duration);
        }
        setInterval(createLightParticle, 100);

        // 🕒 Countdown 5 phút
        const countdownEl = document.getElementById('countdown');
        let otpTime = 300;
        const otpTimer = setInterval(() => {
            let m = Math.floor(otpTime / 60),
                s = otpTime % 60;
            countdownEl.textContent = `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            if (otpTime-- <= 0) {
                clearInterval(otpTimer);
                countdownEl.textContent = "Hết hạn ⚠️";
            }
        }, 1000);

        // 💬 Hiệu ứng toast góc trái
        document.addEventListener("DOMContentLoaded", () => {
            const toast = document.getElementById("otpToast");
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove("opacity-0", "translate-y-6");
                }, 300);
                setTimeout(() => {
                    toast.classList.add("opacity-0", "translate-y-6");
                    setTimeout(() => toast.remove(), 600);
                }, 10000);
            }
        });
    </script>

    {{-- 💅 CSS --}}
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
