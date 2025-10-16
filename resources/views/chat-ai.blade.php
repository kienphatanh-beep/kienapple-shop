<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>🤖 Chat AI - Kiên Apple</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-300 min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-3xl bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl p-6 relative overflow-hidden">
        <h1 class="text-3xl font-extrabold text-yellow-700 mb-6 text-center">🤖 Chat AI - Tư vấn sản phẩm</h1>

        <div id="chat-box" class="h-[420px] overflow-y-auto border rounded-2xl p-4 bg-yellow-50 shadow-inner"></div>

        <form id="chat-form" class="flex gap-3 mt-4">
            <input id="message" type="text" placeholder="Nhập câu hỏi của bạn..."
                   class="flex-1 p-3 rounded-xl border border-yellow-400 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 rounded-xl font-bold shadow">Gửi</button>
        </form>
    </div>

    <script>
    const chatForm = document.getElementById('chat-form');
    const chatBox = document.getElementById('chat-box');

    function appendMessage(content, sender = 'ai') {
        const div = document.createElement('div');
        div.className = sender === 'user'
            ? 'text-right mb-3 text-blue-600'
            : 'text-left mb-3 text-yellow-800';
        div.innerHTML = sender === 'user' ? `🧑‍💻 ${content}` : `🤖 ${content}`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    chatForm.addEventListener('submit', async e => {
        e.preventDefault();
        const msg = document.getElementById('message').value.trim();
        if (!msg) return;
        appendMessage(msg, 'user');
        document.getElementById('message').value = '';

        const loading = document.createElement('div');
        loading.innerHTML = "🤖 <span class='animate-pulse'>Đang soạn câu trả lời...</span>";
        chatBox.appendChild(loading);
        chatBox.scrollTop = chatBox.scrollHeight;

        const res = await fetch('{{ route('chat.ai') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg })
        });

        const data = await res.json();
        loading.remove();
        appendMessage(data.reply);
    });
    </script>

</body>
</html>
