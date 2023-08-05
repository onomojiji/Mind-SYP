@extends("layouts.master")

@section('title') Liste des utilisateurs @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Liste des utilisateurs @endslot
    @endcomponent
@endsection
