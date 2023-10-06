@extends('layouts.app')

@section('title', 'Form Informasi')

@section('contents')
  <form action="{{ isset($informasi) ? route('informasi.store.update', $informasi->id) : route('informasi.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($informasi) ? 'Form Edit Informasi' : 'Form Tambah Informasi' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Judul</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($informasi) ? $informasi->name : '' }}">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ isset($informasi) ? $informasi->description : '' }}">
              </div>
            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" class="form-control-file" id="image" name="image">
              </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
