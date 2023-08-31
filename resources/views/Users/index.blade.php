@extends("layouts.master")

@section('title') Liste des utilisateurs @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') Liste des utilisateurs @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
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
                            @if($users[$i]["status"] == 1)
                                <td class="text-center">
                                    <p class="badge text-bg-success">Actif</p>
                                </td>
                            @else
                                <td class="text-center">
                                    <p class="badge text-bg-danger">Désactivé</p>
                                </td>
                            @endif
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
                                        <li><a class="dropdown-item"
                                               href="#"><i
                                                    class="ri-delete-bin-fill text-danger me-2 align-middle text-muted"></i>Désactiver</a>
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
