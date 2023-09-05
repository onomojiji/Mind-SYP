@extends("layouts.master")

@section('title') Liste des utilisateurs @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Liste des utilisateurs @endslot
    @endcomponent

    <div class="card">
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
            <table class="table table-hover table-responsive table-striped">
                <thead class="table-primary">
                    <th>#</th>
                    <th>Nom(s) et prénom(s)</th>
                    <th>Sexe</th>
                    <th>Structure</th>
                    <th>Adresse email</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @for($i=0; $i<count($users); $i++)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$users[$i]["nom"]." ".$users[$i]["prenom"]}}</td>
                            <td>{{$users[$i]["sexe"]}}</td>
                            <td>{{$users[$i]["structure"]}}</td>
                            <td>{{$users[$i]["email"]}}</td>
                            <td class="text-center">
                                @if($users[$i]["admin"] == 1)
                                    <p class="badge text-bg-primary">Admin</p>
                                @endif

                                @if($users[$i]["status"] == 1)
                                    <p class="badge text-bg-success">Actif</p>
                                @else
                                    <p class="badge text-bg-danger">Désactivé</p>
                                @endif
                            </td>

                            <td>
                                <div class="dropdown">
                                    <a href="#"
                                       class="btn btn-light btn-icon" id="dropdownMenuLink15"
                                       data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="ri-equalizer-fill"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="dropdownMenuLink15">
                                        <li>
                                            <a class="dropdown-item" href="{{route("users.edit", $users[$i]["id"])}}">
                                                <i class="ri-edit-box-fill me-2 align-middle text-muted"></i>
                                                Editer
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{route("users.update.admin", $users[$i]["id"])}}">
                                                @if($users[$i]["admin"] == 1)
                                                    <i class="ri-user-unfollow-fill text-danger me-2 align-middle"></i>
                                                    <span class="text-danger">Retirer admin</span>
                                                @else
                                                    <i class="ri-user-settings-fill text-primary me-2 align-middle"></i>
                                                    <span class="text-primary">Nomer admin</span>
                                                @endif

                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{route("users.update.status", $users[$i]["id"])}}">
                                                @if($users[$i]["status"] == 1)
                                                    <i class="ri-delete-bin-fill text-danger me-2 align-middle"></i>
                                                    <span class="text-danger">Désactiver</span>
                                                @else
                                                    <i class="ri-check-fill me-2 align-middle text-primary"></i>
                                                    <span class="text-primary">Activer</span>
                                                @endif

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>



@endsection
