<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="<?php echo e(route("root")); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo_mindsyp.jpg')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo_mindsyp.jpg')); ?>" alt="" height="42">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="<?php echo e(route("root")); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('images/logo_mindsyp.jpg')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('images/logo_mindsyp.jpg')); ?>" alt="" height="42">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>MONITORING</span></li>

                <li class="nav-item">
                    <a href="<?php echo e(route("root")); ?>" class="nav-link"><i class="las la-tachometer-alt"></i> Accueil</a>
                </li>

                <?php if(\Illuminate\Support\Facades\Auth::user()->is_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#dashboards-menu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dashboards-menu">
                            <i class="las la-building"></i> <span>Structures</span>
                        </a>
                        <div class="collapse menu-dropdown" id="dashboards-menu">
                            <ul class="nav nav-sm flex-column">
                                <?php $__currentLoopData = \App\Models\Structure::orderBy("nom")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route("structure.dashboard", ["structure_id" => $structure->id])); ?>" class="nav-link"><?php echo e($structure->nom); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>
                    </li>

                    <li class="menu-title"><i class="ri-more-fill"></i> <span>ADMINISTRATION</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#importations" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="importations">
                            <i class="lar la-file-excel"></i> <span>Importations</span>
                        </a>
                        <div class="collapse menu-dropdown" id="importations">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route("importation.create")); ?>" class="nav-link">Nouvelle importation</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route("importation.list")); ?>" class="nav-link">Lister les importations</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="users">
                            <i class="lar la-user-circle"></i> <span>Utilisateurs</span>
                        </a>
                        <div class="collapse menu-dropdown" id="users">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route("users.create")); ?>" class="nav-link">Ajouter un utilisateur</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route("users.list")); ?>" class="nav-link">Lister les utilisateurs</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\Users\inimini\Documents\mindsyp\mindsyp\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>