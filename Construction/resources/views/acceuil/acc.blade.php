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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ajouter Devis</h5>
                            <a href="addDevis"> <button class="btn btn-outline-primary">Add</button> </a>
                        </div>
                    </div>
                </div>
            <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Faire payement</h5>
                            <a href="addpayement"> <button class="btn btn-outline-warning">Payement</button> </a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('user') !== null)
                            @if(isset($devisClient))
                            <h5 class="card-title">Liste de Devis au client {{ session('user')}}</h5>
                                            <!-- Table with stripped rows -->
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Date_Debut_Travaux</th>
                                                    <th scope="col">date_fin</th>
                                                    <th scope="col">maison</th>
                                                    <th scope="col">Descri</th>
                                                    <th scope="col">finition</th>
                                                    <th scope="col">prixtotal</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($devisClient as $dev)
                                                <tr>
                                                    <td>{{$dev->date_debut_travaux}}</td>
                                                    <td>{{$dev->date_fin}}</td>
                                                    <td>{{$dev->nom}}</td>
                                                    <td>{{$dev->description}}</td>
                                                    <td>{{$dev->finition}}</td>
                                                    <td>{{number_format($dev->prixtotal, 0, ',', ' ')}} Ar</td>
                                                    <td class=""><a href="Detail/{{$dev->id}}" class=" texte-center text-primary"> <i class="bi bi-eye">  </i>  </a>  </td>
                                                    <td> <a  href="exporter/{{$dev->id}}" class="text-danger"><i class="bi bi-file-pdf"></i></a> </td>
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
