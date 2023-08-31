@extends("layouts.master")

@section('title') Nouvel utilisateur @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Nouvel utilisateur @endslot
    @endcomponent



    <div class="card p-3">

        <form action="{{route("users.store")}}" method="post">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger mb-2" role="alert">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                @if(@session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                @if(@session('fail'))
                    <div class="alert alert-danger">
                        {{session('fail')}}
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="nom">Nom</label>
                        <input id="nom" type="text" name="nom" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                    </div>
                    <div class="col form-group">
                        <label for="prenom">Prénom</label>
                        <input id="prenom" type="text" name="prenom" class="form-control" placeholder="Entrez le prénom de l'utilisateur">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 form-group">
                        <label for="sexe">Sexe</label>
                        <select id="sexe" class="form-select" name="sexe" required>
                            <option value="Male">Masculin</option>
                            <option value="Female">Feminin</option>
                        </select>
                    </div>
                    <div class="col-md-9 form-group">
                        <label for="email">Adresse email</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="Entrez l'adresse email' de l'utilisateur" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control" placeholder="Entrez un mot de passe de plus de 6 caractères" required>
                    </div>
                    <div class="col form-group">
                        <label for="confirm">Confirmation du mot de passe</label>
                        <input id="confirm" type="password" name="confirm" class="form-control" placeholder="Confirmer le mot de passe" required>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-primary w-25">Enregistrer</button>
                </div>
            </div>

        </form>

    </div>

@endsection
