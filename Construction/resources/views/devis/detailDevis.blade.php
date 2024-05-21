@extends('base.base')
@section('title','acceuil')
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('user') !== null)
                            @if(isset($res))
                                <h5 class="card-title">Details Devis Client {{ session('user')}}</h5>
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">code_travaux</th>
                                        <th scope="col">nomtravaux</th>
                                        <th scope="col">qte</th>
                                        <th scope="col">pu</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($res as $dev)
                                        <tr>
                                            <td>{{$dev->code_travaux}}</td>
                                            <td>{{$dev->nomtravaux}}</td>
                                            <td>{{$dev->qte}}</td>
                                            <td>{{number_format($dev->pu, 0, ',', ' ')}} Ar</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
