<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>MINDSYP - Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/favicon.ico")}} ">

    <!-- Layout config Js -->
    <script src="{{asset("assets/js/layout.js")}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset("assets/css/custom.min.css")}}" rel="stylesheet" type="text/css" />


</head>

<body style="
      background-image: url({{asset("images/minddevel.png")}});
      background-position: top;
      background-repeat: no-repeat;
      background-size: cover;
      ">

<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position" id="auth-particles" style="background-image: url('{{asset("images/nft/marketplace.png")}}')">
        <div class="bg-overlay"></div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-2 mb-2 text-white-50">
                        <div>
                            <p class="display-4 text-light fw-bold">{{__("MIND-SYP")}}</p>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">{{("Supervision des données des pointeurs biométriques du personnel du Ministère de la décentralisation et du developpement local du Cameroun")}}</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">{{__("Bienvenue")}}</h5>
                                <p class="text-muted">{{__("Connectez vous pour continuer.")}}</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{route("login")}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{"Email"}}</label>
                                        <input type="text" class="form-control" id="email" placeholder="{{__("Entrer votre addresse email")}}" name="email">
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="#" class="text-muted">{{("Mot de passe oublié.?")}}</a>
                                        </div>
                                        <label class="form-label" for="password">{{__("Mot de passe")}}</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input" placeholder="{{("Entrer votre mot de passe")}}" id="password" name="password">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">{{("Se souvenir de moi")}}</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">{{("Se connecter")}}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        Copyright &copy; <span id="date"></span> <a class="fw-bold text-success" href="https://www.minddevel.gov.cm" target="_blank">MINDDEVEL CAMEROUN</a>, Tous droits réservés.
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js")}} "></script>
<script src="{{asset("assets/libs/simplebar/simplebar.min.js")}} "></script>
<script src="{{asset("assets/libs/node-waves/waves.min.js")}} "></script>
<script src="{{asset("assets/libs/feather-icons/feather.min.js")}} "></script>
<script src="{{asset("assets/js/pages/plugins/lord-icon-2.1.0.js")}} "></script>
<script src="{{asset("assets/js/plugins.js")}} "></script>

<!-- particles js -->
<script src="{{asset("assets/libs/particles.js/particles.js")}} "></script>
<!-- particles app js -->
<script src="{{asset("assets/js/pages/particles.app.js")}} "></script>
<!-- password-addon init -->
<script src="{{asset("assets/js/pages/password-addon.init.js")}} "></script>
<script>
    var today = new Date();
    var date = today.getFullYear()
    if(date===2023){
        document.getElementById("date").innerHTML = 2023;
    }else{
        document.getElementById("date").innerHTML="2023 - " + date;
    }
</script>
</body>

</html>
