@extends('layouts.master')
@section('title') {{$personnel->nom." ".$personnel->prenom}} @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Accueil @endslot
        @slot('title') {{$personnel->nom." ".$personnel->prenom}} @endslot
    @endcomponent

    @section('css')
        <link rel="stylesheet" href="{{ URL::asset('assets/libs/gridjs/gridjs.min.css') }}">
    @endsection

    <form method="get" action="{{route("personnel.dashboard", ["structure_id" => $structure->id, "personnel_id" => $personnel->id])}}">
        <div class="row mb-0 mb-md-3">

            <div class="col-md-2 my-2 text-center h5"><strong>Periode de :</strong></div>

            <div class="col-md-4">
                <select class="form-select mb-3" name="mois">
                    <option value="1" @if(\Illuminate\Support\Carbon::now()->month == 1) selected @endif>JANVIER</option>
                    <option value="2" @if(\Illuminate\Support\Carbon::now()->month == 2) selected @endif>FEVRIER</option>
                    <option value="3" @if(\Illuminate\Support\Carbon::now()->month == 3) selected @endif>MARS</option>
                    <option value="4" @if(\Illuminate\Support\Carbon::now()->month == 4) selected @endif>AVRIL</option>
                    <option value="5" @if(\Illuminate\Support\Carbon::now()->month == 5) selected @endif>MAI</option>
                    <option value="6" @if(\Illuminate\Support\Carbon::now()->month == 6) selected @endif>JUIN</option>
                    <option value="7" @if(\Illuminate\Support\Carbon::now()->month == 7) selected @endif>JUILLET</option>
                    <option value="8" @if(\Illuminate\Support\Carbon::now()->month == 8) selected @endif>AOÛT</option>
                    <option value="9" @if(\Illuminate\Support\Carbon::now()->month == 9) selected @endif>SEPTEMBRE</option>
                    <option value="10" @if(\Illuminate\Support\Carbon::now()->month == 10) selected @endif>OCTOBRE</option>
                    <option value="11" @if(\Illuminate\Support\Carbon::now()->month == 11) selected @endif>NOVEMBRE</option>
                    <option value="12" @if(\Illuminate\Support\Carbon::now()->month == 12) selected @endif>DECEMBRE</option>
                </select>
            </div>

            <div class="col-md-4">
                <select class="form-select mb-3" name="annee">
                    @for($j = \Illuminate\Support\Carbon::now()->year; $j >= 2018; $j--)
                        <option value="{{$j}}">{{$j}}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2 my-md-0 my-3">
                <button type="submit" class="btn btn-primary w-100">Valider</button>
            </div>

        </div>

    </form>

    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-md-3 row-cols-1">
                        <div class="col col-lg border-end">
                            <div class="py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Total pointages
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 text-primary"><span class="counter-value" data-target="{{count($nbPointages)}}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-md-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Pointages réussie</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 text-success"><span class="counter-value" data-target="{{count($pointagesSuccess)}}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-md-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Pointages Rejetés</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 text-danger"><span class="counter-value" data-target="{{count($pointagesFail)}}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-lg-0 py-4 px-2">
                                <h6 class="text-muted text-uppercase fs-13">Heures moyenne d'arrivée
                                </h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-0">
                                        <h3 class="mb-0 text-info"><span class="counter-value" data-target="{{$hme}}">0</span> h <span class="counter-value" data-target="{{$mme}}">0</span> min</h3>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg">
                            <div class="mt-3 mt-lg-0 py-4 px-2">
                                <h6 class="text-muted text-uppercase fs-13">Heure moyenne de départ
                                </h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-0">
                                        <h3 class="mb-0 text-info"><span class="counter-value" data-target="{{$hms}}">0</span> h <span class="counter-value" data-target="{{$mms}}">0</span> min</h3>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <div class="row">
        <div class="col">

            <div class="h-100">

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Heure moyenne d'arrivée au travail</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div>
                                    <canvas class="w-100" id="arriveChart"></canvas>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Heure moyenne de départ du travail</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div>
                                    <canvas id="departChart"></canvas>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Temps moyen mis au travail</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" class="chartjs-chart"></canvas>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Ration pointages réussis/rejetés</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div>
                                    <canvas id="ratioChart"></canvas>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>
                </div> <!-- end row -->

            </div>

        </div> <!-- end col -->
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Pointages réussis du personnel</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-striped-columns mb-0">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom(s) et prénom(s)</th>
                                <th scope="col">Sexe</th>
                                <th scope="col">Structure</th>
                                <th scope="col">Poste</th>
                                <th scope="col">Date de pointage</th>
                                <th scope="col">Heure d'entrée</th>
                                <th scope="col">Heure de sortie</th>
                                <th scope="col">Temps mis au service</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($k = 0; $k < count($pointagesSuccess); $k++)
                                <tr>
                                    <td>{{$k + 1}}</td>
                                    <td>
                                        {{$pointagesSuccess[$k]->personnel->nom." ".$pointagesSuccess[$k]->personnel->prenom}}
                                    </td>
                                    @if($pointagesSuccess[$k]->personnel->sexe == "Male")
                                        <td class="text-center">{{__("Masculin")}}</td>
                                    @elseif($pointagesSuccess[$k]->personnel->sexe == "Female")
                                        <td class="text-center">{{__("Feminin")}}</td>
                                    @endif
                                    <td class="text-center">{{$pointagesSuccess[$k]->structure->nom}}</td>
                                    <td class="text-center">{{$pointagesSuccess[$k]->poste->nom}}</td>
                                    <td class="text-center">{{$pointagesSuccess[$k]["date"]}}</td>
                                    <td class="text-center">{{$pointagesSuccess[$k]["entree"]}}</td>
                                    <td class="text-center">{{$pointagesSuccess[$k]["sortie"]}}</td>
                                    <td class="text-center">{{$pointagesSuccess[$k]["total"]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end row-->
            </div><!-- end card-body -->
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Pointages échoués du personnel</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-striped-columns mb-0">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom(s) et prénom(s)</th>
                                <th scope="col">Sexe</th>
                                <th scope="col">Structure</th>
                                <th scope="col">Poste</th>
                                <th scope="col">Date de pointage</th>
                                <th scope="col">Heure d'entrée</th>
                                <th scope="col">Heure de sortie</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($k = 0; $k < count($echoues); $k++)
                                <tr>
                                    <td >{{$k + 1}}</td>
                                    <td>
                                        {{$echoues[$k]["nom"]." ".$echoues[$k]["prenom"]}}
                                    </td>
                                    @if($echoues[$k]["sexe"] == "Male")
                                        <td class="text-center">{{__("Masculin")}}</td>
                                    @elseif($echoues[$k]["sexe"] == "Female")
                                        <td class="text-center">{{__("Feminin")}}</td>
                                    @endif
                                    <td class="text-center">{{$echoues[$k]["structure"]}}</td>
                                    <td class="text-center">{{$echoues[$k]["poste"]}}</td>
                                    <td class="text-center">{{$echoues[$k]["date"]}}</td>
                                    <td class="text-center">{{$echoues[$k]["entree"]}}</td>
                                    <td class="text-center">{{$echoues[$k]["sortie"]}}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end row-->
            </div><!-- end card-body -->
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">

        var dates = @json($dates);

        var heuresArrivee = @json($datesEntree);
        var heuresDepart =  @json($datesSortie);

        var tempsMoyen = @json($datesTotal);

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Temps moyen mis au travail',
                    data: tempsMoyen,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        const arrive = document.getElementById('arriveChart')
        new Chart(arrive, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    data: heuresArrivee,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    label: "Heure moyenne d'arrivée au travail"
                }]
            },
            options: {
                scales: {
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        max: 24,
                    }
                }
            }
        });

        const depart = document.getElementById('departChart')
        new Chart(depart, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Heure moyenne de départ du travail',
                    data: heuresDepart,
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    tension: 0.1,
                }]
            },
            options: {
                scales: {
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        max:24
                    }
                }
            }
        });

        const ratio = document.getElementById('ratioChart')

        new Chart(ratio, {
            type: 'pie',
            data: {
                labels: ["Réussis", "Rejetés"],
                datasets: [{
                    label: 'Ratio pointages réussis/rejeté',
                    data: ["{{count($pointagesSuccess)}}", "{{count($pointagesFail)}}"],
                    backgroundColor: [
                        "rgb(69, 175, 217)",
                        "rgb(255,0,0)"
                    ],
                    hoverOffset: 4
                }]
            },
        })

    </script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

@endsection
