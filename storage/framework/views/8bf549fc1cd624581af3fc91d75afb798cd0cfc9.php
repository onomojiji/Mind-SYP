<?php $__env->startSection('title'); ?> Modifier le profil <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Accueil <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->personnel->nom." ".$user->personnel->prenom); ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>



    <div class="card p-3">

        <form action="<?php echo e(route("users.update", $user->id)); ?>" method="post">
            <?php echo csrf_field(); ?>
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

                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#nav-border-justified-profile" role="tab" aria-selected="false">
                            <i class="ri-user-line me-1 align-middle"></i> Informations du profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#nav-border-justified-messages" role="tab" aria-selected="false">
                            <i class="ri-lock-password-line align-middle me-1"></i>Mot de passe
                        </a>
                    </li>
                </ul>
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="nav-border-justified-profile" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="nom">Nom</label>
                                <input id="nom" value="<?php echo e($user->personnel->nom); ?>" type="text" name="nom" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="prenom">Prénom</label>
                                <input id="prenom" value="<?php echo e($user->personnel->prenom); ?>" type="text" name="prenom" class="form-control" placeholder="Entrez le prénom de l'utilisateur">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 form-group">
                                <label for="sexe">Sexe</label>
                                <select id="sexe" class="form-select" name="sexe" required>
                                    <option <?php if($user->personnel->sexe == "Male"): ?> selected <?php endif; ?> value="Male">Masculin</option>
                                    <option <?php if($user->personnel->sexe == "Female"): ?> selected <?php endif; ?> value="Female">Feminin</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Adresse email</label>
                                <input id="email" value="<?php echo e($user->email); ?>" type="email" name="email" class="form-control" placeholder="Entrez l'adresse email' de l'utilisateur" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="structure_id">Structure</label>
                                <select id="structure_id" class="form-select" name="structure_id" required>
                                    <?php $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($userStructure->id == $structure->id): ?> selected <?php endif; ?> value="<?php echo e($structure->id); ?>"><?php echo e($structure->nom); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="nav-border-justified-messages" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-md form-group">
                                <label for="oldpassword">Ancien mot de passe</label>
                                <input id="oldpassword" type="password" name="oldpassword" class="form-control" placeholder="Entrez l'ancien mot de passe de plus de 6 caractères">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md form-group">
                                <label for="password">Mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="Entrez un mot de passe de plus de 6 caractères">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col form-group">
                                <label for="confirm">Confirmation du mot de passe</label>
                                <input id="confirm" type="password" name="confirm" class="form-control" placeholder="Confirmer le mot de passe">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-primary w-25">Enregistrer</button>
                </div>
            </div>

        </form>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.master", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/Users/edit.blade.php ENDPATH**/ ?>