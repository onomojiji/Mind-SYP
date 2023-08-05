@extends("layouts.master")

@section('title') Nouvel utilisateur @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Nouvel utilisateur @endslot
    @endcomponent
@endsection
