<?php $__env->startSection('title'); ?> Nouvelle importation <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> DSI <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Nouvelle importation <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="post" action="<?php echo e(route("importation.store")); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Importation du fichier excel</h4>
                                </div>
                                <div class="card-body">
                                    <?php if(@session('success')): ?>
                                        <div class="alert alert-success">
                                            <?php echo e(session('success')); ?>

                                        </div>
                                    <?php endif; ?>
                                        <?php if(@session('fail')): ?>
                                            <div class="alert alert-success">
                                                <?php echo e(session('fail')); ?>

                                            </div>
                                        <?php endif; ?>
                                    <div>
                                        <input class="form-control" type="file" id="file" accept=".csv, .xlsx" name="file" required>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-end">
                                        <button type="submit" class="btn btn-primary w-25">Importer</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div> <!-- end col -->
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/importations/create.blade.php ENDPATH**/ ?>