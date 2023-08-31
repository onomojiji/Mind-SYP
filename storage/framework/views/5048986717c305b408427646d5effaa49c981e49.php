<?php $__env->startSection('title'); ?> Liste des utilisateurs <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Liste des utilisateurs <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

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
                    <?php for($i=0; $i<count($users); $i++): ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e($users[$i]["nom"]." ".$users[$i]["prenom"]); ?></td>
                            <td><?php echo e($users[$i]["sexe"]); ?></td>
                            <td><?php echo e($users[$i]["structure"]); ?></td>
                            <td><?php echo e($users[$i]["email"]); ?></td>
                            <?php if($users[$i]["status"] == 1): ?>
                                <td class="text-center">
                                    <p class="badge text-bg-success">Actif</p>
                                </td>
                            <?php else: ?>
                                <td class="text-center">
                                    <p class="badge text-bg-danger">Désactivé</p>
                                </td>
                            <?php endif; ?>
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
                                            <a class="dropdown-item" href="<?php echo e(route("users.edit", $users[$i]["id"])); ?>">
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
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/Users/index.blade.php ENDPATH**/ ?>