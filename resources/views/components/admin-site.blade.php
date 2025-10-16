<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Trang Quản Trị' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{ $header ?? '' }}
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('assets/images/category/danh-muc-2.png') }}" class="h-8 me-3" alt="Logo" />
                    <span class="text-xl font-semibold dark:text-white">Admin</span>
                </a>
            </div>
            <div>
                <!-- User dropdown -->
                <div class="relative inline-block text-left">
                    <button id="dropdown-user" class="flex text-sm rounded-full bg-gray-800 focus:outline-none">
                        <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                    </button>
                    <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 origin-top-right bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg hidden">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">My Profile</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Settings</a></li>
                            <li>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                   class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <script>
                    const btn = document.getElementById('dropdown-user');
                    const menu = document.getElementById('dropdown-menu');
                    btn.addEventListener('click', () => menu.classList.toggle('hidden'));
                    window.addEventListener('click', (e) => {
                        if (!btn.contains(e.target) && !menu.contains(e.target)) {
                            menu.classList.add('hidden');
                        }
                    });
                </script>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="h-full px-3 pb-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li><a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard</a></li>
                <li><a href="{{ route('admin.product.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Products</a></li>
                <li><a href="{{ route('admin.category.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Categories</a></li>
                <li><a href="{{ route('admin.brand.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Brands</a></li>
                <li><a href="{{ route('admin.user.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Users</a></li>
                <li><a href="{{ route('admin.post.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Posts</a></li>
                <li><a href="{{ route('admin.contact.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Contacts</a></li>
                <li><a href="{{ route('admin.order.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Orders</a></li>
                <li><a href="{{ route('admin.topic.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Topics</a></li>
                <li><a href="{{ route('admin.menu.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Menus</a></li>
                <li><a href="{{ route('admin.banner.index') }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700">Sliders</a></li>
            </ul>
        </div>
    </aside>

    <!-- Nội dung chính -->
    <main class="ml-64 pt-20">
        {{ $slot }}
    </main>
</body>
</html>
