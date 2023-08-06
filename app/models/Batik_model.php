<?php

require_once 'BatikRepository.php';

class Batik_model {
    private $batikRepository;

    public function __construct(BatikRepository $batikRepository) {
        $this->batikRepository = $batikRepository;
    }

    public function getAllBatik() {
        return $this->batikRepository->getAllBatik();
    }

    public function getCariDataBatik() {
        return $this->batikRepository->getCariDataBatik();
    }
    
    public function getBatikById($id) {
        return $this->batikRepository->getBatikById($id);
    }

    public function getBatikByUser($id) {
        return $this->batikRepository->getBatikByUser($id);
    }

    public function getProvinsi() {
        return $this->batikRepository->getProvinsi();
    }

    public function tambahDataBatik($data) {
        return $this->batikRepository->tambahDataBatik($data);
    }

    public function getKabById($id) {
        return $this->batikRepository->getKabById($id);
    }

    public function ubahDataBatikAdmin($data) {
        return $this->batikRepository->ubahDataBatikAdmin($data);
    }

    public function pengajuanUbahDataBatik($data) {
        return $this->batikRepository->pengajuanUbahDataBatik($data);
    }

    public function getPengajuanByUser($id) {
        return $this->batikRepository->getPengajuanByUser($id);
    }

    public function getPenambahanByUser($id) {
        return $this->batikRepository->getPenambahanByUser($id);
    }

    public function getPenambahan() {
        return $this->batikRepository->getPenambahan();
    }

    public function getPengajuan() {
        return $this->batikRepository->getPengajuan();
    }

    public function tolakPengajuanDataBaru($id) {
        return $this->batikRepository->tolakPengajuanDataBaru($id);
    }

    public function setujuPengajuanDataBaru($id) {
        return $this->batikRepository->setujuPengajuanDataBaru($id);
    }

    public function getPengajuanBatikById($id) {
        return $this->batikRepository->getPengajuanBatikById($id);
    }

    public function tolakPengajuanPerubahan($id) {
        return $this->batikRepository->tolakPengajuanPerubahan($id);
    }

    public function setujuPengajuanPerubahan($id) {
        return $this->batikRepository->setujuPengajuanPerubahan($id);
    }
}