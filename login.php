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
  <title><?=$html_title?> :: Авторизация</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">
  <script defer src="js/login.js"></script>
</head>
<body class="page__body page__authorization">
  <main class="main authorization">
    <div class="form-inner">
      <form action="" class="form">
        <h2 class="form-title">АВТОРИЗАЦИЯ</h2>
        <div class="input__login-wrapper input-wrapper">
          <input type="text" class="input__login input" placeholder="Логин" id="login-login">
        </div>
        <div class="input__password-wrapper input-wrapper">
          <input type="password" class="input__password input" placeholder="Пароль" id="login-password">
        </div>
        <span>Вы еще не зарегистрированы?</span>
        <br>
        <br>
        <a href="register">Зарегистрироваться</a>
        <br>
        <br>
        <div class="button-wrapper">
          <button class="button-input" type="submit" onclick="loginForm();" id="login-btn">Вход</button>
        </div>
      </form>
    </div>
  </main>
  <div class="admin-panel-btn" onclick="document.location.href = './admin-auth'">Перейти в панель управления</div>
</body>
</html>