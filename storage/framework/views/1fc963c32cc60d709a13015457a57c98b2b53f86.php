<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


        <title><?php echo e($structure->nom."_".$mois."_".$annee); ?></title>

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
        
        <div class="entete">
            <table>
                <tbody>
                <tr>
                    <td style="width: 35%">
                        <p>
                            <strong>
                                <?php echo e(__("RÉPUBLIQUE DU CAMEROUN")); ?><br>
                                <?php echo e(__("--------")); ?><br>
                                <?php echo e(__("PAIX - TRAVAIL - PATRIE")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("MINISTERE DE LA DECENTRALISATION ET DU DEVELOPPEMENT LOCAL")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("SECRETARIAT GENERAL")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("DIVISION DES SYSTEMES D'INFORMATION")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                            </strong>
                        </p>
                    </td>
                    <td style="vertical-align: super" class="text-center">
                        <img src="<?php echo e(public_path("images/Republique_du_Cameroun.png")); ?>" alt="logo cameroun" width="200" height="200">
                    </td>
                    <td style="width: 35%">
                        <p>
                            <strong>
                                <?php echo e(__("REPUBLIC OF CAMEROON")); ?><br>
                                <?php echo e(__("--------")); ?><br>
                                <?php echo e(__("PEACE - WORK - FATHERLAND")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("MINISTRY OF DECENTRALIZATION AND LOCAL DEVELOPMENT")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("SECRETARIAT GENERAL")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                                <?php echo e(__("INFORMATION SYSTEMS DIVISION")); ?> <br>
                                <?php echo e(__("--------")); ?> <br>
                            </strong>

                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>


        <p style="font-size: 15px; text-align: center" class="text-center mt-5">
            <strong><u><?php echo e($structure->nom.", PERIODE DE ".$mois." ".$annee); ?></u> </strong>


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
                    <?php for($i=0; $i<count($personnels); $i++): ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e($personnels[$i]["nom"]." ".$personnels[$i]["prenom"]); ?></td>

                            <?php if($personnels[$i]["sexe"] == "Male"): ?>
                                <td>Masculin</td>
                            <?php elseif($personnels[$i]["sexe"] == "Female"): ?>
                                <td>Feminin</td>
                            <?php endif; ?>

                            <td><?php echo e($personnels[$i]["poste"]); ?></td>
                            <td><?php echo e($personnels[$i]["hme"]."h".$personnels[$i]["mme"]."min"); ?></td>
                            <td><?php echo e($personnels[$i]["hms"]."h".$personnels[$i]["mms"]."min"); ?></td>
                            <td><?php echo e($personnels[$i]["nbPoints"]); ?></td>
                            <td><?php echo e(number_format(($personnels[$i]["nbPointsReussis"]/$personnels[$i]["nbPoints"]) * 100, 1)." %"); ?></td>
                            <td><?php echo e($personnels[$i]["nbPointsEchoues"]); ?></td>
                        </tr>
                    <?php endfor; ?>
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
                <?php for($j=0; $j<count($pointagesSuccess); $j++): ?>
                    <tr>
                        <td><?php echo e($j+1); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]->personnel->nom." ".$pointagesSuccess[$j]->personnel->prenom); ?></td>

                        <?php if($pointagesSuccess[$j]->personnel->sexe == "Male"): ?>
                            <td>Masculin</td>
                        <?php elseif($pointagesSuccess[$j]->personnel->sexe == "Female"): ?>
                            <td>Feminin</td>
                        <?php endif; ?>

                        <td><?php echo e($pointagesSuccess[$j]->structure->nom); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]->poste->nom); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]["date"]); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]["entree"]); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]["sortie"]); ?></td>
                        <td><?php echo e($pointagesSuccess[$j]["total"]); ?></td>
                    </tr>
                <?php endfor; ?>
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
                <?php for($k=0; $k<count($echoues); $k++): ?>
                    <tr>
                        <td><?php echo e($k+1); ?></td>
                        <td><?php echo e($echoues[$k]['nom']." ".$echoues[$k]['prenom']); ?></td>

                        <?php if($echoues[$k]['sexe'] == "Male"): ?>
                            <td>Masculin</td>
                        <?php elseif($echoues[$k]['sexe'] == "Female"): ?>
                            <td>Feminin</td>
                        <?php endif; ?>

                        <td><?php echo e($echoues[$k]['structure']); ?></td>
                        <td><?php echo e($echoues[$k]['poste']); ?></td>
                        <td><?php echo e($echoues[$k]["date"]); ?></td>
                        <td><?php echo e($echoues[$k]["entree"]); ?></td>
                        <td><?php echo e($echoues[$k]["sortie"]); ?></td>
                    </tr>
                <?php endfor; ?>
                </tbody>

            </table>
        </div>

    </body>

</html>
<?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/exportation.blade.php ENDPATH**/ ?>