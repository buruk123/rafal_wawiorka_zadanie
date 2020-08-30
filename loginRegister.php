<?php require_once('scripts/session-script.php') ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body class="text-center">
<?php include('scripts/top-bar.php') ?>
<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row text-white">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                    <h1 class="display-4 py-2 text-truncate text-dark">Logowanie</h1>
                    <div class="px-2">
                        <form action="api/user/loginUser.php" class="justify-content-center" method="post"
                              id="loginForm">
                            <div class="form-group">
                                <label class="sr-only">Name</label>
                                <input type="text" id="login_cred" name="login" class="form-control"
                                       placeholder="Login">
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Email</label>
                                <input type="password" id="password_cred" name="password" class="form-control"
                                       placeholder="Hasło">
                            </div>
                            <button type="submit" id="login" class="btn btn-warning btn-lg">Zaloguj się</button>
                            <button type="button" id="redirect-register" class="btn btn-warning btn-lg">Zarejestruj
                                się
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

<?php include 'scripts/bootstrap-scripts.php'; ?>
<?php include 'scripts/active_nav_item.php'; ?>
<?php include 'scripts/redirect-to-register.php' ?>

<script type="text/javascript">
    $('#loginForm').submit(function () {
        let login = $('#login_cred').val();
        let password = $('#password_cred').val();
        if (login === "" || password === "") {
            alert("Pola nie mogą być puste");
            return false;
        }
    });

</script>

</html>
