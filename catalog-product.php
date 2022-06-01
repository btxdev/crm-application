<?php

$tel = 'null';
$tel_href = 'tel:';
$address = 'null';

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
  <header class="header">
    <div class="header__content-inner">
      <div class="header__logo-wrapper">
        <a class="header__logo" href="./">
          <img src="img/ardu-logo.svg" alt="logo" width="125" height="25">
        </a>
      </div>
      <div class="header__content">
        <input class="header__content-search" type="text" placeholder="Поиск товаров">
        <a class="header__content-phone" href="<?= $tel_href ?>">
          <?= $tel ?>
        </a>
        <a class="header__content-adress" href="#" target="_blank">
          <?= $address ?>
        </a>
      </div>
      <nav class="nav">
        <a href="basket">
          <ul class="nav__list list-reset">
            <li class="nav__item">
              <img src="img/basket.svg" alt="basket" width="21" height="16">
              <span class="nav__basket-sum nav__price">1215</span>
              <span class="nav__rub nav__price">₽</span>
            </li>
          </ul>
        </a>
      </nav>
    </div>
  </header>

  <main class="main">
    <section class="catalog">
      <div class="container">
        <div class="catalog__inner">
          <aside class="catalog__aside aside">
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
          <div class="catalog__product product__page">
            <ul class="catalog__product-list catalog__product-list--active product__list">
              <div class="breadcrumbs">
                <div class="container">
                  <ul class="breadcrumbs__list">
                    <li class="breadcrumbs__item">
                      <a class="breadcrumbs__link" href="#">Каталог</a>
                    </li>
                    <li class="breadcrumbs__item">
                      <a class="breadcrumbs__link" href="#">Наборы и конструкторы</a>
                    </li>
                  </ul>
                </div>
              </div>
              <li class="catalog__product-item product__page-item">
                <a class="catalog__product-image product__page-image" href="#">
                  <img src="img/arduino.jpg" alt="Ардуино" width="400" height="300">
                </a>
                <div class="catalog__product-descr card product__page-card">
                  <a class="card__title product__page-card__title">Набор 37 основных датчиков и модулей Arduino</a>
                  <p class="card__descr product__page-card__descr">Пластиковый бокс в комплекте 27 x 18 x 4 см</p>
                  <span class="card__id product__page-card__id">Код товара: 1671</span>
                  <span class="card__availability not-availability product__page-card-availability">Нет в наличии</span>
                </div>
                <div class="catalog__product-price price-wrapper">
                  <span class="price-text price-disabled">1581 ₽</span>
                  <button class="price-basket basket-disabled">В корзину</button>
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
        <a class="header__content-phone" href="<?= $tel_href ?>">
          <?= $tel ?>
        </a>
        <a class="header__content-adress" href="#" target="_blank">
          <?= $address ?>
        </a>
      </div>
    </div>
  </footer>
</body>
</html>