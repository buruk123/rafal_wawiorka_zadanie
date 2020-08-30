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
<div class="list-articles">
    <h4>Artykuły autora <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] ?> </h4>
</div>
</body>

<?php require('scripts/active_nav_item.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $.getJSON('api/author/listArticles.php', function (data) {
            let items = [];
            $.each(data, function (key, value) {
                $.each(value, function (key, value) {
                    items.push('<p><a href=editArticle.php?id=' + value.article_id + '>' + value.article_title + '</a></p>')
                });
            });
            $('.list-articles').append(items);
        });
    });

</script>

</html>
