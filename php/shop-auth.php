<?php

include_once __DIR__.'/main.php';
include_once __DIR__.'/include_db.php';

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
    // получение данных POST формы
    $content = trim(file_get_contents("php://input"));

    $decoded = json_decode($content, true);

    // ошибка обработки JSON
    if(! is_array($decoded)) {
        exit(emptyJson());
    }
}

function emptyJson() {
    return json_encode (json_decode ("{}"));
}
function processStatus($status) {
    if($status->ok())
        return $status->returnValue;
    else
        exit($status->json());
}
function requireFields($fields) {
    global $decoded;
    foreach($fields as $field) {
        if(!isset($decoded[$field])) {
            var_dump($decoded);
            exit(emptyJson());
        }
    }
}

if(isset($decoded['op'])) {

    if($decoded['op'] == 'login') {
        requireFields(['login', 'password']);
        $login = htmlspecialchars($decoded['login']);
        $password = htmlspecialchars($decoded['password']);
        
        $loginResult = $access->login($login, $password);
        if($loginResult->ok()) {
            $hash = $loginResult->session;
            $result = $access->setSessionCookie($settings->get('session_name'), $hash);
            exit($result->json());
        }
        else {
            exit($loginResult->json());
        }
    }

    if($decoded['op'] == 'register') {

        requireFields(['login', 'password', 'name1', 'name2', 'name3', 'email', 'phone']);

        $login = htmlspecialchars($decoded['login']);
        $password = htmlspecialchars($decoded['password']);
        $name1 = htmlspecialchars($decoded['name1']);
        $name2 = htmlspecialchars($decoded['name2']);
        $name3 = htmlspecialchars($decoded['name3']);
        $email = htmlspecialchars($decoded['email']);
        $phone = htmlspecialchars($decoded['phone']);

        $id = $admin->createUser($login, $password);
        if($id == false) {
            $result = new Status('WRONG_FORMAT');
            exit($result->json());
        }

        $admin->setRoleToUser('default', $id);

        $hash = $access->grantAccessToUserId($id);
        $result = $access->setSessionCookie($settings->get('session_name'), $hash);

        // add information
        $db->run(
            'UPDATE `users` SET 
            `first_name` = :name1,
            `second_name` = :name2,
            `patronymic` = :name3,
            `email` = :email,
            `phone` = :phone 
            WHERE `uuid` = :id',
            [
                ':id' => $id,
                ':name1' => $name1,
                ':name2' => $name2,
                ':name3' => $name3,
                ':email' => $email,
                ':phone' => $phone
            ]
        );

        $result = new Status('OK');
        exit($result->json());

    }

}





?>