<?php $__env->startSection('title'); ?> Accueil <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Tableau de bord MINDDEVEL <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startSection('css'); ?>
        <link rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/gridjs/gridjs.min.css')); ?>">
    <?php $__env->stopSection(); ?>

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
                                        <h2 class="mb-0 text-primary"><span class="counter-value" data-target="<?php echo e($nbPointages); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-md-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Pointages réussie
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 text-success"><span class="counter-value" data-target="<?php echo e($pointagesSuccess); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-md-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Pointages Rejetés
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0 text-danger"><span class="counter-value" data-target="<?php echo e($pointagesFail); ?>">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg border-end">
                            <div class="mt-3 mt-lg-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Heures moyenne d'arrivée
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-0">
                                        <h2 class="mb-0 text-info"><span class="counter-value" data-target="07">0</span> h <span class="counter-value" data-target="38">0</span> min</h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col col-lg">
                            <div class="mt-3 mt-lg-0 py-4 px-2">
                                <h5 class="text-muted text-uppercase fs-13">Heure moyenne de départ
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-0">
                                        <h2 class="mb-0 text-info"><span class="counter-value" data-target="15">0</span> h <span class="counter-value" data-target="23">0</span> min</h2>
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
                                <h4 class="card-title mb-0">Ration poitages réussi/rejeté</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div>
                                    <canvas id="departChart"></canvas>
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
            <h4 class="card-title">Personnel par structure</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-center"
                         role="tablist" aria-orientation="vertical">
                        <?php for($i = 0; $i < count($personnels["structure"]); $i++): ?>
                            <?php if($i==0): ?>
                                <a class="nav-link active show" id="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])."-tab"); ?>" data-bs-toggle="pill"
                                   href="#<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>" role="tab" aria-controls="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>"
                                   aria-selected="true">
                                    <?php echo e($personnels["structure"][$i]); ?></a>
                            <?php else: ?>
                                <a class="nav-link" id="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])."-tab"); ?>" data-bs-toggle="pill"
                                   href="#<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>" role="tab" aria-controls="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>"
                                   aria-selected="false">
                                    <?php echo e($personnels["structure"][$i]); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div> <!-- end col-->
                <div class="col-lg-10">
                    <div class="tab-content text-muted mt-3 mt-lg-0">

                        <?php for($i = 0; $i < count($personnels["structure"]); $i++): ?>
                            <?php if($i==0): ?>
                                <div class="tab-pane fade active show" id="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>" role="tabpanel"
                                     aria-labelledby="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])."-tab"); ?>">
                                    <?php else: ?>
                                        <div class="tab-pane fade" id="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])); ?>" role="tabpanel"
                                             aria-labelledby="<?php echo e(Str::remove([" ", "'", "-"], $personnels["structure"][$i])."-tab"); ?>">
                                            <?php endif; ?>
                                            <div class="table-responsive table-card">
                                                <table class="table table-nowrap table-striped-columns mb-0">
                                                    <thead class="table-light">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nom(s) et prénom(s)</th>
                                                        <th scope="col">Sexe</th>
                                                        <th scope="col">Poste</th>
                                                        <th scope="col">Structure</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php for($j = 0; $j < count($personnels["personnel"]); $j++): ?>
                                                        <?php if($personnels["personnel"][$j]["structure"] == $personnels["structure"][$i]): ?>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <a href="#">
                                                                        <?php echo e($personnels["personnel"][$j]["nom"]." ".$personnels["personnel"][$j]["prenom"]); ?>

                                                                    </a>
                                                                </td>
                                                                <?php if($personnels["personnel"][$j]["sexe"] == "Male"): ?>
                                                                    <td><?php echo e(__("Masculin")); ?></td>
                                                                <?php elseif($personnels["personnel"][$j]["sexe"] == "Female"): ?>
                                                                    <td><?php echo e(__("Feminin")); ?></td>
                                                                <?php endif; ?>
                                                                <td><?php echo e($personnels["personnel"][$j]["poste"]); ?></td>
                                                                <td><?php echo e($personnels["personnel"][$j]["structure"]); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!--end tab-pane-->
                                        <?php endfor; ?>
                                </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div><!-- end card-body -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="text/javascript">

        let dates = ["4 Jul","5 Jul","6 Jul","7 Jul","8 Jul","11 Jul","12 Jul","13 Jul","16 Jul","17 Jul","18 Jul","19 Jul","20 Jul","21 Jul","22 Jul","25 Jul","26 Jul","27 Jul","28 Jul","29 Jul"]

        let heuresArrivee = ["7", "6", "7", "8", "7","7", "6", "8", "7", "6", "8","8","7","7", "6", "6", "7", "8", "8","10",]

        let heuresDepart =  ["14", "16", "15", "15", "15","16", "16", "18", "14", "15", "15","15","17","17", "16", "16", "15", "16", "16","15",]

        let tempsMoyen = ["8", "7", "7", "8", "6", "7", "6", "7","8","6","7", "6", "8", "7", "6", "7", "7", "8","8","7",]

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

    </script>

    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/index.blade.php ENDPATH**/ ?>