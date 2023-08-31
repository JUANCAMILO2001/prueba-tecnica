@extends('layouts.app')

@section('content')
<div class="container">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Usuarios</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-citys" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Ciudades</button>
            <button class="nav-link" id="nav-graphic-tab" data-bs-toggle="tab" data-bs-target="#nav-graphic" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Gráfica</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <user-component></user-component>
        </div>
        <div class="tab-pane fade" id="nav-citys" role="tabpanel" aria-labelledby="nav-profile-tab">
            <br>
            <ciudad-component></ciudad-component>
        </div>
        <div class="tab-pane fade" id="nav-graphic" role="tabpanel" aria-labelledby="nav-graphic-tab">
            <br>
            <chart-component></chart-component>
        </div>
    </div>
</div>
@endsection
