@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Sisa Cuti</h3>

    <form action="{{ route('updateCuti', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="sisa_cuti_tahunan" class="form-label">Sisa Cuti Tahunan</label>
            <input type="number" name="sisa_cuti_tahunan" class="form-control"
                value="{{ old('sisa_cuti_tahunan', $user->sisa_cuti_tahunan) }}">
        </div>

        <div class="mb-3">
            <label for="sisa_cuti_sakit" class="form-label">Sisa Cuti Sakit</label>
            <input type="number" name="sisa_cuti_sakit" class="form-control"
                value="{{ old('sisa_cuti_sakit', $user->sisa_cuti_sakit) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
