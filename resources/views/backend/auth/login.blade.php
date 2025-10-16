<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animated Gradient Background */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(-45deg, #1e3a8a, #9333ea, #14b8a6, #f59e0b);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Login box */
        .login-form {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.2s ease-out;
            position: relative;
            z-index: 10;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Typing animation for welcome text */
        .typing-text {
            font-size: 1.2rem;
            white-space: nowrap;
            overflow: hidden;
            border-right: 2px solid black;
            animation: typing 3.5s steps(40, end), blink 0.75s step-end infinite;
            margin-bottom: 1.5rem;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink {
            from, to { border-color: transparent }
            50% { border-color: black }
        }

        /* Robot assistant */
        .robot {
            position: absolute;
            width: 100px;
            height: 100px;
            top: -50px;
            right: -60px;
            animation: floatIn 2s ease-in-out forwards, hoverBot 4s ease-in-out infinite;
        }

        @keyframes floatIn {
            0% {
                opacity: 0;
                transform: translateY(-100px) rotate(-45deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) rotate(0deg);
            }
        }

        @keyframes hoverBot {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .input-field:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.4);
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.8rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <div class="login-form relative">
        {{-- Robot AI Assistant --}}
        <img src="https://cdn-icons-png.flaticon.com/512/4712/4712107.png" alt="robot" class="robot">

        {{-- Welcome typing text --}}
        <div class="typing-text text-center font-semibold text-gray-800">
            Chào mừng đến với trang quản trị.
        </div>

        <h2 class="text-center text-2xl font-bold mb-4 text-gray-700">Admin Login</h2>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <input type="text" name="username" class="input-field mb-4 p-2 w-full rounded border" placeholder="Username" required>
            <input type="password" name="password" class="input-field mb-4 p-2 w-full rounded border" placeholder="Password" required>

            <div class="flex items-center mb-4">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-sm">Remember Me</label>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>

</body>
</html>
