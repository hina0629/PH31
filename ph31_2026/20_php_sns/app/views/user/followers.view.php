<div class="flex max-w-4xl mx-auto min-h-screen">

    <header class="sticky top-0 h-screen w-20 shrink-0 self-start border-r border-slate-100 xl:w-56">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <?php include COMPONENT_DIR . 'dashboard.php' ?>
        <?php include COMPONENT_DIR . 'profile_tabs.php' ?>

        <?php if (empty($users)) : ?>
            <p class="p-8 text-center text-slate-400 text-sm">フォロワーはまだいません</p>
        <?php else : ?>
            <?php foreach ($users as $follow_user) : ?>
                <?php include COMPONENT_DIR . 'follow_user_item.php' ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

</div>