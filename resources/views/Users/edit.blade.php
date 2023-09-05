@extends("layouts.master")

@section('title') Modifier le profil @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') {{$user->personnel->nom." ".$user->personnel->prenom}} @endslot
    @endcomponent



    <div class="card p-3">

        <form action="{{route("users.update", $user->id)}}" method="post">
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

                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#nav-border-justified-profile" role="tab" aria-selected="false">
                            <i class="ri-user-line me-1 align-middle"></i> Informations du profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#nav-border-justified-messages" role="tab" aria-selected="false">
                            <i class="ri-lock-password-line align-middle me-1"></i>Mot de passe
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="nav-border-justified-profile" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="nom">Nom</label>
                                <input id="nom" value="{{$user->personnel->nom}}" type="text" name="nom" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="prenom">Prénom</label>
                                <input id="prenom" value="{{$user->personnel->prenom}}" type="text" name="prenom" class="form-control" placeholder="Entrez le prénom de l'utilisateur">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 form-group">
                                <label for="sexe">Sexe</label>
                                <select id="sexe" class="form-select" name="sexe" required>
                                    <option @if($user->personnel->sexe == "Male") selected @endif value="Male">Masculin</option>
                                    <option @if($user->personnel->sexe == "Female") selected @endif value="Female">Feminin</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Adresse email</label>
                                <input id="email" value="{{$user->email}}" type="email" name="email" class="form-control" placeholder="Entrez l'adresse email' de l'utilisateur" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="structure_id">Structure</label>
                                <select id="structure_id" class="form-select" name="structure_id" required>
                                    @foreach($structures as $structure)
                                        <option @if($userStructure->id == $structure->id) selected @endif value="{{$structure->id}}">{{$structure->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="nav-border-justified-messages" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-md form-group">
                                <label for="oldpassword">Ancien mot de passe</label>
                                <input id="oldpassword" type="password" name="oldpassword" class="form-control" placeholder="Entrez l'ancien mot de passe de plus de 6 caractères">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md form-group">
                                <label for="password">Mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="Entrez un mot de passe de plus de 6 caractères">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="confirm">Confirmation du mot de passe</label>
                                <input id="confirm" type="password" name="confirm" class="form-control" placeholder="Confirmer le mot de passe">
                            </div>
                        </div>
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
