@php
$rolesAtasan = ['panitera',  'sekretaris', 'ketua'];
$rolesAdmin = ['admin', 'superadmin'];
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">Cuti Online</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Menu</li>
        <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
        @if(!in_array(auth()->user()->role, $rolesAdmin))
        <li><a class="nav-link" href="{{ route('cuti.create') }}"><i class="fas fa-file-alt"></i> <span>Pengajuan Cuti</span></a></li>
        <li><a class="nav-link" href="{{ route('cuti.index') }}"><i class="fas fa-file-alt"></i> <span>lihat Pengajuan Cuti</span></a></li>
       @endif
    
    @if(in_array(auth()->user()->role, $rolesAtasan))
        <li><a class="nav-link" href="{{ route('cuti.pengajuan', auth()->id()) }}"><i class="fas fa-file-alt"></i> <span>Pengajuan Cuti Masuk</span></a></li>
    @endif
    @if(in_array(auth()->user()->role, $rolesAdmin))
        <li><a class="nav-link" href="{{ route('all_cuti') }}"><i class="fas fa-file-alt"></i> <span>Semua Sisa Cuti</span></a></li>
        <li><a class="nav-link" href="{{ route('create-user') }}"><i class="fas fa-file-alt"></i> <span>Buat Akun Pegawai</span></a></li>
        <li><a class="nav-link" href="{{ route('get-all-user') }}"><i class="fas fa-file-alt"></i> <span>Data User</span></a></li>
    @endif
      </ul>
    </aside>
  </div>
  