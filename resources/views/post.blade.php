<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>{{ $post->title }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/product/">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="/css/product.css" rel="stylesheet">
    <link href="/css/carousel.css" rel="stylesheet">
    <style>
        body {
        font-family: 'Quicksand';
        padding-top: 0px !important;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .site-header a {
        text-decoration: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
    <!-- Custom styles for this template -->
    <link href="product.css" rel="stylesheet">
    <link href="carousel.css" rel="stylesheet">
</head>

<body>
    <header class="site-header sticky-top py-1">
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">About</h4>
                        <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Contact</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Follow on Twitter</a></li>
                            <li><a href="#" class="text-white">Like on Facebook</a></li>
                            <li><a href="#" class="text-white">Email me</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong>HOME</strong>
                </a>
                <a href="" class="navbar-brand d-flex align-items-center">
                    <strong>SELENIUM</strong>
                </a>
                <a href="" class="navbar-brand d-flex align-items-center">
                    <strong>ABOUT ME</strong>
                </a>
                <a href="" class="navbar-brand d-flex align-items-center">
                    <strong>D</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>
    <main>
        <div class="container" style="padding-top: 100px">
            <h1>{{ $post->title }}</h1>
            <p class="text-center">By: Đức Anh - {{ $post->created_at}}</p>
            <hr class="featurette-divider">
            <p>{{ $post->content }}</p>
            <hr class="featurette-divider">
        </div>
    </main>
    <footer class="container py-5">
        <center>
            <div class="row">
                <div class="col-3 col-md">
                    <h5>Instagram</h5>
                </div>
                <div class="col-3 col-md">
                    <h5><a href="https://www.facebook.com/imducanhh/" target="_blank">Facebook</a></h5>
                </div>
                <div class="col-3 col-md">
                    <h5>Github</h5>
                </div>
            </div>
        </center>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>