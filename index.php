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

<div class="row row-margin">
</div>

<?php echo $_SESSION['author_id']; ?>

</body>

<?php require('scripts/active_nav_item.php'); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $.getJSON('api/article/getAllArticles.php', function (data) {
            let items = [];
            $.each(data, function (key, value) {
                $.each(value, function (key, val) {
                    items.push('<div class="col-lg-4 mb-4">\n' +
                        '            <div class="card h-100">\n' +
                        '                <h4 class="card-header"><b><a href=articles.php?id=' +
                        val.article_id + '>'
                        + val.article_title + '</a></b></h4>\n' +
                        '                <div class="card-body">\n' +
                        '                    <p class="card-text">' +
                        val.article_text.substring(0, 500).concat('<a href=articles.php?id=' + val.article_id + '> ...czytaj więcej</a>')
                        + '</p>\n ' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '        </div>'
                    )
                    ;
                });
            });
            $(".row").append(items);

        });
    });

</script>

</html>