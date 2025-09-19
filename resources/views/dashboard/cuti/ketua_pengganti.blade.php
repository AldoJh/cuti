@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Atur Ketua Pengganti</h4>

    {{-- Alert pesan sukses / error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('cuti.setKetuaPengganti') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Pilih Ketua Pengganti</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ $user->is_ketua_pengganti ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
