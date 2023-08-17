<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


        <title>{{$structure->nom."_".$mois1."_".$annee1."_".$mois2."_".$annee2}}</title>

        <style>
            body{
                background-color: white;
                font-size: 14px;
                padding: 5px;
            }

            * table{
                width: 100%;
                margin-bottom: 1%;
            }

            * table tr{
                justify-content: flex-start;
                align-self: auto;
            }
            .entete table td p{
                text-align: center;
            }
            .entete table td img{
                margin-left: auto;
                margin-right: auto;
            }


            .foot table tr td {
                width: 30%;
            }
            .qr table tr td {
                width: 50%;
            }

            .footer{
                width: 100%;
                position: fixed;
                bottom: 0;
            }

        </style>
    </head>

    <body>
        {{-- Entête --}}
        <div class="entete">
            <table>
                <tbody>
                <tr>
                    <td style="width: 35%">
                        <p>
                            <strong>
                                {{__("RÉPUBLIQUE DU CAMEROUN")}}<br>
                                {{__("--------")}}<br>
                                {{__("PAIX - TRAVAIL - PATRIE")}} <br>
                                {{__("--------")}} <br>
                                {{__("MINISTERE DE LA DECENTRALISATION ET DU DEVELOPPEMENT LOCAL")}} <br>
                                {{__("--------")}} <br>
                                {{__("SECRETARIAT GENERAL")}} <br>
                                {{__("--------")}} <br>
                                {{__("DIVISION DES SYSTEMES D'INFORMATION")}} <br>
                                {{__("--------")}} <br>
                            </strong>
                        </p>
                    </td>
                    <td style="vertical-align: super" class="text-center">
                        <img src="{{public_path("images/Republique_du_Cameroun.png")}}" alt="logo cameroun" width="200" height="200">
                    </td>
                    <td style="width: 35%">
                        <p>
                            <strong>
                                {{__("REPUBLIC OF CAMEROON")}}<br>
                                {{__("--------")}}<br>
                                {{__("PEACE - WORK - FATHERLAND")}} <br>
                                {{__("--------")}} <br>
                                {{__("MINISTRY OF DECENTRALIZATION AND LOCAL DEVELOPMENT")}} <br>
                                {{__("--------")}} <br>
                                {{__("SECRETARIAT GENERAL")}} <br>
                                {{__("--------")}} <br>
                                {{__("INFORMATION SYSTEMS DIVISION")}} <br>
                                {{__("--------")}} <br>
                            </strong>

                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


        <p style="font-size: 15px; text-align: center" class="text-center mt-5">
            <strong><u>{{$structure->nom.", PERIODE DE ".$mois1." ".$annee1." A ".$mois2." ".$annee2}}</u> </strong>


        </p>

        <div class="row mt-5">
            <table class="table table-hover table-bordered">
                <thead class="bg-primary">
                    <th>#</th>
                    <th colspan="1">Nom(s) et Prenom(s)</th>
                    <th colspan="1">Sexe</th>
                    <th colspan="1">Poste</th>
                    <th colspan="1">Heure moy d'entrée</th>
                    <th colspan="1">Heure moy de sortie</th>
                    <th colspan="1">Nombre de pointages</th>
                    <th colspan="1">Pourcentage de réussite</th>
                    <th colspan="1">Pointages rejétés</th>
                </thead>
                <tbody>
                    @for($i=0; $i<count($personnels); $i++)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$personnels[$i]["nom"]." ".$personnels[$i]["prenom"]}}</td>

                            @if($personnels[$i]["sexe"] == "Male")
                                <td>Masculin</td>
                            @elseif($personnels[$i]["sexe"] == "Female")
                                <td>Feminin</td>
                            @endif

                            <td>{{$personnels[$i]["poste"]}}</td>
                            <td>{{$personnels[$i]["hme"]."h".$personnels[$i]["mme"]."min"}}</td>
                            <td>{{$personnels[$i]["hms"]."h".$personnels[$i]["mms"]."min"}}</td>
                            <td>{{$personnels[$i]["nbPoints"]}}</td>
                            <td>{{number_format(($personnels[$i]["nbPointsReussis"]/$personnels[$i]["nbPoints"]) * 100, 1)." %" }}</td>
                            <td>{{$personnels[$i]["nbPointsEchoues"]}}</td>
                        </tr>
                    @endfor
                </tbody>

            </table>
        </div>

        <div class="row mt-5 pt-5">
            <table class="table table-hover table-bordered">
                <thead class="bg-success">
                <th>#</th>
                <th colspan="1">Nom(s) et Prenom(s)</th>
                <th colspan="1">Sexe</th>
                <th colspan="1">Structure</th>
                <th colspan="1">Poste</th>
                <th colspan="1">Date</th>
                <th colspan="1">Entree</th>
                <th colspan="1">Sortie</th>
                <th colspan="1">Temps mis au service</th>
                </thead>
                <tbody>
                @for($j=0; $j<count($pointagesSuccess); $j++)
                    <tr>
                        <td>{{$j+1}}</td>
                        <td>{{$pointagesSuccess[$j]->personnel->nom." ".$pointagesSuccess[$j]->personnel->prenom}}</td>

                        @if($pointagesSuccess[$j]->personnel->sexe == "Male")
                            <td>Masculin</td>
                        @elseif($pointagesSuccess[$j]->personnel->sexe == "Female")
                            <td>Feminin</td>
                        @endif

                        <td>{{$pointagesSuccess[$j]->structure->nom}}</td>
                        <td>{{$pointagesSuccess[$j]->poste->nom}}</td>
                        <td>{{$pointagesSuccess[$j]["date"]}}</td>
                        <td>{{$pointagesSuccess[$j]["entree"]}}</td>
                        <td>{{$pointagesSuccess[$j]["sortie"]}}</td>
                        <td>{{$pointagesSuccess[$j]["total"]}}</td>
                    </tr>
                @endfor
                </tbody>

            </table>
        </div>

        <div class="row mt-5 pt-5">
            <table class="table table-hover table-bordered">
                <thead class="bg-danger">
                <th>#</th>
                <th colspan="1">Nom(s) et Prenom(s)</th>
                <th colspan="1">Sexe</th>
                <th colspan="1">Structure</th>
                <th colspan="1">Poste</th>
                <th colspan="1">Date</th>
                <th colspan="1">Entree</th>
                <th colspan="1">Sortie</th>
                </thead>
                <tbody>
                @for($k=0; $k<count($echoues); $k++)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$echoues[$k]['nom']." ".$echoues[$k]['prenom']}}</td>

                        @if($echoues[$k]['sexe'] == "Male")
                            <td>Masculin</td>
                        @elseif($echoues[$k]['sexe'] == "Female")
                            <td>Feminin</td>
                        @endif

                        <td>{{$echoues[$k]['structure']}}</td>
                        <td>{{$echoues[$k]['poste']}}</td>
                        <td>{{$echoues[$k]["date"]}}</td>
                        <td>{{$echoues[$k]["entree"]}}</td>
                        <td>{{$echoues[$k]["sortie"]}}</td>
                    </tr>
                @endfor
                </tbody>

            </table>
        </div>

    </body>

</html>
