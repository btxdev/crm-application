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

}





?>