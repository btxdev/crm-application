<?php

include_once __DIR__.'/php/include_db.php';

$html_title = $settings->get('admin_title');

$authorized = $access->checkSessionCookie($settings->get('session_name'));
if (!$authorized) {
    header('Location: admin-auth');
}

function component($name) {
    $path = 'components/admin/'.$name.'.html';
    require($path);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <title>Панель управления :: <?= $html_title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin.css">
    
    <script type="application/javascript" src="js/admin.js"></script>
</head>
<body>
    <div class="limiter">
        <div class="container">
            <main>
                <div class="header">
                    <div class="header__title" id="header-title">Категории</div>
                    <div class="header__profile">
                        <div class="header__username" id="header-username">username</div>
                        <div class="header__line"></div>
                        <div class="header__name" id="header-name">Имя Фамилия</div>
                        <div class="header__photo1">
                            <div class="header__photo2"></div>
                        </div>
                    </div>
                </div>
                <div class="content">

                    <?php component('categories'); ?>
                    <?php component('items'); ?>
                    <?php component('orders'); ?>
                    <?php component('users'); ?>

                </div>

                <div id="windows" style="display: none;">

                    <?php component('popup/categories'); ?>
                    <?php component('popup/items'); ?>
                    <?php component('popup/orders'); ?>
                    
                </div>

            </main>

            <aside>
                <div class="aside-title">
                    <div class="aside-title__logo"></div>
                    <div class="aside-title__title">Панель управления</div>
                </div>
                <ul class="aside-ul">
                    <li class="aside-li aside-li_focused" onclick="openPage('categories');">
                        <div class="aside-li__icon" style="background-image: url(img/category-icon.png)"></div>
                        <div class="aside-li__label">Категории</div>
                    </li>
                    <li class="aside-li" onclick="openPage('items');">
                        <div class="aside-li__icon" style="background-image: url(img/item-icon.png)"></div>
                        <div class="aside-li__label">Товары</div>
                    </li>
                    <li class="aside-li" onclick="openPage('orders');">
                        <div class="aside-li__icon" style="background-image: url(img/order-icon.png)"></div>
                        <div class="aside-li__label">Заказы</div>
                    </li>
                    <li class="aside-li" onclick="openPage('users');" style="display: none;">
                        <div class="aside-li__icon" style="background-image: url(img/user-icon.png)"></div>
                        <div class="aside-li__label">Пользователи</div>
                    </li>
                </ul>
                <!--<div class="aside-line"></div>-->
                <ul class="aside-ul">
                    <li class="aside-li" onclick="openPage('admin');" style="display: none;">
                        <div class="aside-li__icon" style="background-image: url(img/admin-icon.png)"></div>
                        <div class="aside-li__label">Администрирование</div>
                    </li>
                    <li class="aside-li" onclick="logout();">
                        <div class="aside-li__icon" style="background-image: url(img/logout-icon.png)"></div>
                        <div class="aside-li__label">Выход</div>
                    </li>
                </ul>
            </aside>

        </div>
    </div>
</body>
</html>