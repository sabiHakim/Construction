@extends('base.baseAdmin')
@section('title','acceuilAdmin')
@section('content')
    <style>
        .custom-form {
            margin-right: 10px; /* Ajustez cette valeur selon vos besoins */
        }

    </style>
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="MaisonDevis" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="card-title"> Maison</h5>
                                    <input class="form-control" type="file" name="file" >
                                    <h5 class="card-title">Import Devis</h5>
                                    <input class="form-control" type="file" name="filedevis"  >
                                    <button type="submit" class=" btn btn-outline-success mt-5 ">importer</button>
                                    @if(isset($error))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($error as $errors)<li>{{ $errors }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            @if(session('error'))
                                <div class="  mt-5 alert alert-danger">{{session('error')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Import Payement</h5>
                                <form method="post" action="payement"   enctype="multipart/form-data"  >
                                    @csrf
                                    <input class="form-control" type="file" name="file" >
                                    <button type="submit" class=" mt-5 btn btn-outline-success">importer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </section>
@endsection
