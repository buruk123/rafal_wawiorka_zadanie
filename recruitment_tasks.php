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

<h5>Get article by ID:</h5>
<input type="text" id="get-article-by-id">
<button id="article-id">GET</button>
<div class="art-id"></div>
<hr>

<h5>Get all articles by author ID:</h5>
<input type="text" id="get-all-articles-by-author-id">
<button id="author-id">GET</button>
<div class="auth-id"></div>
<hr>

<h5>Get all articles by author name:</h5>
<input type="text" id="get-all-articles-by-author-name">
<button id="author-name">GET</button>
<div class="auth-name"></div>
<hr>

<h5>Get top 3 authors that wrote the most articles last week</h5>
<button id="most-authors">GET</button>
<div class="most-auth"></div>
<hr>

</body>

<?php require('scripts/active_nav_item.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#article-id').click(function () {
            let id = $("#get-article-by-id").val();
            if (id === "") {
                alert("Enter a number to get article by ID");
                return;
            }
            $.getJSON('api/article/getArticleById.php?id=' + id, function (data) {
                let items = [];
                $.each(data, function (key, value) {
                    $.each(value, function (key, value) {
                        items.push('<p><a href=articles.php?id=' + value.article_id + '>Title:' + value.article_title + '</a></p>');
                    });
                });
                $('.art-id').append(items);
            });
        });
        $('#author-id').click(function () {
            let id = $("#get-all-articles-by-author-id").val();
            if (id === "") {
                alert("Enter an author id");
                return;
            }
            $.getJSON('api/article/getAllArticlesByAuthorId.php?id=' + id, function (data) {
                let items = [];
                $.each(data, function (key, value) {
                    $.each(value, function (key, value) {
                        items.push('<p><a href=articles.php?id=' + value.article_id + '>Title:' + value.article_title + '</a></p>');
                    });
                });
                $('.auth-id').append(items);
            });
        });
        $('#author-name').click(function () {
            let name = $("#get-all-articles-by-author-name").val();
            if (name === "") {
                alert("Enter an author name");
                return;
            }
            let author = name.split(" ");
            $.getJSON('api/article/getAllArticlesByAuthorName.php?first_name=' + author[0] + '&last_name=' + author[1], function (data) {
                let items = [];
                $.each(data, function (key, value) {
                    $.each(value, function (key, value) {
                        items.push('<p><a href=articles.php?id=' + value.article_id + '>Title:' + value.article_title + '</a></p>');
                    });
                });
                $('.auth-name').append(items);
            });
        });
        $('#most-authors').click(function () {
            $.getJSON('api/article/getTopThreeAuthorsWithMostArticlesLastWeek.php', function (data) {
                let items = [];
                $.each(data, function (key, value) {
                    $.each(value, function (key, value) {
                        items.push('<p>' + value.author_first_name + ' ' + value.author_last_name + '</p>');
                    });
                });
                $('.most-auth').append(items);
            });
        });
    });
</script>

</html>