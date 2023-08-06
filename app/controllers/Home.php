<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/rpl2-refactor/app/models/BatikModelFactory.php';

class Home extends Controller{
    public function index(){
        $data['judul'] = 'Home';
        $data['batik'] = BatikModelFactory::createBatikModel()->getAllBatik();
        $this->view('templates/header',$data);
        $this->view('home/index',$data);
        $this->view('templates/footer');
    }
    public function detail($id){
        $data['judul'] = 'Detail Batik';
        $data['batik'] = BatikModelFactory::createBatikModel()->getBatikById($id);
        $this->view('templates/header',$data);
        $this->view('home/detail',$data);
        $this->view('templates/footer');
    }
    public function cari(){
        $data['judul'] = 'Home';
        $data['batik'] = BatikModelFactory::createBatikModel()->getCariDataBatik();
        $this->view('templates/header',$data);
        $this->view('home/index',$data);
        $this->view('templates/footer');
    }
}