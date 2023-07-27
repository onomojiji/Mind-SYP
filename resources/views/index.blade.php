@extends('layouts.master')
@section('title') Accueil @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') DSI @endslot
@slot('title') Tableau de bord @endslot
@endcomponent

<div class="row">
    <div class="col">

        <div class="h-100">


        </div>

    </div> <!-- end col -->
</div>

@endsection
