@extends('base_login.base_log')
@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="card mb-3">
                        <div class="card-body">
                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class=" d-flex align-items-center w-auto">
                            <img  class="rounded"  src="{{asset('assets/img/images.png')}}" alt="" style="width: 150px; height: 150px">
                        </a>
                    </div><!-- End Logo -->
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Create an Account or Log In</h5>
                                <p class="text-center small">Enter your Tel</p>
                            </div>
                            <form class="row g-3 needs-validation" action="{{route('traitInscri')}}" method="post" >
                                @csrf
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Phone Number</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">Tel</span>
                                        <input type="tel" name="name" class="form-control" id="yourUsername" required>
                                        <div class="invalid-feedback">Please choose a username.</div>
                                    </div>
                                </div>
                                @error('name')
                                <div class=" mt-2 alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
