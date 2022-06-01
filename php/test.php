<?php

    include_once __DIR__.'/main.php';
    include_once __DIR__.'/include_db.php';

    // // создание ролей
    // $admin->createRole('admin');
    // $admin->createRole('default');

    // // создание пользователя admin
    // $admin_uuid = $admin->getUserId('admin');
    // if(!$admin_uuid) $admin_uuid = $admin->createUser('admin', 'QwerZ123!!!');

    // // присвоение роли admin пользователю admin
    // $admin->setRoleToUser('admin', $admin_uuid);

    // // создание пользователя user
    // $user_uuid = $admin->getUserId('user');
    // if(!$user_uuid) $user_uuid = $admin->createUser('user', 'QwerZ123');

    // // присвоение роли default пользователю user
    // $admin->setRoleToUser('default', $user_uuid);

    // // удаление роли default
    // $admin->removeRole('default');

    // // удаление пользователя admin
    // $admin->removeUser($admin->getUserId('admin'));

?>