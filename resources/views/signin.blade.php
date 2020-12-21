<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      form {
        font-family: 'Quicksand';
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form id="formSignIn">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <!-- <h1 class="h3 mb-3 fw-normal">Please sign in</h1> -->
            <label for="inputEmail" class="visually-hidden">Email</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
            <label for="inputPassword" class="visually-hidden">Mật khẩu</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <!-- <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div> -->
            <button id="btnSignIn" class="w-100 btn btn-lg btn-primary" type="submit" disabled="disable">Đăng nhập</button>
            <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p> -->
        </form>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.form-control').on('keydown', function(){
            $('.form-control').removeClass('border border-danger');
            $('#btnSignIn').removeAttr('disabled');
        });

        $('inputPassword').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                document.getElementById('btnSignIn').click();
            }
        });

        $('#formSignIn').on('submit', function (e) {
            e.preventDefault();
            var email = document.getElementById('inputEmail').value;
            var password = document.getElementById('inputPassword').value;
            $.ajax({
                url: '/admin/signin-process',
                data: {
                    email: email,
                    password: password,
                },
                dataType: 'json',
                type: 'post',
                cache: false,
                success: function(res) {
                    if (res.message == 1) {
                        window.location.href = "/dashboard";
                    } else if (res.message == 0) {
                        $('.form-control').addClass('border border-danger');
                        $('#btnSignIn').attr('disabled','disabled');
                    }
                }
            });
        });
    </script>
</body>

</html>
