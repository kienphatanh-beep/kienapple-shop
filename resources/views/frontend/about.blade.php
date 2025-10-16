@extends('components.layout-user')

@section('title', 'Giới thiệu về chúng tôi')

@section('content')
<div class="bg-yellow-50 min-h-screen py-12">
    <div class="container mx-auto px-6 md:px-12 lg:px-20">
        <!-- Tiêu đề -->
        <div class="text-center mb-12" data-aos="fade-down">
            <h1 class="text-4xl font-bold text-yellow-900 mb-4">Giới thiệu về chúng tôi</h1>
            <p class="text-lg text-yellow-700 max-w-2xl mx-auto">
                Chúng tôi là Kiên Apple Store – nơi mang đến cho bạn những sản phẩm công nghệ chất lượng nhất với dịch vụ tận tâm và chuyên nghiệp.
            </p>
        </div>

        <!-- Hình ảnh + Giới thiệu -->
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475"
                     alt="Team"
                     class="rounded-2xl shadow-xl hover:scale-105 transition-transform duration-500">
            </div>
            <div data-aos="fade-left">
                <h2 class="text-2xl font-semibold text-yellow-900 mb-4">Sứ mệnh của chúng tôi</h2>
                <p class="text-yellow-800 leading-relaxed mb-4">
                    Với mong muốn mang lại trải nghiệm tốt nhất cho khách hàng, chúng tôi không ngừng cải tiến chất lượng sản phẩm và dịch vụ.
                </p>
                <p class="text-yellow-800 leading-relaxed">
                    Đội ngũ nhân viên trẻ trung, sáng tạo và đầy nhiệt huyết sẽ luôn đồng hành cùng bạn trong suốt hành trình mua sắm.
                </p>
            </div>
        </div>

        <!-- Giá trị cốt lõi -->
        <div class="mt-16" data-aos="zoom-in-up">
            <h2 class="text-2xl font-bold text-yellow-900 text-center mb-10">Giá trị cốt lõi</h2>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf"
                         alt="Uy tín"
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover">
                    <h3 class="font-semibold text-lg text-yellow-900">Uy tín</h3>
                    <p class="text-yellow-700 mt-2">Chúng tôi đặt uy tín lên hàng đầu, luôn giữ chữ tín với khách hàng.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f"
                         alt="Chất lượng"
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover">
                    <h3 class="font-semibold text-lg text-yellow-900">Chất lượng</h3>
                    <p class="text-yellow-700 mt-2">Mỗi sản phẩm đều được kiểm định kỹ càng trước khi đến tay bạn.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d"
                         alt="Đổi mới"
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover">
                    <h3 class="font-semibold text-lg text-yellow-900">Đổi mới</h3>
                    <p class="text-yellow-700 mt-2">Không ngừng sáng tạo để mang đến trải nghiệm hiện đại, tiện lợi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Thư viện AOS cho animation -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1000, // thời gian hiệu ứng (ms)
    once: true      // chỉ chạy 1 lần khi scroll
  });
</script>
@endpush
