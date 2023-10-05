@extends('layouts.app')

@section('title', 'Form Barang')

@section('contents')
  <form action="{{ isset($barang) ? route('product.tambah.update', $barang->id) : route('product.tambah.simpan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($barang) ? 'Form Edit Barang' : 'Form Tambah Barang' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama Product</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ isset($barang) ? $barang->name : '' }}">
            </div>
            <div class="form-group">
                <label for="description">Deskripsi Produk</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ isset($product) ? $product->description : '' }}">
              </div>
            <div class="form-group">
              <label for="category_id">Kategori Barang</label>
							<select name="category_id" id="category_id" class="custom-select">
								<option value="" selected disabled hidden>-- Pilih Kategori --</option>
								@foreach ($categories as $row)
									<option value="{{ $row->id }}" {{ isset($barang) ? ($barang->category_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
								@endforeach
							</select>
            </div>
            <div class="form-group">
              <label for="price">Harga Product</label>
              <input type="number" class="form-control" id="price" name="price" value="{{ isset($barang) ? $barang->price : '' }}">
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk</label>
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
