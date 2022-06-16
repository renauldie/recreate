@extends('layouts.alternative')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="center w-50 card border-0 shadow-lg my-5">
            <div class="card-body">
                <a href="{{ route('home') }}" class="link-secondary text-gray-700">
                    <i class="fas fa-arrow-left text-gray-700"></i> Kembali
                </a>
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome to PT Madu Baru</h1>
                    </div>
                    <form class="user" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user"
                                   id="exampleInputEmail" aria-describedby="emailHelp"
                                   placeholder="Enter Email Address..." name="email" value="{{ old('email') }}" required
                                   autocomplete="email" autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user"
                                   id="exampleInputPassword" placeholder="Password" name="password" required
                                   autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember
                                    Me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
