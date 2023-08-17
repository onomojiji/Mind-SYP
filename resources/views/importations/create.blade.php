@extends('layouts.master')
@section('title') Nouvelle importation @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Nouvelle importation @endslot
    @endcomponent

        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="{{route("importation.store")}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Importation du fichier excel</h4>
                        </div>
                        <div class="card-body">
                            @if(@session('success'))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif
                            @if(@session('fail'))
                                <div class="alert alert-success">
                                    {{session('fail')}}
                                </div>
                            @endif
                            <div>
                                <input class="form-control" type="file" id="file" accept=".csv, .xlsx" name="file" required>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-primary w-25">Importer</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

@endsection
