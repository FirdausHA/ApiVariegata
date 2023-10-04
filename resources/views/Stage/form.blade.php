@extends('layouts.app')

@section('title', 'Form tahap')

@section('contents')
  <form action="{{ isset($stage) ? route('stage.tambah.update', $stage->id) : route('stage.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($stage) ? 'Form Edit Tahap' : 'Form Tambah tahap' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Judul</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($stage) ? $stage->name : '' }}">
            </div>
            <div class="form-group">
                <label for="banner_id">Kategori Barang</label>
                              <select name="banner_id" id="banner_id" class="custom-select">
                                  <option value="" selected disabled hidden>-- Pilih Kategori --</option>
                                  @foreach ($banners as $row)
                                      <option value="{{ $row->id }}" {{ isset($stage) ? ($stage->banner_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
                                  @endforeach
                              </select>
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
