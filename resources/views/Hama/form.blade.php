@extends('layouts.app')

@section('title', 'Form Hama')

@section('contents')
  <form action="{{ isset($hama) ? route('hama.tambah.update', $hama->id) : route('hama.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($hama) ? 'Form Edit Hama' : 'Form Tambah Hama' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($hama) ? $hama->name : '' }}">
            </div>
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" class="form-control" id="tipe" name="tipe" value="{{ isset($hama) ? $hama->tipe : '' }}">
              </div>
              <div class="form-group">
                <label for="description">Deskripsi</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ isset($hama) ? $hama->description : '' }}">
              </div>
              <div class="form-group">
                <label for="cegah">cegah</label>
                <input type="text" class="form-control" id="cegah" name="cegah" value="{{ isset($hama) ? $hama->cegah : '' }}">
              </div>
              <div class="form-group">
                <label for="plant_id">Kategori Tanaman</label>
                              <select name="plant_id" id="plant_id" class="custom-select">
                                  <option value="" selected disabled hidden>-- Pilih Kategori --</option>
                                  @foreach ($plants as $row)
                                      <option value="{{ $row->id }}" {{ isset($hama) ? ($hama->plant_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
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
