@extends('layouts.app')

@section('title', 'Data Tahapan')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Tahapan</h6>
    </div>
    <div class="card-body">
      <a href="{{ route('stages.tambah') }}" class="btn btn-primary mb-3">Tambah Tahapan</a>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Gambar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($data as $row)
              <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $row->name }}</td>
                <td>{{ $row->banner->name }}</td>
                <td>
                    <img src="{{ asset('storage/' . $row->image) }}" alt="stage Image" heigth="100" width="100">
                </td>
                <td>
                  {{-- <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">Edit</a> --}}
                  <form method="POST" action="{{ route('stages.destroy', $category->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus kategori ini?')">Delete</button>
                </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
