<?php

include_once __DIR__.'/php/include_db.php';

$html_title = $settings->get('shop_title');

$tel = 'null';
$tel_href = 'tel:';
$address = 'null';

$authorized = $access->checkSessionCookie($settings->get('session_name'));
// if ($authorized) {
//     header('Location: ./');
// }

?>
<!DOCTYPE html>
<html lang="ru" class="page">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Заголовок</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/shop.js"></script>
</head>
<body class="page__body">
  <a href="./admin-auth" style="position: fixed; opacity: 0.5; bottom: 10px; left: 10px;">(Перейти в панель управления)</a>
  <header class="header">
    <div class="container">
      <div class="header__content-inner">
        <div class="header__logo-wrapper">
          <a class="header__logo" href="#">
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

              <script>const AUTHORIZED = true;</script>

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

              <script>const AUTHORIZED = false;</script>

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
          <aside class="catalog__aside aside" id="categories">
            <a class="aside__categories aside__categories--active" data-path="one">
              <img class="aside__categories-image" src="img/kits.svg" alt="kits" width="25" height="25" data-path="one">
              <span class="aside__categories-text" data-path="one">Наборы и констукторы</span>
            </a>
            <a class="aside__categories" data-path="two">
              <img class="aside__categories-image" src="img/led.svg" alt="display and led" width="25" height="25" data-path="two">
              <span class="aside__categories-text" data-path="two">Дисплеи, светодоиоды</span>
            </a>
            <a class="aside__categories" data-path="three">
              <img class="aside__categories-image" src="img/discounted.svg" alt="discounted" width="25" height="25" data-path="three">
              <span class="aside__categories-text" data-path="three">Уцененные товары</span>
            </a>
          </aside>
          <div class="catalog__product" id="catalog">
            <ul class="catalog__product-list catalog__product-list--active" data-target="one">
              <h3 class="catalog__product-title">Наборы и констукторы</h3>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="catalog-product">
                  <img src="img/arduino.jpg" alt="Ардуино" width="110" height="80">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title" href="catalog-product">Набор 37 основных датчиков и модулей Arduino</a>
                  <p class="card__descr">Пластиковый бокс в комплекте 27 x 18 x 4 см</p>
                  <span class="card__id">Код товара: 1671</span>
                  <span class="card__availability not-availability">Нет в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text price-disabled">1581 ₽</span>
                  <button class="price-basket basket-disabled">В корзину</button>
                </div>
              </li>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="catalog-product">
                  <img src="img/pozitronik.jpg" alt="Электронный конструктор Позитроник" width="105" height="105">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title" href="catalog-product">Электронный конструктор "Позитроник"</a>
                  <p class="card__descr">Сборка без пайки на макетную плату, 34 электронные схемы, 74 элемента. Всё необходимое в комплекте. Для детей от 8 лет</p>
                  <span class="card__id">Код товара: 1566</span>
                  <span class="card__availability">Товар в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text">0 ₽</span>
                  <button class="price-basket">В корзину</button>
                </div>
              </li>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="catalog-product">
                  <img src="img/bomb.jpg" alt="Электронный конструктор Безопасная бомба" width="120" height="90">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title" href="catalog-product">Электронный конструктор "Безопасная бомба, Полицейская мигалка"</a>
                  <p class="card__descr">Сборка без пайки на медный скотч. 2 схемы-эксперимента, 26 компонентов в наборе. Для детей от 8 лет.</p>
                  <span class="card__id">Код товара: 2172</span>
                  <span class="card__availability">Товар в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text">546 ₽</span>
                  <button class="price-basket">В корзину</button>
                </div>
              </li>
            </ul>

            <ul class="catalog__product-list" data-target="two">
              <h3 class="catalog__product-title">Дисплеи, светодоиоды</h3>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="#">
                  <img src="img/lcd-convetor.jpg" alt="LCD 1602 2004 конвертор в I2C" width="110" height="80">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title">LCD 1602 2004 конвертор в I2C</a>
                  <p class="card__descr">Модуль для подключения текстового дисплея по I2C</p>
                  <span class="card__id">Код товара: 1671</span>
                  <span class="card__availability">Товар в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text">130 ₽</span>
                  <button class="price-basket">В корзину</button>
                </div>
              </li>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="#">
                  <img src="img/lcd-convetor.jpg" alt="Символьный LCD дисплей 1602 с I2C конвертером, синий" width="105" height="105">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title">Символьный LCD дисплей 1602 с I2C конвертером, синий</a>
                  <p class="card__descr">2 строки по 16 символов, без поддержки кириллицы</p>
                  <span class="card__id">Код товара: 2160</span>
                  <span class="card__availability">Товар в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text">581 ₽</span>
                  <button class="price-basket">В корзину</button>
                </div>
              </li>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="#">
                  <img src="img/lcd-sumbol.jpg" alt="Символьный LCD дисплей 1602 с I2C конвертером, зеленый" width="120" height="90">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title">Символьный LCD дисплей 1602 с I2C конвертером, зеленый</a>
                  <p class="card__descr">2 строки по 16 символов, без поддержки кириллицы</p>
                  <span class="card__id">Код товара: 2094</span>
                  <span class="card__availability not-availability">Нет в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text price-disabled">390 ₽</span>
                  <button class="price-basket basket-disabled">В корзину</button>
                </div>
              </li>
            </ul>

            <ul class="catalog__product-list" data-target="three">
              <h3 class="catalog__product-title">Уцененные товары</h3>
              <li class="catalog__product-item">
                <a class="catalog__product-image" href="#">
                  <img src="img/corpus.jpg" alt="Корпус средний с окном" width="110" height="80">
                </a>
                <div class="catalog__product-descr card">
                  <a class="card__title">Корпус средний с окном</a>
                  <p class="card__descr">100x70x25 мм, 7 штук. Уценка - долго лежали</p>
                  <span class="card__id">Код товара: 1935</span>
                  <span class="card__availability">Товар в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text">170 ₽</span>
                  <button class="price-basket">В корзину</button>
                </div>
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