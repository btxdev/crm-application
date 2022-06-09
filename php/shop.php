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

    if($decoded['op'] == 'get_cats_items') {

        $rows = $db->fetchAll('SELECT * FROM `items_categories`');

        $output_cats = [];

        foreach($rows as $row) {
            $item = $row['item_id'];
            $category = $row['category_id'];

            // get category data
            $cat_data = $db->fetch('SELECT * FROM `categories` WHERE `category_id` = :id', [':id' => $category]);
            // get items data
            $item_data = $db->fetch('SELECT * FROM `items` WHERE `item_id` = :id', [':id' => $item]);

            $output_cats[$category][$item] = [
                'cat_data' => $cat_data,
                'item_data' => $item_data
            ];

            // var_dump($item_data);
            // var_dump($cat_data);

            // $cat_data['item_data'] = $item_data;
            // array_push($output_cats, $cat_data);
        }

        exit(json_encode($output_cats));

    }

    // добавление товара в корзину
    if($decoded['op'] == 'add_item_to_basket') {

        $id = $decoded['id'];
        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        // check if user has order
        $order = $db->fetch(
            "SELECT * FROM `users_orders` INNER JOIN `orders`
             WHERE orders.status = 'basket'
            AND users_orders.uuid = :uuid
            AND orders.order_id = users_orders.order_id
            ", 
            [
                ':uuid' => $uuid
            ]
        );

        if($order == false) {

            // $sql = 'INSERT INTO `orders` (`status`) VALUES (`wait`);';
            // $stmt = $db->instance->prepare($sql);
            // $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // $order = $stmt

            $db->fetch(
                'INSERT INTO `orders` (`status`, `order_date`) VALUES ("basket", :order_date);',
                [
                    ':order_date' => date('Y-m-d')
                ]
            );
            $order = $db->instance->lastInsertId();
            // $order = $db->fetch('SELECT `order_id` FROM `orders` WHERE `uuid`');
            $db->fetch(
                'INSERT INTO `users_orders` (`uuid`, `order_id`) 
                VALUES (:uuid, :order_id)',
                [
                    ':uuid' => $uuid,
                    ':order_id' => $order
                ]
            );
        }
        else {
            $order = $order['order_id'];
        }

        // add item to order
        $db->fetch(
            'INSERT INTO `orders_items` (`order_id`, `item_id`) 
            VALUES (:order_id, :item_id)',
            [
                ':order_id' => $order,
                ':item_id' => $id
            ]
        );

        $result = new Status('OK');
        exit($result->json());

    }

    // удаление товара из корзины
    if($decoded['op'] == 'remove_item_from_basket') {

        $id = $decoded['id'];
        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        // check if user has order
        $order = $db->fetch(
            "SELECT * FROM `users_orders` INNER JOIN `orders`
             WHERE orders.status = 'basket'
            AND users_orders.uuid = :uuid
            AND orders.order_id = users_orders.order_id
            ", 
            [
                ':uuid' => $uuid
            ]
        );

        if($order == false) {
            exit(empty_json());
        }
        else {
            $order = $order['order_id'];
        }

        // remove item
        $db->fetch(
            'DELETE FROM `orders_items` 
            WHERE `order_id` = :order_id
            AND `item_id` = :item_id
            ',
            [
                ':order_id' => $order,
                ':item_id' => $id
            ]
        );

        $result = new Status('OK');
        exit($result->json());

    }

    // стоимость корзины
    if($decoded['op'] == 'get_basket_price') {

        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        // получить id заказа пользователя
        $order = $db->fetch(
            "SELECT users_orders.order_id 
            FROM `users_orders` INNER JOIN `orders`
            WHERE orders.status = 'basket'
            AND users_orders.uuid = :uuid
            AND orders.order_id = users_orders.order_id
            ", 
            [
                ':uuid' => $uuid
            ]
        );
        if($order == false) {
            $data = [
                'price' => 0
            ];
            $result = new Status('OK', ['msg' => $data]);
            exit($result->json());
        }
        $order = $order['order_id'];

        // получить список товаров в заказе
        $items_ids = $db->fetchAll('SELECT `item_id` FROM `orders_items` WHERE `order_id` = :order_id', [':order_id' => $order]);

        // получить каждый товар и сложить цены
        $total_price = 0;
        foreach($items_ids as $item_id) {
            $item_id = $item_id['item_id'];
            $price = $db->fetch('SELECT `price` FROM `items` WHERE `item_id` = :item_id', [':item_id' => $item_id]);
            $price = intval($price['price']);
            $total_price += $price;
        }

        $data = [
            'price' => $total_price
        ];
        $result = new Status('OK', ['msg' => $data]);
        exit($result->json());

    }

    // список товаров в корзине
    if($decoded['op'] == 'get_basket_items') {

        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        // получить id заказа пользователя
        $order = $db->fetch(
            "SELECT users_orders.order_id 
            FROM `users_orders` INNER JOIN `orders`
            WHERE orders.status = 'basket'
            AND users_orders.uuid = :uuid
            AND orders.order_id = users_orders.order_id
            ", 
            [
                ':uuid' => $uuid
            ]
        );
        if($order == false) {
            $result = new Status('OK', ['price' => 0]);
            exit($result->json());
        }
        $order = $order['order_id'];

        // получить список товаров в заказе
        $items_ids = $db->fetchAll('SELECT * FROM `orders_items` WHERE `order_id` = :order_id', [':order_id' => $order]);
        $items = [];

        foreach($items_ids as $item_id) {
            $item_id = $item_id['item_id'];
            $item_data = $db->fetch('SELECT * FROM `items` WHERE `item_id` = :item_id', [':item_id' => $item_id]);
            array_push($items, $item_data);
        }

        $data = json_encode([
            'status' => 'OK',
            'items' => $items
        ]);
        exit($data);

    }

    // список заказов
    if($decoded['op'] == 'get_orders') {

        $str_limit = 100;

        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        $orders = $db->fetchAll("SELECT * FROM `users_orders` INNER JOIN `orders` WHERE `uuid` = :uuid AND users_orders.order_id = orders.order_id",
            [
                ':uuid' => $uuid
            ]
        );

        $data = [];
        foreach($orders as $order) {
            if($order['status'] == 'basket') continue;
            $obj = [];
            $obj['id'] = $order['order_id'];
            $obj['description'] = 'Заказ был сформирован '.$order['order_date'].'. Товары в заказе: ';
            $obj['status'] = $order['status'];
            $obj['price'] = 0;
            // get items in order
            $items = $db->fetchAll('SELECT * FROM `orders_items` INNER JOIN `items` WHERE `order_id` = :order_id AND items.item_id = orders_items.item_id', [':order_id' => $order['order_id']]);
            foreach($items as $item) {
                $obj['price'] += intval($item['price']);
                $obj['description'] .= $item['title'].', ';
            }
            $obj['description'] = mb_substr($obj['description'], 0, -2);
            if(mb_strlen($obj['description']) >= $str_limit) {
                $obj['description'] = mb_substr($obj['description'], 0, $str_limit).'...';
            }

            array_push($data, $obj);
        }

        //$result = new Status('OK', [$data]);
        //exit($result->json());
        exit(json_encode([
            'status' => 'OK',
            'data' => $data
        ]));
    }

    // отправка заказа
    if($decoded['op'] == 'finish_basket') {

        $hash = $access->getSessionCookie($settings->get('session_name'));
        $uuid = $access->getUserIdBySessionHash($hash);

        // получить id заказа пользователя
        $order = $db->fetch(
            "SELECT users_orders.order_id 
            FROM `users_orders` INNER JOIN `orders`
            WHERE orders.status = 'basket'
            AND users_orders.uuid = :uuid
            AND orders.order_id = users_orders.order_id
            ", 
            [
                ':uuid' => $uuid
            ]
        );

        if($order == false) {
            $result = new Status('OK', ['price' => 0]);
            exit($result->json());
        }
        $order = $order['order_id'];

        // сменить состояние
        $db->run(
            "UPDATE `orders` 
            SET `status` = 'wait' 
            WHERE `order_id` = :order_id
            ",
            [
                ':order_id' => $order
            ]
        );

        $result = new Status('OK');
        exit($result->json());

    }


}





?>