<!DOCTYPE html>
<html lang="ja">

<!-- コンポーネント: components/head.php を読み込み -->
<?php include COMPONENT_DIR . 'head.php' ?>

<body class="bg-white text-slate-900 antialiased">
    <?php if (isset($auth_user)) : ?>
        <?php include COMPONENT_DIR . 'reply_modal.php' ?>
    <?php else: ?>
        <?php include COMPONENT_DIR . 'public_nav.php' ?>
    <?php endif ?>

    <?= $content ?? "" ?>

</body>

</html>