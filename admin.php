<?php

include_once __DIR__.'/php/include_db.php';

$html_title = $settings->get('html_title');

$authorized = $access->checkSessionCookie($settings->get('session_name'));
if (!$authorized) {
    header('Location: auth');
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
    <link rel="stylesheet" href="css/app.css">
    
    <script type="application/javascript" src="js/app.js"></script>
</head>
<body>
    <div class="limiter">
        <div class="container">
            <main>
                <div class="header">
                    <div class="header__title" id="header-title">Сотрудники</div>
                    <div class="header__profile">
                        <div class="header__username" id="header-username">admin</div>
                        <div class="header__line"></div>
                        <div class="header__name" id="header-name">Иван Петров</div>
                        <div class="header__photo1">
                            <div class="header__photo2"></div>
                        </div>
                    </div>
                </div>
                <div class="content">

                    <!-- Сотрудники -->
                    <div class="page" id="employees">
                        <table class="employees-table">
                            <tr class="employees-table__title-row">
                                    <td style="width: 20px;"><div class="title">#</div></td>
                                    <td><div class="title">Имя</div></td>
                                    <td><div class="title">Фамилия</div></td>
                                    <td><div class="title">Отчество</div></td>
                                    <td><div class="title">Должность</div></td>
                                    <td style="width: 160px;"><div class="title"></div></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">1</div></td>
                                <td><div class="field">Иван</div></td>
                                <td><div class="field">Петров</div></td>
                                <td><div class="field">Александрович</div></td>
                                <td><div class="field">Агент по недвижимости</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-employee-edit');">Подробнее</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">2</div></td>
                                <td><div class="field">Алексей</div></td>
                                <td><div class="field">Иванов</div></td>
                                <td><div class="field">Игоревич</div></td>
                                <td><div class="field">Директор</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-employee-edit');">Подробнее</button></td>
                            </tr>
                            <tr class="employee">
                                <td style="width: 20px;"><div class="field">3</div></td>
                                <td><div class="field">Михаил</div></td>
                                <td><div class="field">Корнишонов</div></td>
                                <td><div class="field">Константинович</div></td>
                                <td><div class="field">Бухгалтер</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-employee-edit');">Подробнее</button></td>
                            </tr>
                        </table>
                        <button class="employees-btn" onclick="openPopup('popup-employee-add')">Добавить сотрудника</button>
                    </div>

                    <!-- Услуги -->
                    <div class="page" id="services" style="display: none;">
                        <table class="employees-table services-table">
                            <tr class="employees-table__title-row">
                                    <td style="width: 20px;"><div class="title">#</div></td>
                                    <td><div class="title">Наименование услуги</div></td>
                                    <td><div class="title">Стоимость</div></td>
                                    <td style="width: 160px;"><div class="title"></div></td>
                                    <td style="width: 100px;"><div class="title"></div></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">1</div></td>
                                <td><div class="field">Услуга</div></td>
                                <td><div class="field">300 $</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-service-edit');">Редактировать</button></td>
                                <td style="width: 100px;"><button class="table-btn__remove">Удалить</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">2</div></td>
                                <td><div class="field">Услуга</div></td>
                                <td><div class="field">300 $</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-service-edit');">Редактировать</button></td>
                                <td style="width: 100px;"><button class="table-btn__remove">Удалить</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">3</div></td>
                                <td><div class="field">Услуга</div></td>
                                <td><div class="field">300 $</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-service-edit');">Редактировать</button></td>
                                <td style="width: 100px;"><button class="table-btn__remove">Удалить</button></td>
                            </tr>
                        </table>
                        <button class="employees-btn" onclick="openPopup('popup-service-add')">Добавить услугу</button>
                    </div>

                    <!-- Договоры -->
                    <div class="page" id="contracts" style="display: none;">
                        <div class="search">
                            <input type="text" class="search__input" placeholder="Поиск">
                            <button class="search__button">Найти</button>
                        </div>
                        <table class="employees-table services-table">
                            <tr class="employees-table__title-row">
                                    <td style="width: 20px;"><div class="title">#</div></td>
                                    <td><div class="title">Тип договора</div></td>
                                    <td><div class="title">Дата создания договора</div></td>
                                    <td style="width: 160px;"><div class="title"></div></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">1</div></td>
                                <td><div class="field">default</div></td>
                                <td><div class="field">01.01.2022</div></td>
                                <td style="width: 160px;"><button>Просмотр</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">2</div></td>
                                <td><div class="field">default</div></td>
                                <td><div class="field">01.01.2022</div></td>
                                <td style="width: 160px;"><button>Просмотр</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">3</div></td>
                                <td><div class="field">default</div></td>
                                <td><div class="field">01.01.2022</div></td>
                                <td style="width: 160px;"><button>Просмотр</button></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Сделки -->
                    <div class="page" id="deals" style="display: none;"></div>

                    <!-- Недвижимость -->
                    <div class="page" id="apartments" style="display: none;"></div>

                    <!-- Клиенты -->
                    <div class="page" id="clients" style="display: none;">
                        <div class="search">
                            <input type="text" class="search__input" placeholder="Поиск">
                            <button class="search__button">Найти</button>
                        </div>
                        <table class="employees-table services-table">
                            <tr class="employees-table__title-row">
                                <td style="width: 20px;"><div class="title">#</div></td>
                                <td style="width: 150px;"><div class="title">Имя</div></td>
                                <td style="width: 150px;"><div class="title">Фамилия</div></td>
                                <td style="width: 150px;"><div class="title">Отчество</div></td>
                                <td style="width: 150px;"><div class="title">Телефон</div></td>
                                <td style="width: 150px;"><div class="title">Дата регистрации</div></td>
                                <td style="width: 160px;"><div class="title"></div></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">1</div></td>
                                <td style="width: 150px;"><div class="field">Иван</div></td>
                                <td style="width: 150px;"><div class="field">Иванов</div></td>
                                <td style="width: 150px;"><div class="field">Иванович</div></td>
                                <td style="width: 150px;"><div class="field">+7 (800) 555 35 35</div></td>
                                <td style="width: 150px;"><div class="field">01.01.2021</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-client-edit')">Подробнее</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">2</div></td>
                                <td style="width: 150px;"><div class="field">Иван</div></td>
                                <td style="width: 150px;"><div class="field">Иванов</div></td>
                                <td style="width: 150px;"><div class="field">Иванович</div></td>
                                <td style="width: 150px;"><div class="field">+7 (800) 555 35 35</div></td>
                                <td style="width: 150px;"><div class="field">01.01.2021</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-client-edit')">Подробнее</button></td>
                            </tr>
                            <tr>
                                <td style="width: 20px;"><div class="field">3</div></td>
                                <td style="width: 150px;"><div class="field">Иван</div></td>
                                <td style="width: 150px;"><div class="field">Иванов</div></td>
                                <td style="width: 150px;"><div class="field">Иванович</div></td>
                                <td style="width: 150px;"><div class="field">+7 (800) 555 35 35</div></td>
                                <td style="width: 150px;"><div class="field">01.01.2021</div></td>
                                <td style="width: 160px;"><button onclick="openPopup('popup-client-edit')">Подробнее</button></td>
                            </tr>
                        </table>
                    </div>

                    <!-- Администрирование -->
                    <div class="page" id="admin" style="display: none;"></div>



                </div>

                <!-- <div id="shadow" style="display: none;"></div> -->

                <div id="windows" style="display: none;">

                    <!-- Редактировать информацию о сотруднике -->
                    <div class="popup" id="popup-employee-edit" style="display: none;">
                        <div class="popup-title">Информация о сотруднике <div class="emp-id"># 1</div></div>
                        <table class="popup-table">
                            <tr>
                                <td><span>Имя</span></td>
                                <td><input type="text" value="Иван"></td>
                            </tr>
                            <tr>
                                <td><span>Фамилия</span></td>
                                <td><input type="text" value="Иванов"></td>
                            </tr>
                            <tr>
                                <td><span>Отчество</span></td>
                                <td><input type="text" value="Иванович"></td>
                            </tr>
                            <tr>
                                <td><span>Должность</span></td>
                                <td>
                                    <select name="edit-employee-position" id="popup-employy-edit__select">
                                        <option value="">Выберите должность</option>
                                        <option value="director">Директор</option>
                                        <option value="agent">Агент по недвижимости</option>
                                        <option value="admin">Системный администратор</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Уровень доступа</span></td>
                                <td>
                                    <select name="edit-employee-role" id="popup-employy-edit__select">
                                        <option value="">Выберите роль</option>
                                        <option value="director">Администратор</option>
                                        <option value="agent">Сотрудник</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Дата рождения</span></td>
                                <td><input type="date"></td>
                            </tr>
                            <tr>
                                <td><span>Номер телефона</span></td>
                                <td><input type="text" value="+7 (800) 555 35 35"></td>
                            </tr>
                            <tr>
                                <td><span>Адрес электронной почты</span></td>
                                <td><input type="text" value="webmaster@site.ru"></td>
                            </tr>
                            <tr>
                                <td><span>Дата регистрации</span></td>
                                <td><input type="date"></td>
                            </tr>
                        </table>
                        <button class="popup-apply">Сохранить</button>
                        <button class="popup-cancel" onclick="closePopup();">Отмена</button>
                    </div>

                    <!-- Добавить нового сотрудника -->
                    <div class="popup" id="popup-employee-add" style="display: none;">
                        <div class="popup-title">Добавить сотрудника</div>
                        <table class="popup-table">
                            <tr>
                                <td><span>Имя</span></td>
                                <td><input type="text" value="Иван"></td>
                            </tr>
                            <tr>
                                <td><span>Фамилия</span></td>
                                <td><input type="text" value="Иванов"></td>
                            </tr>
                            <tr>
                                <td><span>Отчество</span></td>
                                <td><input type="text" value="Иванович"></td>
                            </tr>
                            <tr>
                                <td><span>Должность</span></td>
                                <td>
                                    <select name="edit-employee-position" id="popup-employy-edit__select">
                                        <option value="">Выберите должность</option>
                                        <option value="director">Директор</option>
                                        <option value="agent">Агент по недвижимости</option>
                                        <option value="admin">Системный администратор</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Уровень доступа</span></td>
                                <td>
                                    <select name="edit-employee-role" id="popup-employy-edit__select">
                                        <option value="">Выберите роль</option>
                                        <option value="director">Администратор</option>
                                        <option value="agent">Сотрудник</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Дата рождения</span></td>
                                <td><input type="date"></td>
                            </tr>
                            <tr>
                                <td><span>Номер телефона</span></td>
                                <td><input type="text" value="+7 (800) 555 35 35"></td>
                            </tr>
                            <tr>
                                <td><span>Адрес электронной почты</span></td>
                                <td><input type="text" value="webmaster@site.ru"></td>
                            </tr>
                        </table>
                        <button class="popup-apply">Добавить</button>
                        <button class="popup-cancel" onclick="closePopup();">Отмена</button>
                    </div>

                    <!-- Предупреждение -->
                    <div class="popup" id="popup-alert" style="display: none;">
                        <div class="popup-title">Предупреждение</div>
                        <p class="popup-message">Вы уверены, что хотите удалить услугу? <br><br> После удаления услуги, все связанные с услугой сделки также будут удалены.</p>
                        <button class="popup-apply">Подтвердить</button>
                        <button class="popup-cancel">Отмена</button>
                    </div>

                    <!-- Редактировать информацию о услуге -->
                    <div class="popup" id="popup-service-edit" style="display: none;">
                        <div class="popup-title">Информация о услуге</div>
                        <table class="popup-table">
                            <tr>
                                <td><span>Наименование</span></td>
                                <td><input type="text" value="Наименование услуги"></td>
                            </tr>
                            <tr>
                                <td><span>Описание</span></td>
                                <td><input type="text" value="Здесь описание услуги"></td>
                            </tr>
                            <tr>
                                <td><span>Стоимость</span></td>
                                <td><input type="number" value="300" min="0"></td>
                            </tr>
                        </table>
                        <p class="popup-p">Описание услуги</p>
                        <textarea class="popup-textarea">Прародителем текста-рыбы является известный "Lorem Ipsum" – латинский текст, ноги которого растут аж из 45 года до нашей эры. Сервисов по созданию случайного текста на основе Lorem Ipsum великое множество, однако все они имеют один существенный недостаток</textarea><br>
                        <button class="popup-apply">Сохранить</button>
                        <button class="popup-cancel" onclick="closePopup();">Отмена</button>
                    </div>

                    <!-- Добавить услугу -->
                    <div class="popup" id="popup-service-add" style="display: none;">
                        <div class="popup-title">Добавить услугу</div>
                        <table class="popup-table">
                            <tr>
                                <td><span>Наименование</span></td>
                                <td><input type="text" value="Наименование услуги"></td>
                            </tr>
                            <tr>
                                <td><span>Описание</span></td>
                                <td><input type="text" value="Здесь описание услуги"></td>
                            </tr>
                            <tr>
                                <td><span>Стоимость</span></td>
                                <td><input type="number" value="300" min="0"></td>
                            </tr>
                        </table>
                        <p class="popup-p">Описание услуги</p>
                        <textarea class="popup-textarea">Прародителем текста-рыбы является известный "Lorem Ipsum" – латинский текст, ноги которого растут аж из 45 года до нашей эры. Сервисов по созданию случайного текста на основе Lorem Ipsum великое множество, однако все они имеют один существенный недостаток</textarea><br>
                        <button class="popup-apply">Добавить</button>
                        <button class="popup-cancel" onclick="closePopup();">Отмена</button>
                    </div>

                    <!-- Редактировать информацию о клиенте -->
                    <div class="popup" id="popup-client-edit" style="display: none;">
                        <div class="popup-title">Информация о клиенте</div>
                        <table class="popup-table">
                            <tr>
                                <td><span>Имя</span></td>
                                <td><input type="text" value="Иван"></td>
                            </tr>
                            <tr>
                                <td><span>Фамилия</span></td>
                                <td><input type="text" value="Иванов"></td>
                            </tr>
                            <tr>
                                <td><span>Отчество</span></td>
                                <td><input type="text" value="Иванович"></td>
                            </tr>
                            <tr>
                                <td><span>Телефон</span></td>
                                <td><input type="text" value="+7 (800) 555 35 35"></td>
                            </tr>
                            <tr>
                                <td><span>Адрес электронной почты</span></td>
                                <td><input type="text" value="mail@site.ru"></td>
                            </tr>
                        </table>
                        <p class="popup-p">Паспортные данные</p>
                        <table class="popup-table">
                            <tr>
                                <td><span>Серия</span></td>
                                <td><input type="number" value="1111"></td>
                            </tr>
                            <tr>
                                <td><span>Номер</span></td>
                                <td><input type="number" value="111111"></td>
                            </tr>
                            <tr>
                                <td><span>Дата выдачи</span></td>
                                <td><input type="date"></td>
                            </tr>
                            <tr>
                                <td><span>Дата рождения</span></td>
                                <td><input type="date"></td>
                            </tr>
                        </table>
                        <p class="popup-p">Кем выдан</p>
                        <textarea class="popup-textarea">Прародителем текста-рыбы является известный "Lorem Ipsum" – латинский текст, ноги которого растут аж из 45 года до нашей эры. Сервисов по созданию случайного текста на основе Lorem Ipsum великое множество, однако все они имеют один существенный недостаток</textarea><br>
                        <p class="popup-p">Место рождения</p>
                        <textarea class="popup-textarea">Прародителем текста-рыбы является известный "Lorem Ipsum" – латинский текст, ноги которого растут аж из 45 года до нашей эры. Сервисов по созданию случайного текста на основе Lorem Ipsum великое множество, однако все они имеют один существенный недостаток</textarea><br>
                        <p class="popup-p">Адрес проживания</p>
                        <textarea class="popup-textarea">Прародителем текста-рыбы является известный "Lorem Ipsum" – латинский текст, ноги которого растут аж из 45 года до нашей эры. Сервисов по созданию случайного текста на основе Lorem Ipsum великое множество, однако все они имеют один существенный недостаток</textarea><br>
                        <button class="popup-apply">Сохранить</button>
                        <button class="popup-cancel" onclick="closePopup();">Отмена</button>
                    </div>

                </div>

            </main>

            <aside>
                <div class="aside-title">
                    <div class="aside-title__logo"></div>
                    <div class="aside-title__title">Панель управления</div>
                </div>
                <ul class="aside-ul">
                    <li class="aside-li aside-li_focused" onclick="openPage('employees');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Сотрудники</div>
                    </li>
                    <li class="aside-li" onclick="openPage('services');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Услуги</div>
                    </li>
                    <li class="aside-li" onclick="openPage('contracts');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Договоры</div>
                    </li>
                    <li class="aside-li" onclick="openPage('deals');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Сделки</div>
                    </li>
                    <li class="aside-li" onclick="openPage('apartments');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Недвижимость</div>
                    </li>
                    <li class="aside-li" onclick="openPage('clients');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Клиенты</div>
                    </li>
                </ul>
                <div class="aside-line"></div>
                <ul class="aside-ul">
                    <li class="aside-li" onclick="openPage('admin');">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Администрирование</div>
                    </li>
                    <li class="aside-li" onclick="logout();">
                        <div class="aside-li__icon"></div>
                        <div class="aside-li__label">Выход</div>
                    </li>
                </ul>
            </aside>

        </div>
    </div>
</body>
</html>