<?php require_once('scripts/session-script.php') ?>
<!DOCTYPE html>
<html>
<head>
    <?php require('scripts/bootstrap-scripts.php'); ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/style.css">

</head>
<body>
<?php require('scripts/top-bar.php') ?>

<form action="api/author/editArticle.php" method="get" id="editArticleForm">
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
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" id="id">
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="creation_date" id="creation_date">
    </div>
    <button type="submit" class="btn btn-warning btn-lg">Zaktualizuj artykuł</button>
    <button type="reset" class="btn btn-warning btn-lg">Wyczyść</button>
</form>

<?php require('scripts/active_nav_item.php'); ?>

</body>

<script type="text/javascript">
    $('#editArticleForm').submit(function () {
        if ($('#exampleFormControlInput1').val() === "" || $('#exampleFormControlTextarea1').val() === "" || $('#authors').val() === "") {
            alert("Pola nie mogą być puste");
            return false;
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $.getJSON('api/article/getArticleById.php?id=' + <?php echo $_GET['id'] ?>, function (data) {
            let authors = [];
            $.each(data, function (key, value) {
                $.each(value, function (key, value) {
                    $('#exampleFormControlInput1').val(value.article_title);
                    $('#exampleFormControlTextarea1').val(value.article_text);
                    $('#id').val(value.article_id);
                    $('#creation_date').val(new Date().toISOString().split('T')[0]);
                    for (let i = 0; i < value.authors.length; i++) {
                        authors.push(value.authors[i].author_first_name + ' ' + value.authors[i].author_last_name + ';')
                    }
                    $('#authors').val(authors.join(''));
                });

            });
        });
    });
</script>

</html>