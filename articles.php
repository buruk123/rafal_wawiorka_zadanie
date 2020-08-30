<?php require_once('scripts/session-script.php') ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<?php include 'scripts/top-bar.php'; ?>
<div class="article-class"></div>
</body>
<?php include 'scripts/bootstrap-scripts.php'; ?>
<?php include 'scripts/active_nav_item.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $.getJSON('api/article/getArticleById.php?id=<?php echo $_GET['id']?>', function (data) {
            let items = [];
            $.each(data, function (key, value) {
                $.each(value, function (key, value) {
                    items.push('<h1>' + value.article_title + '</h1>\n' +
                        '<h4>' + value.article_text + '</h4>\n');
                    $.each(value.authors, function (key, value) {
                        items.push('<h5 class="text-right">' + value.author_first_name + ' ' + value.author_last_name + '</h5>');
                    });

                    items.push('<p class="text-right">' + value.article_creation_date + '</p>');
                });
            });
            $(".article-class").append(items);
        });
    });
</script>


</html>