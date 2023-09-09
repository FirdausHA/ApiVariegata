@extends('layouts.app')

@section('title', 'Data Barang')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
    </div>
    <div class="card-body">
			{{-- @if (auth()->user()->level == 'Admin') --}}
      <a href="{{ route('product.tambah') }}" class="btn btn-primary mb-3">Tambah Barang</a>
			{{-- @endif --}}
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center w-25">Nama Barang</th>
              <th class="text-center w-50 ">Deskripsi</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Gambar</th>
							{{-- @if (auth()->user()->level == 'Admin') --}}
              {{-- <th class="text-center">Action</th> --}}
							{{-- @endif --}}
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($data as $row)
              <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $row->name }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->category->name }}</td>
                <td>{{ $row->price }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="Product Image" heigth="100" width="100">
                </td>
								{{-- @if (auth()->user()->level == 'Admin') --}}
                {{-- <td>
                  <a href="{{ route('product.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('product.hapus', $row->id) }}" class="btn btn-danger">Hapus</a>
                </td> --}}
								{{-- @endif --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
