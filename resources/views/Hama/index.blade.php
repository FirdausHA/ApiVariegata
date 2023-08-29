@extends('layouts.app')

@section('title', 'Data Hama')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Hama</h6>
    </div>
    <div class="card-body">
			@if (auth()->user()->level == 'Admin')
      <a href="{{ route('hama.tambah') }}" class="btn btn-primary mb-3">Tambah Hama</a>
			@endif
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Tipe</th>
              <th>Deskripsi</th>
              <th>Cegah</th>
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
                <td>{{ $row->tipe }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->cegah }}</td>
                <td>{{ $row->plant->name }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="hama Image" heigth="100" width="100">
                </td>
								@if (auth()->user()->level == 'Admin')
                <td>
                  <a href="{{ route('hama.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('hama.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
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
