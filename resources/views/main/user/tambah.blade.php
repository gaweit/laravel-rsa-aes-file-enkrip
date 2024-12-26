@extends('layouts.layout_main')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> {{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.simpan') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Jabatan </label>
                                    <select name="user_jab_id" class="form-control" required>
                                        <option value="">pilih</option>
                                        @foreach ($jabatan as $jab)
                                            <option value="{{ $jab->jab_id }}">{{ $jab->jab_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama </label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama " required>
                                </div>
                                <div class="form-group">
                                    <label>Username </label>
                                    <input type="text" name="username" class="form-control" placeholder="username "
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="email" name="email" class="form-control" placeholder="email " required>
                                </div>
                                <div class="form-group">
                                    <label>Password </label>
                                    <input type="password" name="password" class="form-control" placeholder="password "
                                        required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ url('main/user') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
