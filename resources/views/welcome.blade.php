<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css" />

         <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}' };
        </script>

    </head>
    <body>
        <div class="container">
            <div id="app">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                      ` <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Gestion De Production</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="nav-item active">
                                <router-link to="/clients">Clients</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/providers">Fournisseurs</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/products">Produits</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/materials">Matieres</router-link>
                            </li>
                        </ul>
                    </div>
                </nav>
                <router-view></router-view>
            </div>
        </div>
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
