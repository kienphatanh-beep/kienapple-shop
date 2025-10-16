<x-admin-site>
    <x-slot:title>Chi Tiết Liên Hệ</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">📨 Thông Tin Liên Hệ</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">👤 Họ tên:</label>
                    <p class="text-lg font-medium text-gray-800 dark:text-white">{{ $contact->name }}</p>
                </div>

                <div>
                    <label class="block text-gray-600 dark:text-gray-300">📧 Email:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $contact->email }}</p>
                </div>

                <div>
                    <label class="block text-gray-600 dark:text-gray-300">📱 Số điện thoại:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $contact->phone }}</p>
                </div>

                <div>
                    <label class="block text-gray-600 dark:text-gray-300">📝 Tiêu đề:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $contact->title }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-600 dark:text-gray-300">📄 Nội dung:</label>
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md text-gray-800 dark:text-gray-200 shadow-inner">
                        {{ $contact->content }}
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-600 dark:text-gray-300">📤 Phản hồi:</label>
                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md text-gray-800 dark:text-gray-200 shadow-inner">
                        {{ $contact->reply_content ?? 'Chưa có phản hồi' }}
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('contact.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition shadow">
                    ⬅ Quay lại
                </a>
            </div>
        </div>
    </div>
</x-admin-site>
