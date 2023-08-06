<?php

class BatikModelFactory {
    public static function createBatikModel() {
        require_once 'Batik_model.php';
        require_once 'BatikRepository.php';

        $db = new Database();
        $batikRepository = new BatikRepository($db);
        return new Batik_model($batikRepository);
    }
}
