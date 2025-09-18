@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-sm p-4" 
         style="max-width: 600px; width: 100%; border-radius: 16px; background: #fff;">
        
        <!-- Header -->
        <div class="mb-4 border-bottom pb-3">
            <h5 class="fw-bold text-dark mb-1">Edit Sisa Cuti</h5>
            <small class="text-muted">Formulir ini digunakan untuk memperbarui data cuti karyawan</small>
        </div>

        <!-- Form -->
        <form action="{{ route('updateCuti', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Cuti Tahunan -->
            <div class="mb-3">
                <label for="sisa_cuti_tahunan" class="form-label fw-semibold">Sisa Cuti Tahunan</label>
                <input type="number" 
                       name="sisa_cuti_tahunan" 
                       id="sisa_cuti_tahunan"
                       class="form-control custom-input"
                       value="{{ old('sisa_cuti_tahunan', $user->sisa_cuti_tahunan) }}" 
                       placeholder="Masukkan jumlah hari">
            </div>

            <!-- Cuti Sakit -->
            <div class="mb-4">
                <label for="sisa_cuti_sakit" class="form-label fw-semibold">Sisa Cuti Sakit</label>
                <input type="number" 
                       name="sisa_cuti_sakit" 
                       id="sisa_cuti_sakit"
                       class="form-control custom-input"
                       value="{{ old('sisa_cuti_sakit', $user->sisa_cuti_sakit) }}" 
                       placeholder="Masukkan jumlah hari">
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ url()->previous() }}" 
                   class="btn-custom btn-secondary-custom">
                    Batal
                </a>
                <button type="submit" 
                        class="btn-custom btn-danger-custom">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .custom-input {
        border-radius: 10px;
        border: 1px solid #dcdcdc;
        padding: 10px 14px;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .custom-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
    }

    /* Style tombol */
    .btn-custom {
        display: inline-block;
        font-weight: 500;
        padding: 10px 28px;
        font-size: 14px;
        border-radius: 50px; /* bikin bulat */
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        text-decoration: none;
        transition: all 0.25s ease-in-out;
    }

    .btn-secondary-custom {
        background-color: #f1f1f1;
        color: #444;
        border: 1px solid #bbb;
    }
    .btn-secondary-custom:hover {
        background-color: #e0e0e0;
        border-color: #999;
    }

    .btn-danger-custom {
        background-color: #e53935;
        color: #fff;
        border: none;
    }
    .btn-danger-custom:hover {
        background-color: #c62828;
    }
</style>
@endsection
