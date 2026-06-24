<head>
    <?php
    $appJsVersion = filemtime(BASE_DIR . '/js/app.js');
    $imageJsVersion = filemtime(BASE_DIR . '/js/image.js');
    $tweetJsVersion = filemtime(BASE_DIR . '/js/tweet.js');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_TITLE ?></title>
    <base href="<?= BASE_URL ?>">
    <script>
        window.APP_BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/app.js?v=<?= $appJsVersion ?>" defer></script>
    <script src="js/image.js?v=<?= $imageJsVersion ?>" defer></script>
    <script src="js/tweet.js?v=<?= $tweetJsVersion ?>" defer></script>
</head>