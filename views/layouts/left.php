<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Users', 'icon' => 'fa fa-file-code-o', 'url' => ['/users']],
                    ['label' => 'Data Base', 'icon' => 'fa fa-file-code-o', 'url' => ['/zip']],
                    ['label' => 'Addenda', 'icon' => 'fa fa-file-code-o', 'url' => ['/addenda']],
                ],
            ]
        ) ?>

    </section>

</aside>
