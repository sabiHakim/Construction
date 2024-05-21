@extends('base_login.base_log')
@section('title','login')
{{--@section('title')--}}
{{--    Login--}}
{{--@endsection--}}
@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class="d-flex align-items-center w-auto">
                            <img  class="rounded"  src="{{asset('assets/img/images.png')}}" alt="" style="width: 150px; height: 150px">
{{--                            <span class="d-none d-lg-block">##</span>--}}
                        </a>
                    </div><!-- End Logo -->
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                <p class="text-center small">Enter your username & password to login</p>
                            </div>
                                @if(isset($admin))
                                    @foreach($admin as $a)
                                <form class="row g-3 needs-validation"  action="{{ route('traitLogin') }}" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="name" class="form-control" id="yourUsername" required value="{{ $a->nom }}">
                                            <div class="invalid-feedback">Please enter your username.</div>
                                        </div>
                                    </div>
                                    @error('name')
                                    <div class=" mt-2 alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="mdp" class="form-control" id="yourPassword"  value=" {{$a->mdp}}" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>
                                    @error('mdp')
                                    <div class=" mt-2 alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="col-12">
                                        {{--                                    <div class="form-check">--}}
                                        {{--                                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">--}}
                                        {{--                                        <label class="form-check-label" for="rememberMe">Remember me</label>--}}
                                        {{--                                    </div>--}}
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                    {{--                                <div class="col-12">--}}
                                    {{--                                    <p class="small mb-0">Don't have account? <a href="{{'register'}}">Create an account</a></p>--}}
                                    {{--                                </div>--}}
                                    @if(session('diso'))
                                        <div class=" text-center mt-2 alert alert-danger">{{ session('diso') }}</div>
                                    @endif
                                    @if(session('status'))
                                        <div class="  text-center mt-2 alert alert-warning">{{ session('status') }}</div>
                                    @endif
                                    @if(session('statuss'))
                                        <div class="  text-center mt-2 alert alert-danger">{{ session('statuss') }}</div>
                                    @endif
                                </form>
                                    @endforeach
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
