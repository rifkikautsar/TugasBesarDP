<?php

require_once 'UserRepository.php';

class User_model {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getAllUser() {
        return $this->userRepository->getAllUsers();
    }

    public function loginUser($data) {
        return $this->userRepository->loginUser($data);
    }

    public function getSingleUser($id) {
        return $this->userRepository->getSingleUser($id);
    }

    public function tambahDataUser($data) {
        return $this->userRepository->tambahDataUser($data);
    }

    public function hapusDataUser($id) {
        return $this->userRepository->hapusDataUser($id);
    }

    public function ubahDataUser($data) {
        return $this->userRepository->ubahDataUser($data);
    }
}