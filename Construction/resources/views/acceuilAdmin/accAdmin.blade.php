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
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Sales</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        @if(isset($sum))
                                            @foreach($sum as $s)
                                                <h6>{{number_format($s->sum, 0, ',', ' ')}} Ar</h6>
                                            @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
            @if(isset($dev))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Listes Devis En Cours</h5>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
{{--                                        <th scope="col">date_debut_travaux</th>--}}
{{--                                        <th scope="col">date_fin</th>--}}
                                        <th scope="col">nom</th>
                                        <th scope="col">description</th>
                                        <th SCOPE="COL"> dureconstruction</th>
                                        <th SCOPE="COL"> finition</th>
                                        <th SCOPE="COL"> prixtotal</th>
                                        <th SCOPE="COL"> Montant Paye</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dev as $d)
                                    <tr>
{{--                                        <th scope="row">{{$d->date_debut_travaux}}</th>--}}
{{--                                        <th scope="row">{{$d->date_fin}}</th>--}}
                                        <th scope="row">{{$d->nom_maison}}</th>
                                        <th scope="row">{{$d->description_maison}}</th>
                                        <th scope="row">{{$d->dureconstruction}} j</th>
                                        <th scope="row">{{$d->finition}}</th>
                                        <th scope="row">{{number_format($d->prixtotal, 0, ',', ' ')}} Ar</th>
                                        <th scope="row">{{number_format($d->montant_payement, 0, ',', ' ')}} Ar</th>
                                        <td>
                                            <a href="DetailDevisAdmin/{{$d->idmaison}}" class="mr-2"><i class="bi bi-eye me-2 " ></i></a>
{{--                                            <a href="#" onclick="return confirm('Voulez-vous vraiment supprimer cet élément ?');"><i class=" text-danger bi bi-trash me-2"></i></a>--}}
{{--                                            <a href="#"><i class=" text-success bi bi-pencil me-2"></i></a>--}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Histogrammes</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <form  action="histo" class="d-inline-flex">
                                        <input class="form-control" type="text" name="date" id="date">
                                        <button class="btn btn-outline-primary m-auto" >Valider</button>
                                    </form>
                                </div>
                            </div>
                            <canvas id="barChart" style="max-height: 400px;  " ></canvas>
                            @if(isset($formattedResults))
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const ctx = document.getElementById('barChart').getContext('2d');
                                        const labels = Object.keys({!! json_encode($formattedResults)!!}).map(label => label.replace(/\s+/g, '').toUpperCase());
                                        const data = Object.values({!! json_encode($formattedResults)!!});

                                        new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'Total par Mois',
                                                    data: data,
                                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                    borderColor: 'rgb(75, 192, 192)',
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
