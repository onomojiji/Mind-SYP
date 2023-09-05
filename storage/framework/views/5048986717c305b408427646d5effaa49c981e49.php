<?php $__env->startSection('title'); ?> Liste des utilisateurs <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Liste des utilisateurs <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="card">
        <div class="card-body">
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="alert alert-danger mb-2" role="alert">
                        <?php echo e($error); ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(@session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(@session('fail')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('fail')); ?>

                </div>
            <?php endif; ?>
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
                            <td class="text-center">
                                <?php if($users[$i]["admin"] == 1): ?>
                                    <p class="badge text-bg-primary">Admin</p>
                                <?php endif; ?>

                                <?php if($users[$i]["status"] == 1): ?>
                                    <p class="badge text-bg-success">Actif</p>
                                <?php else: ?>
                                    <p class="badge text-bg-danger">Désactivé</p>
                                <?php endif; ?>
                            </td>

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
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route("users.update.admin", $users[$i]["id"])); ?>">
                                                <?php if($users[$i]["admin"] == 1): ?>
                                                    <i class="ri-user-unfollow-fill text-danger me-2 align-middle"></i>
                                                    <span class="text-danger">Retirer admin</span>
                                                <?php else: ?>
                                                    <i class="ri-user-settings-fill text-primary me-2 align-middle"></i>
                                                    <span class="text-primary">Nomer admin</span>
                                                <?php endif; ?>

                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo e(route("users.update.status", $users[$i]["id"])); ?>">
                                                <?php if($users[$i]["status"] == 1): ?>
                                                    <i class="ri-delete-bin-fill text-danger me-2 align-middle"></i>
                                                    <span class="text-danger">Désactiver</span>
                                                <?php else: ?>
                                                    <i class="ri-check-fill me-2 align-middle text-primary"></i>
                                                    <span class="text-primary">Activer</span>
                                                <?php endif; ?>

                                            </a>
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