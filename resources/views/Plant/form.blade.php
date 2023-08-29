@extends('layouts.app')

@section('title', 'Form Tanaman')

@section('contents')
  <form action="{{ isset($plant) ? route('plant.tambah.update', $plant->id) : route('plant.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($plant) ? 'Form Edit Tanaman' : 'Form Tambah Tanaman' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($plant) ? $plant->name : '' }}">
            </div>
            <div class="form-group">
                <label for="description">Nama Ilmiah</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ isset($plant) ? $plant->scientific : '' }}">
              </div>
            <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" class="form-control-file" id="image" name="image">
              </div>
              <div class="form-group">
                <label for="image_bg">Gambar</label>
                <input type="file" class="form-control-file" id="image_bg" name="image_bg">
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
