<nav class="navbar navbar-expand-lg main-navbar">
    <a href="#" class="navbar-brand sidebar-gone-hide">Pengajuan Cuti</a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-danger btn-sm">Logout</button>
        </form>
      </li>
    </ul>
  </nav>
  