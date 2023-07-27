<?php $__env->startSection('title'); ?> Accueil <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> DSI <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Tableau de bord <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col">

        <div class="h-100">


        </div>

    </div> <!-- end col -->
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mindsyp\resources\views/index.blade.php ENDPATH**/ ?>