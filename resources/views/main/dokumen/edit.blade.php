@extends('layouts.layout_main')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('dokumen.update', $result->id) }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama User</label>
                                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                                    <input type="text" name="user_id" id="user_id" class="form-control"
                                        placeholder="Nama User" value="{{ $result->user->name }}" readonly disabled>
                                </div>
                                <div class="form-group">
                                    <label>Algoritma</label>
                                    <select name="algoritme" id="algoritme" class="form-control">
                                        <option value="AES">AES</option>
                                        <option value="RSA">RSA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Dokumen</label>
                                    <input type="file" name="file" class="form-control" placeholder="Nama dokumen">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ url('main/dokumen') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
