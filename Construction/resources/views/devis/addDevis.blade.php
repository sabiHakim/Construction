@extends('base.base')
@section('title','acceuil')
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
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="card  p-3">
                    <div class=" card-body">
                                <form  class=" mt-5" method="get" action="{{url('traitAddDevis')}}">
                                    @csrf
                                        <div class="">
                                            @foreach($allMaison as $all)
                                             <div class="row mb-3  d-inline-flex">
                                                    <div>
                                                        <label class="col-form-label"> {{$all->nom}} </label>
                                                    </div>
                                                 <div>
                                                     <input type="radio" name="maison" value="{{$all->id}}">
                                                 </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-5 col-form-label">Reference</label>
                                        <input type="text" class="form-control" name="reference" placeholder="reference">
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-5 col-form-label">lieu</label>
                                        <input type="text" class="form-control" name="lieu" placeholder="lieu">
                                    </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-5 col-form-label">Choisir Finition</label>
                                                <select class="form-select" aria-label=""  name="finition">
                                                    <option selected>Open this select menu</option>
                                                    @foreach($finition as $f)
                                                        <option value="{{$f->id}}"> {{ $f->nom }}  {{ $f->pourcentage }}%</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-5 col-form-label"> Date</label>
                                        <input type="date" name="date" class="form-control" id="floatingInput" placeholder="date">
                                    </div>
                                    <div class="row mb-3">
                                            <button type="submit" class="col-lg-12 btn btn-outline-primary">Ajouter</button>
                                    </div>
                                </form>
                    </div>
                </div>
            <div class="col-lg-4"></div>
            </div>
        </div>
    </section>
@endsection
