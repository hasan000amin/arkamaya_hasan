@extends('layouts.guest', ['title' => 'Register | PT. Arkamaya'])

@section('content')
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" id="register-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" value="{{ old('name') }}"
                                        class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Full Name">
                                    @error('name')
                                        <small class="text-danger form-text">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="email" value="{{ old('email') }}" name="email" id="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        id="exampleInputEmail" placeholder="Email Address">
                                    @error('email')
                                        <small class="text-danger form-text">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" placeholder="Password">
                                        @error('password')
                                            <small class="text-danger form-text">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-user" id="exampleRepeatPassword"
                                            placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    Register
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ url('/') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('.btn').on('click', function(e) {
                $(this).html('Processing..')
            })
        })
    </script>
@endpush
