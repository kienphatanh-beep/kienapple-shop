<x-layout-user>
    <x-slot:title>Quên mật khẩu</x-slot:title>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-200 font-sans relative overflow-hidden">
        {{-- 🌧️ Hiệu ứng mưa ánh sáng --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div id="lightRain" class="absolute inset-0 opacity-30"></div>
        </div>

        {{-- 📦 Form chính --}}
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-8 w-full max-w-md z-10 relative animate-fadeInUp">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2">🧩 Quên mật khẩu</h2>
            <p class="text-center text-gray-500 text-sm mb-6">
                Nhập email của bạn để nhận mã OTP khôi phục.
            </p>

            {{-- 📨 Form nhập email --}}
            <form id="otpForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">📧 Email đã đăng ký</label>
                    <input type="email" id="emailInput" name="email" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                        placeholder="vd: example@gmail.com">
                </div>

                <button type="submit" id="sendOtpBtn"
                    class="flex items-center justify-center gap-2 w-full py-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-500 text-white font-semibold rounded-xl shadow-lg hover:scale-105 active:scale-95 transition-all duration-300">
                    <span id="btnText">Gửi mã OTP</span>
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </form>

            <p class="text-center text-gray-500 text-xs mt-4">
                Sau khi gửi, bạn sẽ được chuyển đến trang nhập mã OTP.
            </p>
        </div>
    </div>

    {{-- ⚙️ Hiệu ứng nền --}}
    <script>
        // 🌧️ Mưa ánh sáng
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

        // 🚀 Gửi OTP bằng AJAX
        const otpForm = document.getElementById('otpForm');
        const sendBtn = document.getElementById('sendOtpBtn');
        const btnText = document.getElementById('btnText');
        const loadingIcon = document.getElementById('loadingIcon');

        otpForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('emailInput').value.trim();

            // UI Loading
            sendBtn.disabled = true;
            btnText.textContent = "Đang gửi...";
            loadingIcon.classList.remove('hidden');

            try {
                const res = await fetch("{{ route('forgot.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ email })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    showToast("✅ " + data.message, "success");
                    setTimeout(() => {
                        window.location.href = "{{ route('forgot.verifyForm') }}";
                    }, 1500);
                } else {
                    showToast(data.message || "❌ Tài khoản không tồn tại.", "error");
                }
            } catch (error) {
                showToast("⚠️ Lỗi kết nối máy chủ!", "error");
            } finally {
                sendBtn.disabled = false;
                btnText.textContent = "Gửi mã OTP";
                loadingIcon.classList.add('hidden');
            }
        });

        // 💬 Hiển thị thông báo Toast (trên cùng, gọn nhẹ)
        function showToast(msg, type = "success") {
            const toast = document.createElement("div");
            toast.textContent = msg;
            toast.className = `fixed top-6 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-2xl shadow-lg text-white font-medium text-center z-50 transition-all duration-500 opacity-0 ${
                type === "error"
                    ? "bg-gradient-to-r from-red-500 to-rose-500"
                    : "bg-gradient-to-r from-green-500 to-emerald-400"
            }`;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove("opacity-0"), 100);
            setTimeout(() => {
                toast.classList.add("opacity-0");
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
    </script>

    {{-- 💅 CSS --}}
    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease forwards; }
    </style>
</x-layout-user>
