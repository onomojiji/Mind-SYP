<?php $__env->startSection('title'); ?> Liste des importation <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Liste des importation <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/importations/index.blade.php ENDPATH**/ ?>