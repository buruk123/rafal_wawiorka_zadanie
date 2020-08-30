<?php require_once('scripts/session-script.php') ?>
<!DOCTYPE html>
<html>

<head>
    <?php require('scripts/bootstrap-scripts.php'); ?>
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
                    <h1 class="display-4 py-2 text-truncate text-dark">Rejestracja</h1>
                    <div class="px-2">
                        <form action="api/user/registerUser.php" class="justify-content-center" method="post"
                              id="registerForm">
                            <div class="form-group">
                                <input type="text" id="first_name_cred" name="user_first_name" class="form-control"
                                       placeholder="Imię">
                            </div>
                            <div class="form-group">
                                <input type="text" id="last_name_cred" name="user_last_name" class="form-control"
                                       placeholder="Nazwisko">
                            </div>
                            <div class="form-group">
                                <input type="text" id="login" name="user_login" class="form-control"
                                       placeholder="Login">
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="user_password" class="form-control"
                                       placeholder="Hasło">
                            </div>
                            <button type="submit" id="register" class="btn btn-warning btn-lg">Zarejestruj się</button>
                            <button type="reset" class="btn btn-warning btn-lg">Wyczyść
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

<?php require('scripts/active_nav_item.php'); ?>


<script type="text/javascript">
    $('#registerForm').submit(function () {
        if ($('#first_name_cred').val() === "" || $('#last_name_cred').val() === "" ||
            $('#login').val() === "" || $('password').val() === "") {
            alert("Pola nie mogą być puste");
            return false;
        }
    });

    $(document).ready(function () {
        let register_failure = '<?php echo $_SESSION['register_failure']; ?>';
        if (register_failure === 'yes') {
            alert('User already exists');
            <?php $_SESSION['register_failure'] = "no" ?>
        }
    });
</script>

</html>
