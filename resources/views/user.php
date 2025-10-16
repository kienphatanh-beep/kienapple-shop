@extends('components.layout-user')

@section('title', 'Cài đặt tài khoản')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 mt-8 rounded-2xl shadow-lg border border-yellow-200">
    <h1 class="text-2xl font-bold text-yellow-700 mb-6 flex items-center gap-2">
        ⚙️ <span>Cài đặt tài khoản</span>
    </h1>

    {{-- 🪄 Thông báo --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Sidebar --}}
        <div class="flex flex-col space-y-3">
            <a href="#profile" class="px-4 py-2 rounded-lg bg-yellow-100 font-semibold text-yellow-700 hover:bg-yellow-200 transition">
                👤 Thông tin cá nhân
            </a>
            <a href="#password" class="px-4 py-2 rounded-lg bg-yellow-50 text-yellow-700 hover:bg-yellow-100 transition">
                🔒 Đổi mật khẩu
            </a>
        </div>

        {{-- Nội dung chính --}}
        <div class="md:col-span-2 space-y-8">
            {{-- 👤 Thông tin cá nhân --}}
            <section id="profile" class="space-y-5">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-2">👤 Thông tin cá nhân</h2>
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="flex items-center gap-5">
                        <img src="{{ asset($user->avatar ?? 'assets/images/user/default-avatar.png') }}"
                             class="w-24 h-24 rounded-full object-cover border-2 border-yellow-400" alt="Avatar">
                        <div>
                            <label class="font-semibold text-gray-700">Ảnh đại diện</label>
                            <input type="file" name="avatar"
                                   class="mt-1 text-sm block w-full text-gray-600 border rounded-lg file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-yellow-100 file:text-yellow-800 hover:file:bg-yellow-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold text-gray-700">Họ và tên</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                        </div>
                        <div>
                            <label class="font-semibold text-gray-700">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                   class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                            💾 Lưu thay đổi
                        </button>
                    </div>
                </form>
            </section>

            {{-- 🔒 Đổi mật khẩu --}}
            <section id="password" class="space-y-5">
                <h2 class="text-xl font-bold text-gray-800 border-b pb-2">🔒 Đổi mật khẩu</h2>
                <form action="{{ route('settings.password') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="font-semibold text-gray-700">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password"
                               class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Mật khẩu mới</label>
                        <input type="password" name="password"
                               class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                    </div>
                    <div>
                        <label class="font-semibold text-gray-700">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                            ✅ Đổi mật khẩu
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
