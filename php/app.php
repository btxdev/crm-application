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
        if(!isset($decoded[$field])) exit(emptyJson());
    }
}

// проверка доступа
$session_name = $settings->get('session_name');
$session_hash = $access->getSessionCookie($session_name);
$current_uuid = $access->getUserIdBySessionHash($session_hash);
if($current_uuid == false) {
    $result = new Status('NOT_AUTHORIZED');
    exit($result->json());
}


if(isset($decoded['op'])) {

    // === базовая информация ===
    if($decoded['op'] == 'basic_info') {

        // получить всю информацию о текущем пользователе
        $rows = $db->fetch(
            'SELECT * FROM `employees` WHERE `employee_id` = :uuid',
            [
                ':uuid' => $current_uuid
            ]
        );
        $data = [
            'status' => 'OK',
            'uuid' => $current_uuid,
            'username' => $rows['username'],
            'first_name' => $rows['first_name'],
            'second_name' => $rows['seconds_name'],
            'patronymic' => $rows['patronymic'],
            'phone' => $rows['phone'],
            'email' => $rows['email']
        ];
        exit(json_encode($data));
    }

    // === сотрудники ===
    

}





?>