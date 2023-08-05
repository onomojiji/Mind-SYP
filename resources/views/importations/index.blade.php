@extends('layouts.master')
@section('title') Liste des importation @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Liste des importation @endslot
    @endcomponent
@endsection
