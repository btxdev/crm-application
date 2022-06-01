<?php

    include_once __DIR__.'/main.php';
    include_once __DIR__.'/include_db.php';

    // // создание пользователя admin
    $admin_uuid = $admin->createUser('admin', 'r00tPassw0rd');

    // // присвоение роли admin пользователю admin
    $admin->setRoleToUser('admin', $admin_uuid);

    // // создание пользователя test
    // $user_uuid = $admin->createUser('test', '123456');

    // // присвоение роли default пользователю test
    // $admin->setRoleToUser('default', $user_uuid);

    // удаление
    //$admin->removeUser($admin->getUserId('admin'));
    // $admin->removeUser($admin->getUserId('test'));

    // $result = $access->grantAccessToUserName('admin');

    // $result1 = $access->isAccessGranted('14e5dedbff3e3bf6');
    // $result2 = $access->isAccessGranted('14e5dedbff3e3bf5');

    // var_dump($result1);
    // var_dump($result2);

    //$access->removeAccessFromUserName('admin');

    // $result = $access->login('admin', 'r00tPassw0rd');

    // var_dump($result);

    // $result = $access->grantAccessToUserName('admin');
    // $access->setSessionCookie($settings->get('session_name'), $result);

?>