<nav class="bg-blue-500 text-white flex justify-between items-center px-4 sm:px-6 py-2 shadow">
    <!-- Brand -->
    <a href="{{ route('dashboard') }}" class="font-semibold text-lg sm:text-xl hover:text-blue-100 transition">
        Pengajuan Cuti
    </a>

    <!-- Logout -->
    <ul class="flex items-center space-x-2">
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="bg-red-400 hover:bg-red-500 text-white px-3 sm:px-4 py-1 sm:py-2 rounded-md text-sm sm:text-base transition duration-200">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</nav>
