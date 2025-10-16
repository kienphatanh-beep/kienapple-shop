<x-layout-user>
    <x-slot:title>Đặt lại mật khẩu</x-slot:title>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-200 font-sans">
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-8 w-full max-w-md animate-fadeInUp">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">🔑 Đặt lại mật khẩu</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
            @endif
            @error('password')
                <div class="bg-red-100 text-red-700 p-2 rounded mb-3">{{ $message }}</div>
            @enderror

            <form action="{{ route('password.reset') }}" method="POST">
                @csrf

                <label class="block mb-2 text-sm font-semibold">Mật khẩu mới</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 px-4 py-2 rounded mb-3 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition">

                <label class="block mb-2 text-sm font-semibold">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 px-4 py-2 rounded mb-4 focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition">

                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-lime-500 text-white font-semibold py-2 rounded-xl shadow-lg hover:scale-105 active:scale-95 transition-all duration-300">
                    Cập nhật mật khẩu
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease forwards; }
    </style>
</x-layout-user>
