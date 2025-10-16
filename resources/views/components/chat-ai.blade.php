<div id="chatAI" class="fixed bottom-6 right-6 w-80 bg-yellow-50 border-2 border-yellow-400 rounded-2xl shadow-2xl overflow-hidden">
    <div class="bg-yellow-400 text-white font-bold p-3 flex items-center justify-between">
        <span>🤖 Trợ lý Kiên Apple</span>
        <button onclick="document.getElementById('chatAI').remove()" class="hover:text-gray-200">✖</button>
    </div>

    <div id="chatMessages" class="h-64 overflow-y-auto p-3 text-sm bg-white"></div>

    <form id="chatForm" class="flex border-t">
        <input id="chatInput" type="text" class="flex-1 px-3 py-2 text-sm outline-none" placeholder="Nhập câu hỏi...">
        <button class="bg-yellow-500 text-white px-4 py-2 hover:bg-yellow-600">Gửi</button>
    </form>
</div>

<script>
const chatBox = document.getElementById('chatMessages');
const form = document.getElementById('chatForm');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;

    chatBox.innerHTML += `<div class='text-right text-yellow-700 mb-2'><b>Bạn:</b> ${msg}</div>`;
    input.value = '';

    const res = await fetch("{{ route('chat.ai') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: msg })
    });

    const data = await res.json();
    chatBox.innerHTML += `<div class='text-left text-gray-700 mb-2'><b>AI:</b> ${data.reply}</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
