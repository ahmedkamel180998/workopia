<?php

use Framework\Session;
?>
<!-- Nav -->
<header class="bg-blue-900 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
            <a href="/">Workopia</a>
        </h1>
        <nav class="space-x-4">
            <?php if (Session::get('user')): ?>
                <div class="flex items-center gap-4">
                    <a
                        href="/listings/create"
                        class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-lg hover:shadow-md transition duration-300">
                        <i class="fa fa-edit mr-1"></i> Post a Job
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            @click.outside="open = false"
                            class="flex items-center gap-2 bg-blue-800 hover:bg-blue-700 px-3 py-2 rounded-full transition duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <i class="fa fa-user-circle text-yellow-400 text-lg"></i>
                            <span class="text-sm font-medium"><?php echo htmlspecialchars(Session::get('user')['name']); ?></span>
                            <i class="fa fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1 z-50"
                            style="display: none;">
                            <a href="/listings/create" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <i class="fa fa-briefcase w-4 text-center text-gray-400"></i> My Listings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="/auth/logout" method="POST">
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="fa fa-sign-out w-4 text-center"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="/auth/login" class="text-white hover:underline">Login</a>
                <a href="/auth/register" class="text-white hover:underline">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>