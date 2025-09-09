<nav class="bg-[#a10817] text-white flex justify-between items-center px-6 py-3 shadow">
    <!-- Hamburger Mobile (kiri) -->
    <div class="flex items-center">
        <button id="hamburger" class="lg:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <span class="ml-2 font-semibold text-lg lg:hidden">Menu</span>
    </div>

    <!-- Logout (kanan) -->
    <div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm sm:text-base transition duration-200 flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</nav>
