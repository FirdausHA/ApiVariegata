@extends('layouts.app')

@section('title', 'Data Banner')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Informasi</h6>
    </div>
    <div class="card-body">
			@if (auth()->user()->level == 'Admin')
      <a href="{{ route('banner.tambah') }}" class="btn btn-primary mb-3">Tambah Informasi</a>
			@endif
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Subtitle</th>
              <th>Warna</th>
              <th>Kategori</th>
              <th>Gambar</th>
							@if (auth()->user()->level == 'Admin')
              <th>Action</th>
							@endif
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($data as $row)
              <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $row->name }}</td>
                <td>{{ $row->Subtitle }}</td>
                <td>{{ $row->color }}</td>
                <td>{{ $row->plant->name }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="banner Image" heigth="100" width="100">
                </td>
								@if (auth()->user()->level == 'Admin')
                <td>
                  <a href="{{ route('banner.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('banner.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
                </td>
								@endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
