<x-admin-site>
    <x-slot:title>Phản hồi liên hệ</x-slot:title>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Phản hồi cho: {{ $contact->name }} ({{ $contact->email }})</h2>

        <form action="{{ route('contact.sendReply', $contact->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nội dung phản hồi</label>
                <textarea name="reply_content" rows="6" class="w-full border border-gray-300 rounded p-2" required>{{ old('reply_content') }}</textarea>
                @error('reply_content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Gửi phản hồi</button>
            <a href="{{ route('contact.index') }}" class="ml-2 text-gray-600 hover:underline">Quay lại</a>
        </form>
    </div>
</x-admin-site>
