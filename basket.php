<?php

include_once __DIR__.'/php/include_db.php';

$html_title = $settings->get('shop_title');

$tel = 'null';
$tel_href = 'tel:';
$address = 'null';

$hash = $access->getSessionCookie($settings->get('session_name'));
$uuid = $access->getUserIdBySessionHash($hash);

$authorized = $access->checkSessionCookie($settings->get('session_name'));
if (!$authorized) {
    header('Location: ./');
}



$result = $db->fetch(
    "SELECT `phone` FROM `users`
    WHERE uuid = :uuid 
    ", 
    [
        ':uuid' => $uuid
    ]
);
$phone = $result['phone'];

?>
<!DOCTYPE html>
<html lang="ru" class="page">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Корзина :: <?= $html_title ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/shop.js"></script>
  <script defer src="js/basket.js"></script>
</head>
<body class="page__body">
  <a href="./admin-auth" style="position: fixed; opacity: 0.5; bottom: 10px; left: 10px;">(Перейти в панель управления)</a>
  <header class="header">
    <div class="container">
      <div class="header__content-inner">
        <div class="header__logo-wrapper">
          <a class="header__logo" href="./">
            <img src="img/ardu-logo.svg" alt="logo" width="125" height="25">
          </a>
        </div>
        <div class="header__content">
          <input class="header__content-search" type="text" placeholder="Поиск товаров">
          <a class="header__content-phone" href="<?= $tel_href ?>" style="display: none;">
            <?= $tel ?>
          </a>
          <a class="header__content-adress" href="#" target="_blank" style="display: none;">
            <?= $address ?>
          </a>
        </div>
        <nav class="nav">
          <?php if($authorized): ?>

            <script>const AUTHORIZED = true; const PHONE = '<?=$phone?>';</script>

              <a href="./logout" class="nav__link">
                <ul class="nav__list list-reset">
                  <li class="nav__item">
                    <span class="nav__basket-sum nav__price">ВЫХОД</span>
                  </li>
                </ul>
              </a>
              <a href="basket" class="nav__link">
                <ul class="nav__list list-reset">
                  <li class="nav__item">
                    <img src="img/basket.svg" alt="basket" width="21" height="16">
                    <span class="nav__basket-sum nav__price" id="basket-total">0</span>
                    <span class="nav__rub nav__price">₽</span>
                  </li>
                </ul>
              </a>

          <?php else: ?>

              <a href="./login" class="nav__link">
                <ul class="nav__list list-reset">
                  <li class="nav__item">
                    <span class="nav__basket-sum nav__price">ВХОД</span>
                  </li>
                </ul>
              </a>

          <?php endif; ?>

        </nav>
      </div>
    </div>
  </header>

  <main class="main">
    <section class="catalog">
      <div class="container">
        <div class="catalog__inner">
          <aside class="catalog__aside aside" style="display: none;">
            <a class="aside__categories" href="./" data-path="one">
              <img class="aside__categories-image" src="img/kits.svg" alt="kits" width="25" height="25" data-path="one">
              <span class="aside__categories-text" data-path="one">Наборы и констукторы</span>
            </a>
            <a class="aside__categories" href="./" data-path="two">
              <img class="aside__categories-image" src="img/led.svg" alt="display and led" width="25" height="25" data-path="two">
              <span class="aside__categories-text" data-path="two">Дисплеи, светодоиоды</span>
            </a>
            <a class="aside__categories" href="./" data-path="three">
              <img class="aside__categories-image" src="img/discounted.svg" alt="discounted" width="25" height="25" data-path="three">
              <span class="aside__categories-text" data-path="three">Уцененные товары</span>
            </a>
          </aside>
          <div class="catalog__product basket">
            <ul class="catalog__product-list catalog__product-list--active basket__list">
              <h3 class="catalog__product-title basket__title">Оформление заказа</h3>
              <li class="catalog__product-item basket__product">
                <h5 class="basket-order__title">Ваши заказы</h5>
                <div id="orders-container">
                  <div class="basket__product-item order-complete">
                    <span class="basket__product-item__id">#1111</span>
                    <a class="basket__product-item__title">Заказ: товар товар товар товар товар товар товар товар товар...</a>
                    <span class="basket__product-item__price">Готов к выдаче</span>
                    <span class="basket__product-item__price-total">1215 ₽</span>
                  </div>
                  <div class="basket__product-item order-wait">
                    <span class="basket__product-item__id">#1111</span>
                    <a class="basket__product-item__title">Заказ: товар товар товар товар товар товар товар товар товар...</a>
                    <span class="basket__product-item__price">В обработке</span>
                    <span class="basket__product-item__price-total">1215 ₽</span>
                  </div>
                </div>
              </li>
              <li class="catalog__product-item basket__product">
                <h5 class="basket-order__title">Ваши товары</h5>
                <div id="basket-items-container">
                  <div class="basket__product-item">
                    <span class="basket__product-item__id">1566</span>
                    <div class="basket__product-item__image-wrap">
                      <img class="basket__product-item__image" src="img/pozitronik.jpg" alt="Электронный конструктор Позитроник" width="45" height="45">
                    </div>
                    <a class="basket__product-item__title">Электронный конструктор "Позитроник"</a>
                    <span class="basket__product-item__price">1215 ₽</span>
                    <div class="basket__product-item__count">
                      <div class="count-minus count-wrap">-</div>
                      <input class="count-input" type="text">
                      <div class="count-plus count-wrap">+</div>
                    </div>
                    <span class="basket__product-item__price-total">1215 ₽</span>
                    <div class="basket__product-item__delete">x</div>
                  </div>
                </div>
                <div class="basket__product-total total">
                  <div class="total-price">
                    <span class="total-price__span" id="basket-page-total-price">1215 ₽</span>
                  </div>
                </div>
              </li>
              <li class="catalog__product-item basket__contacts">
                <h5 class="basket-order__title">Контактные данные</h5>
                <span class="basket__contacts-number">Номер телефона *</span>
                <input type="tel" class="basket__contacts-input" required value="<?=$phone?>">
                <p class="basket__contacts-under">
                  Номер можно вводить в любом формате. Мы отправим SMS или позвоним, когда заказ будет готов к выдаче
                </p>
              </li>
              <li class="catalog__product-item basket__place-order">
                <button class="place-order" onclick="finishBasket();">Оформить заказ</button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="container">
      <div class="footer__content-inner">
        <a class="header__content-phone" href="<?= $tel_href ?>" style="display: none;">
          <?= $tel ?>
        </a>
        <a class="header__content-adress" href="#" target="_blank" style="display: none;">
          <?= $address ?>
        </a>
      </div>
    </div>
  </footer>
</body>
</html>