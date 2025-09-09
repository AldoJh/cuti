<nav class="bg-[#a10817] text-white flex justify-end items-center px-6 py-3 shadow">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm sm:text-base transition duration-200 flex items-center gap-2">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</nav>
