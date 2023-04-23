<?php
if (!empty($_GET['id']) && !empty($_GET['source'])) {
    require "../../tv.class.php";
    $tv = new Tv();
    $data = $tv->episodes($_GET['id'], $_GET['source']);
    echo json_encode($data);
}
