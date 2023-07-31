<?php $__env->startSection('title'); ?> Accueil <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> DSI <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Tableau de bord <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/gridjs/gridjs.min.css')); ?>">
<?php $__env->stopSection(); ?>

<div class="row">
    <div class="col">

        <div class="h-100">

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Basic Line Chart</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="line_chart_basic" data-colors='["--vz-primary"]' class="apex-charts" dir="ltr"></div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Zoomable Timeseries</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="line_chart_zoomable" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Bar Chart</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="bar" class="chartjs-chart"
                                data-colors='["--vz-primary-rgb, 0.8", "--vz-primary-rgb, 0.9"]'></canvas>

                    </div>
                </div>
            </div> <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 flex-grow-1">Base Example</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="table-gridjs"></div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>

    </div> <!-- end col -->
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/apexcharts-line.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('assets/libs/chart.js/chart.js.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/chartjs.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('assets/libs/prismjs/prismjs.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/gridjs/gridjs.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/js/pages/gridjs.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/index.blade.php ENDPATH**/ ?>