@extends('layouts.app')

@section('title', 'Form Banner')

@section('contents')
  <form action="{{ isset($banner) ? route('banner.tambah.update', $banner->id) : route('banner.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($banner) ? 'Form Edit Banner' : 'Form Tambah Banner' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($banner) ? $banner->name : '' }}">
            </div>
            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ isset($banner) ? $banner->subtitle : '' }}">
              </div>
              <div class="form-group">
                <label for="color">Warna</label>
                <input type="text" class="form-control" id="color" name="color" value="{{ isset($banner) ? $banner->color : '' }}">
              </div>
              <div class="form-group">
                <label for="plant_id">Kategori Tanaman</label>
                              <select name="plant_id" id="plant_id" class="custom-select">
                                  <option value="" selected disabled hidden>-- Pilih Kategori --</option>
                                  @foreach ($plants as $row)
                                      <option value="{{ $row->id }}" {{ isset($banner) ? ($banner->plant_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
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
