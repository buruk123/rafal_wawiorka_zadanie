<div class='container-fluid top-bar'>
    <div class="text-center">
        <h1>Rafał Wawiórka - zadanie</h1>
    </div>
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">
                <a class="nav-item nav-link" href="index.php">Strona główna</a>
                <a class="nav-item nav-link" href="recruitment_tasks.php">Zadania rekrutacyjne</a>
            </div>
            <div class=navbar-nav>
                <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') { ?>
                    <a class="nav-item nav-link" href="api/user/makeAnAuthor.php">Zostań autorem</a>
                <?php } else if (isset($_SESSION['type']) && $_SESSION['type'] == 'author') { ?>
                    <a class="nav-item nav-link" href="listArticles.php">Edytuj swoje artykuły</a>
                    <a class="nav-item nav-link" href="addArticle.php">Dodaj artykuł</a>
                <?php } ?>
                <?php if (isset($_SESSION['user_first_name']) && isset($_SESSION['user_last_name'])) { ?>
                    <a class="nav-item nav-link"
                       href="index.php"><?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . ' [' . $_SESSION['type'] . ']' ?>
                    </a>
                    <a class="nav-item nav-link" href="api/user/logoutUser.php">Wyloguj</a>
                <?php } else { ?>
                    <a class="nav-item nav-link"
                       href="loginRegister.php">Zaloguj/Zarejestruj</a>
                <?php } ?>
            </div>
        </div>
    </nav>
</div>