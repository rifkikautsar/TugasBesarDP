<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/rpl2-refactor/app/models/UserModelFactory.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/rpl2-refactor/app/models/BatikModelFactory.php';

class Dashboard extends Controller
{
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $data['batik'] = BatikModelFactory::createBatikModel()->getAllBatik();
        $data['sum_member'] = count(UserModelFactory::createUserModel()->getAllUser());
        if($data['user']['hakAkses']==='admin') {
            $data['sum_batik'] = count(BatikModelFactory::createBatikModel()->getAllBatik());
        } else {
            $data['sum_batik'] = count(BatikModelFactory::createBatikModel()->getBatikByUser($data['user']['id_user']));
        }
        $data['temp'] = BatikModelFactory::createBatikModel()->getPengajuanByUser($_SESSION['user_session']);
        $data['tambah'] = BatikModelFactory::createBatikModel()->getPenambahanByUser($_SESSION['user_session']);
        $data['pengajuan'] = BatikModelFactory::createBatikModel()->getPengajuan();
        $data['penambahan'] = BatikModelFactory::createBatikModel()->getPenambahan();
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/footer.sidebar');
    }
    public function member()
    {
        $data['judul'] = 'Member';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $data['member'] = UserModelFactory::createUserModel()->getAllUser();
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/member', $data);
        $this->view('templates/footer.sidebar');
    }
    public function batik()
    {
        $data['judul'] = 'Batik';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        if($data['user']['hakAkses']==='admin') {
            $data['batik'] = BatikModelFactory::createBatikModel()->getAllBatik();
        } else {
            $data['batik'] = BatikModelFactory::createBatikModel()->getBatikByUser($data['user']['id_user']);
        }
        $data['provinsi'] = BatikModelFactory::createBatikModel()->getProvinsi();
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/batik', $data);
        $this->view('templates/footer.sidebar');
    }
    public function profil()
    {
        $data['judul'] = 'Profil';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/profil', $data);
        $this->view('templates/footer.sidebar');
    }
    public function detail($id)
    {
        $data['judul'] = 'Detail Batik';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $data['batik'] = BatikModelFactory::createBatikModel()->getBatikById($id);
        $data['provinsi'] = BatikModelFactory::createBatikModel()->getProvinsi();
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/detail', $data);
        $this->view('templates/footer.sidebar');
    }
    public function detail_penambahan($id)
    {
        $data['judul'] = 'Detail Batik';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $data['batik'] = BatikModelFactory::createBatikModel()->getBatikById($id);
        $data['data_pengajuan'] = BatikModelFactory::createBatikModel()->getPengajuanBatikById($id);
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/detail_penambahan', $data);
        $this->view('templates/footer.sidebar');
    }
    public function detail_perubahan($id_temp, $id_batik)
    {
        $data['judul'] = 'Detail Batik';
        $data['user'] = UserModelFactory::createUserModel()->getSingleUser($_SESSION['user_session']);
        $data['batik'] = BatikModelFactory::createBatikModel()->getBatikById($id_batik);
        $data['data_pengajuan'] = BatikModelFactory::createBatikModel()->getPengajuanBatikById($id_temp);
        $this->view('templates/sidebar', $data);
        $this->view('dashboard/detail_perubahan', $data);
        $this->view('templates/footer.sidebar');
    }
    public function getKab(){
        echo json_encode(BatikModelFactory::createBatikModel()->getKabById($_POST['id']));
    }
    public function tambahBatik()
    {
        if (BatikModelFactory::createBatikModel()->tambahDataBatik($_POST) > 0) {
            Flasher::setFlash('Data Batik berhasil', 'ditambahkan. Jika anda member, maka data akan ditinjau oleh admin terlebih dahulu', 'success');
            header("Location: " . BASEURL . "/dashboard/batik");
            exit;
        } else {
            Flasher::setFlash('Data Batik gagal', 'ditambahkan', 'danger');
            header("Location: " . BASEURL . "/dashboard/batik");
            exit;
        }
    }
    public function hapusUser($id)
    {
        if (UserModelFactory::createUserModel()->hapusDataUser($id) > 0) {
            Flasher::setFlash('Data user berhasil', 'dihapus', 'success');
            header("Location: " . BASEURL . "/dashboard/member");
            exit;
        } else {
            Flasher::setFlash('Data user gagal', 'dihapus', 'danger');
            header("Location: " . BASEURL . "/dashboard/member");
            exit;
        }
    }
    public function logout()
    {
        $this->view('dashboard/logout');
    }
    public function ubahProfil(){
        if (UserModelFactory::createUserModel()->ubahDataUser($_POST) > 0) {
            Flasher::setFlash('Data berhasil', 'diubah', 'success');
            header("Location: " . BASEURL . "/dashboard/profil");
            exit;
        } else {
            Flasher::setFlash('Data gagal', 'diubah', 'danger');
            header("Location: " . BASEURL . "/dashboard/profil");
            exit;
        }
    }
    public function getUbahBatik(){
        echo json_encode(BatikModelFactory::createBatikModel()->getBatikById($_POST['id']));
    }
    public function pengajuanUbahBatik(){
        if($_SESSION['hakAkses']==='member'){
            if (BatikModelFactory::createBatikModel()->pengajuanUbahDataBatik($_POST) > 0) {
                Flasher::setFlash('Pengajuan perubahan', 'berhasil', 'success');
                header("Location: " . BASEURL . "/dashboard/batik");
                exit;
            } else {
                Flasher::setFlash('Pengajuan perubahan', 'gagal', 'danger');
                header("Location: " . BASEURL . "/dashboard/batik");
                exit;
            }
        }
        if($_SESSION['hakAkses']==='admin'){
            if (BatikModelFactory::createBatikModel()->ubahDataBatikAdmin($_POST) > 0) {
                Flasher::setFlash('Perubahan', 'berhasil', 'success');
                header("Location: " . BASEURL . "/dashboard/batik");
                exit;
            } else {
                Flasher::setFlash('Perubahan', 'gagal', 'danger');
                header("Location: " . BASEURL . "/dashboard/batik");
                exit;
            }
        }
    }
    public function tolakPengajuanBatikBaru($id){
        if (BatikModelFactory::createBatikModel()->tolakPengajuanDataBaru($id) > 0) {
            Flasher::setFlash('Pengajuan', 'berhasil ditolak', 'success');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        } else {
            Flasher::setFlash('Pengajuan', 'gagal ditolak', 'danger');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        }
    }
    public function setujuPengajuanBatikBaru($id){
        if (BatikModelFactory::createBatikModel()->setujuPengajuanDataBaru($id) > 0) {
            Flasher::setFlash('Pengajuan', 'berhasil disetujui', 'success');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        } else {
            Flasher::setFlash('Pengajuan', 'gagal disetujui', 'danger');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        }
    }
    public function tolakPerubahan($id){
        if (BatikModelFactory::createBatikModel()->tolakPengajuanPerubahan($id) > 0) {
            Flasher::setFlash('Pengajuan', 'berhasil ditolak', 'success');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        } else {
            Flasher::setFlash('Pengajuan', 'gagal ditolak', 'danger');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        }
    }
    public function setujuPerubahan($id){
        if (BatikModelFactory::createBatikModel()->setujuPengajuanPerubahan($id) > 0) {
            Flasher::setFlash('Pengajuan', 'berhasil disetujui', 'success');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        } else {
            Flasher::setFlash('Pengajuan', 'gagal disetujui', 'danger');
            header("Location: " . BASEURL . "/dashboard/index");
            exit;
        }
    }
    public function error($params){
        if($params==1){
            Flasher::setFlash('Anda harus login terlebih dahulu!!!','Access Denied!', 'danger');
            header("Location: " . BASEURL . "/login");
            exit;
        } else if($params==2){
            Flasher::setFlash('Hubungi administrator!','Gagal Koneksi ke Database', 'danger');
            header("Location: " . BASEURL . "/login");
            exit;
        }
    }
}