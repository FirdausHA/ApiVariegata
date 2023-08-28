@extends('layouts.app')

@section('title', 'Data Content')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Content</h6>
    </div>
    <div class="card-body">
			@if (auth()->user()->level == 'Admin')
      <a href="{{ route('content.tambah') }}" class="btn btn-primary mb-3">Tambah Content</a>
			@endif
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Mingguan</th>
              <th>title</th>
              <th>Deskripsi</th>
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
                <td>{{ $row->week }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->stage->name }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="content Image" heigth="100" width="100">
                </td>
								@if (auth()->user()->level == 'Admin')
                <td>
                  <a href="{{ route('content.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('content.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
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
