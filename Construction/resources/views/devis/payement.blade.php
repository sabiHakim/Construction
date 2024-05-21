@extends('base.base')
@section('title','acceuil')
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-4" ></div>
            <div class="col-lg-4 ">
                <div class="card  p-3">
                    <div class=" card-body">
                        <form  class=" mt-5" method="get" action="traitpayement">
                            <div class="row mb-3">
                                <div class="row mb-3">
                                    <label class="col-sm-8 col-form-label">Choisir Devis</label>
                                    <select class="form-select" aria-label=""  name="devis">
                                        <option selected>Open this select menu</option>
                                        @foreach($allDevise as $f)
                                            <option value="{{$f->id}}"> {{number_format($f->prixtotal, 0, ',', ' ')}} Ar</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputName5"  class="form-label">Entrer votre Chiffre</label>
                                    <input type="number" name="payement" class="form-control" id="inputName5">
                                </div>
{{--                                @error('payement')--}}
{{--                                <div class="alert alert-danger"> {{  }} </div>--}}
{{--                                @enderror--}}
                            </div>
                            <div class="row mb-3">
                                <label class=" col-form-label"> Date</label>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="date" class="form-control" id="floatingInput" placeholder="date">
                                    </div>
                            </div>
{{--                            @error('date')--}}
{{--                            <div class="alert alert-danger"> {{  }} </div>--}}
{{--                            @enderror--}}
                            <div class="row mb-3">
                                    <button class="col-lg-12 btn btn-outline-primary">Payer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" ></div>

        </div>

    </section>
@endsection
