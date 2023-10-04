@extends('layouts.app')

@section('title', 'Data Tanaman')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Tanaman</h6>
    </div>
    <div class="card-body">
			@if (auth()->user()->level == 'Admin')
      <a href="{{ route('plant.tambah') }}" class="btn btn-primary mb-3">Tambah Tanaman</a>
			@endif
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nama Ilmiah</th>
              <th>Image</th>
              <th>Image_Background</th>
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
                <td>{{ $row->scientific }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="informasi Image" heigth="100" width="100">
                </td>
                <td>
                    <img src="{{ asset('storage/' . $row->image_bg) }}" alt="informasi Image_bg" heigth="100" width="100">
                </td>
								@if (auth()->user()->level == 'Admin')
                <td>
                  <a href="{{ route('plant.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('plant.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
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
