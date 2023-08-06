<?php

class UserModelFactory {
    public static function createUserModel() {
        require_once 'User_model.php';
        require_once 'UserRepository.php';

        $db = new Database();
        $userRepository = new UserRepository($db);
        return new User_model($userRepository);
    }
}
