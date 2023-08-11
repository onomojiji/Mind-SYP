<?php $__env->startSection('title'); ?> Accueil <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Tableau de bord MINDDEVEL <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <?php $__env->startSection('css'); ?>
        <link rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/gridjs/gridjs.min.css')); ?>">
    <?php $__env->stopSection(); ?>

    <form method="get" action="<?php echo e(route("root")); ?>">
        <div class="row ">

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-1 my-2 text-center"><strong>De</strong></div>

                    <div class="col-md-6">
                        <select class="form-select mb-3" name="moisStart">
                            <option value="1">JANVIER</option>
                            <option value="2">FEVRIER</option>
                            <option value="3">MARS</option>
                            <option value="4">AVRIL</option>
                            <option value="5">MAI</option>
                            <option value="6">JUIN</option>
                            <option value="7">JUILLET</option>
                            <option value="8">AOÛT</option>
                            <option value="9">SEPTEMBRE</option>
                            <option value="10">OCTOBRE</option>
                            <option value="11">NOVEMBRE</option>
                            <option value="12">DECEMBRE</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select class="form-select mb-3" name="anneeStart">
                            <?php for($i = 2018; $i <= \Illuminate\Support\Carbon::now()->year; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="row">

                    <div class="col-md-1 my-2 text-center"><strong>A</strong></div>

                    <div class="col-md-6">
                        <select class="form-select mb-3" name="moisEnd">
                            <option value="1" <?php if(\Illuminate\Support\Carbon::now()->month == 1): ?> selected <?php endif; ?>>JANVIER</option>
                            <option value="2" <?php if(\Illuminate\Support\Carbon::now()->month == 2): ?> selected <?php endif; ?>>FEVRIER</option>
                            <option value="3" <?php if(\Illuminate\Support\Carbon::now()->month == 3): ?> selected <?php endif; ?>>MARS</option>
                            <option value="4" <?php if(\Illuminate\Support\Carbon::now()->month == 4): ?> selected <?php endif; ?>>AVRIL</option>
                            <option value="5" <?php if(\Illuminate\Support\Carbon::now()->month == 5): ?> selected <?php endif; ?>>MAI</option>
                            <option value="6" <?php if(\Illuminate\Support\Carbon::now()->month == 6): ?> selected <?php endif; ?>>JUIN</option>
                            <option value="7" <?php if(\Illuminate\Support\Carbon::now()->month == 7): ?> selected <?php endif; ?>>JUILLET</option>
                            <option value="8" <?php if(\Illuminate\Support\Carbon::now()->month == 8): ?> selected <?php endif; ?>>AOÛT</option>
                            <option value="9" <?php if(\Illuminate\Support\Carbon::now()->month == 9): ?> selected <?php endif; ?>>SEPTEMBRE</option>
                            <option value="10" <?php if(\Illuminate\Support\Carbon::now()->month == 10): ?> selected <?php endif; ?>>OCTOBRE</option>
                            <option value="11" <?php if(\Illuminate\Support\Carbon::now()->month == 11): ?> selected <?php endif; ?>>NOVEMBRE</option>
                            <option value="12" <?php if(\Illuminate\Support\Carbon::now()->month == 12): ?> selected <?php endif; ?>>DECEMBRE</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select class="form-select mb-3" name="anneeEnd">
                            <?php for($j = \Illuminate\Support\Carbon::now()->year; $j >= 2018; $j--): ?>
                                <option value="<?php echo e($j); ?>"><?php echo e($j); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-1 my-md-0 mb-3">
                <button type="submit" class="btn btn-primary">Valider</button>
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
                                        <h2 class="mb-0 text-info"><span class="counter-value" data-target="<?php echo e($hme); ?>">0</span> h <span class="counter-value" data-target="<?php echo e($mme); ?>">0</span> min</h2>
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
                                        <h2 class="mb-0 text-info"><span class="counter-value" data-target="<?php echo e($hms); ?>">0</span> h <span class="counter-value" data-target="<?php echo e($mms); ?>">0</span> min</h2>
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
                                <h4 class="card-title mb-0">Ratio pointages réussis/rejetés</h4>
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

        const ratio = document.getElementById('ratioChart')

        new Chart(ratio, {
            type: 'pie',
            data: {
                labels: ["Réussis", "Rejetés"],
                datasets: [{
                    label: 'Ratio pointages réussis/rejeté',
                    data: ["<?php echo e($pointagesSuccess); ?>", "<?php echo e($pointagesFail); ?>"],
                    backgroundColor: [
                        "rgb(69, 175, 217)",
                        "rgb(255,0,0)"
                    ],
                    hoverOffset: 4
                }]
            },
        })

    </script>

    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/index.blade.php ENDPATH**/ ?>