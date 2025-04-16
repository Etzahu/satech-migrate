
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities." />
        <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app" />
        <meta name="author" content="pixelstrap" />
        <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
        <title>{{ env('APP_NAME') }} | Login</title>
        <!-- Google font-->
        @includeIf('authentication.partials.css')
    </head>
    <body>
        <!-- Loader starts-->
        <div class="loader-wrapper">
            <div class="theme-loader">
                <div class="loader-p"></div>
            </div>
        </div>
        <!-- Loader ends-->
        <!-- error page start //-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="login-card" >
                        <div class="shadow-lg theme-form login-form">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('images/logo-app.png') }}" alt="Logo de la empresa" class="img-fluid">
                            </div>
                            <h2 class="mt-4 text-center f-w-600 font-primary">¡BIENVENID@!</h2>
                            <div class="login-social-title">
                                <h5>
                                    Si eres colaborador:
                                </h5>
                            </div>
                            <h6>Para continuar inicia sesión con tu cuenta @gptservices.com</h6>
                            <div class="form-group">
                                <a href="{{ route('login.redirect') }}" class="btn btn-primary">
                                    Inicia sesión con Google
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- error page end //-->
        @includeIf('authentication.partials.js')
    </body>
</html>
