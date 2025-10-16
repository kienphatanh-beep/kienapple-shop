<x-layout-user>
    <div class="min-h-screen flex items-center justify-center bg-yellow-100 py-12">
        <div class="bg-white p-8 rounded-2xl shadow-xl text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                💳 Thanh toán đơn hàng #{{ $order->id }}
            </h1>
           <p class="text-gray-600 mb-6">
    Vui lòng quét mã QR bên dưới để thanh toán số tiền 
    <span class="font-bold text-orange-600">
        {{ number_format($amount, 0, ',', '.') }}đ
    </span>
</p>

<div class="flex justify-center">
    <img src="{{ $vietQrUrl }}" alt="QR Thanh toán" 
         class="w-64 h-64 shadow-lg rounded-lg border">
</div>


            <p class="mt-4 text-sm text-gray-500">Ngân hàng: Vietcombank</p>
            <p class="text-sm text-gray-500">Chủ tài khoản: TRAN TRUNG KIEN</p>
            <p class="text-sm text-gray-500">Nội dung: Thanh toan don hang #{{ $order->id }}</p>

            <a href="{{ route('home') }}" 
               class="mt-6 inline-block px-6 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                Về trang chủ
            </a>
        </div>
    </div>
</x-layout-user>
