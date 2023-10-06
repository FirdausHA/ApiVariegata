@extends('layouts.app')

@section('title', 'Form Content')

@section('contents')
  <form action="{{ isset($content) ? route('contents.store.update', $content->id) : route('contents.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($content) ? 'Form Edit Content' : 'Form Tambah Content' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($content) ? $content->name : '' }}">
            </div>
            <div class="form-group">
                <label for="week">Mingguan</label>
                <input type="text" class="form-control" id="week" name="week" value="{{ isset($content) ? $content->week : '' }}">
              </div>
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ isset($content) ? $content->title : '' }}">
              </div>
              <div class="form-group">
                <label for="description">Deskripsi</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ isset($content) ? $content->description : '' }}">
              </div>
              <div class="form-group">
                <label for="stage_id">Kategori Tahap</label>
                              <select name="stage_id" id="stage_id" class="custom-select">
                                  <option value="" selected disabled hidden>-- Pilih Kategori --</option>
                                  @foreach ($stages as $row)
                                      <option value="{{ $row->id }}" {{ isset($content) ? ($content->stage_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
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
