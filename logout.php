<?php

    include_once __DIR__.'/php/main.php';
    include_once __DIR__.'/php/include_db.php';

    // проверка доступа
    $session_name = $settings->get('session_name');
    $session_hash = $access->getSessionCookie($session_name);
    $current_uuid = $access->getUserIdBySessionHash($session_hash);
    if($current_uuid == false) {
        header('Location: ./');
    }
    else {
        // авторизован
        try {
            $access->removeAccessFrom($session_hash);
        }
        catch(Exception $e) {
            $status = new Status('ERROR');
        }
        header('Location: ./');
    }

?>