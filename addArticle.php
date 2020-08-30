<?php require_once('scripts/session-script.php') ?>
<!DOCTYPE html>
<html>

<head>
    <?php require('scripts/bootstrap-scripts.php'); ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/style.css">

</head>

<body>
<?php require('scripts/top-bar.php') ?>

<form action="api/author/addArticle.php" method="get" id="addArticleForm">
    <div class="form-group">
        <label for="exampleFormControlInput1">Tytuł</label>
        <input type="text" class="form-control" name="title" id="exampleFormControlInput1">
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Treść</label>
        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="5"></textarea>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="authors" id="authors"
               placeholder="Imię i nazwisko autora/ów oddzielone średnikiem(;)">
    </div>
    <button type="submit" class="btn btn-warning btn-lg">Dodaj artykuł</button>
    <button type="reset" class="btn btn-warning btn-lg">Wyczyść</button>
</form>

</body>

<?php require('scripts/active_nav_item.php'); ?>

<script type="text/javascript">
    $('#addArticleForm').submit(function () {
        if ($('#exampleFormControlInput1').val() === "" || $('#exampleFormControlTextarea1').val() === "" || $('#authors').val() === "") {
            alert("Pola nie mogą być puste");
            return false;
        }
    });

</script>

</html>
