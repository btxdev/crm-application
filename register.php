<?php

include_once __DIR__.'/php/include_db.php';

$html_title = $settings->get('shop_title');

$authorized = $access->checkSessionCookie($settings->get('session_name'));
if ($authorized) {
    header('Location: ./');
}

?>
<!DOCTYPE html>
<html lang="ru" class="page">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $html_title ?> :: Авторизация</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/register.js"></script>
</head>
<body class="page__body page__authorization">
  <main class="main authorization">
    <div class="form-inner">
      <form method="POST" class="form" autocomplete="off">
        <h2 class="form-title">РЕГИСТРАЦИЯ</h2>
        <div class="input__login-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Логин" id="register-login">
        </div>
        <div class="input__password-wrapper input-wrapper">
          <input type="password" autocomplete="new-password" class="input__password input" placeholder="Пароль" id="register-password">
        </div>
        <div class="input__phone-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Имя" id="register-name1">
        </div>
        <div class="input__phone-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Фамилия" id="register-name2">
        </div>
        <div class="input__phone-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Отчество" id="register-name3">
        </div>
        <div class="input__phone-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Контактный телефон" id="register-phone">
        </div>
        <div class="input__phone-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Ваш email" id="register-email">
        </div>
        <div class="button-wrapper">
          <button class="button-input" onclick="registerForm();">Зарегистрироваться</button>
        </div>
      </form>
    </div>
  </main>
  <div class="admin-panel-btn" onclick="document.location.href = './admin-auth'">Перейти в панель управления</div>
</body>
</html>