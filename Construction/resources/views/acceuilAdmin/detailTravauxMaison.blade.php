@extends('base.baseAdmin')
@section('title','acceuilAdmin')
@section('content')
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
            <!-- Left side columns -->
            <div class="col-lg-8">
            @if(isset($res))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Details</h5>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">code_travaux</th>
                                        <th scope="col">nomtravaux</th>
                                        <th SCOPE="COL"> qte</th>
                                        <th SCOPE="COL"> pu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($res as $d)
                                    <tr>
                                        <th scope="row">{{$d->code_travaux}}</th>
                                        <th scope="row">{{$d->nomtravaux}}</th>
                                        <th scope="row">{{$d->qte}}</th>
                                        <th scope="row">{{number_format($d->pu, 0, ',', ' ')}} Ar</th>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </section>
@endsection
