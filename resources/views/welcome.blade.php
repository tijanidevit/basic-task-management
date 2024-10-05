<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Staff Scheduler App</title>

    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/material.css">

    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">

            <div class="container">

                <div class="account-logo">
                    <a href="/"><img src="/assets/img/logo2.png" alt="Dreamguy's Technologies"></a>
                </div>

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Login</h3>
                        <p class="account-subtitle">Access to our dashboard</p>

                        <form method="POST" action="{{route('auth.login')}}">
                            @csrf
                            <div class="input-block mb-4">
                                <label class="col-form-label">Admin Username</label>
                                <input class="form-control" required type="text" name="username" value="{{old('username')}}">
                                <x-error-message record='username' />
                            </div>
                            <div class="input-block mb-4">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <label class="col-form-label">Password</label>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <input class="form-control" required name="password" type="password" id="password">
                                    <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                                </div>
                                <x-error-message record='password' />
                            </div>
                            <div class="input-block mb-4 text-center">
                                <button class="btn btn-primary account-btn" type="submit">Login</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/assets/js/jquery-3.7.1.min.js" type="85dacd99dbc489fd16684699-text/javascript"></script>

    <script src="/assets/js/bootstrap.bundle.min.js" type="85dacd99dbc489fd16684699-text/javascript"></script>

    <script src="/assets/js/app.js" type="85dacd99dbc489fd16684699-text/javascript"></script>
    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="85dacd99dbc489fd16684699-|49" defer></script>
</body>

</html>
