@extends('base_login.base_log')
@section('title','index')
{{--@section('title')--}}
{{--    Login--}}
{{--@endsection--}}
@section('content')
    <section class="section register min-vh-100  flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="  col-lg-4 mt-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="d-flex align-items-center w-auto">
                                    <img  class="rounded"  src="{{asset('assets/img/images.png')}}" alt="" style="width: 150px; height: 150px">
                                    {{--                            <span class="d-none d-lg-block">##</span>--}}
                                </a>
                            </div><!-- End Logo -->
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">Connexion</h5>
                                <p class="text-center small">Choisir</p>
                            </div>
                                <div class="row">
                                        <a href="admin"><button class=" col-lg-12 btn btn-outline-primary"> Admin </button></a>
                                        <a href="client"><button class=" mt-4 col-lg-12 btn btn-primary"> Client </button></a>
                                </div>
{{--                            <div class="row mt-3 ">--}}
{{--                                <div class="col-lg-4"></div>--}}
{{--                                <div class="col-4" style="display: none">--}}
{{--                                       <a href="reinitialiser">  <button  class="btn btn-outline-danger" type="submit"> reset </button> </a>--}}
{{--                                </div>--}}
{{--                                <div class="col-lg-4"></div>--}}
{{--                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
