<?php

class UserRepository {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $this->db->query("SELECT * FROM user");
        return $this->db->resultSet();
    }

    public function loginUser($data){
        $query = "SELECT * FROM user WHERE email=:email";
        $this->db->query($query);
        $this->db->bind('email',$data['email']);

        $this->db->execute();
        $dt = $this->db->single();

        if($this->db->rowCount()>0){
            if (password_verify($data['password'], $dt['password'])) {
                $_SESSION["user_session"] = $dt["id_user"];
                $_SESSION["nama"] = $dt["nama"];
                $_SESSION["hakAkses"] = $dt["hakAkses"];
                $_SESSION["email"] = $dt["email"];
                $_SESSION["tgl_lahir"] = $dt["tgl_lahir"];
                $_SESSION["jk"] = $dt["jk"];
                $_SESSION["password"] = $data['password'];
                header("Location: ".BASEURL."/dashboard/index");
            } else return FALSE;
        }
        return $this->db->rowCount();
    }

    public function getSingleUser($id){
        $query = "SELECT * from user where id_user=:id_user";
        $this->db->query($query);
        $this->db->bind('id_user',$id);

        $this->db->execute();
        return $this->db->single();
    }

    public function tambahDataUser($data){
        $hashPasswd = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "SELECT email from user where email=:email";
        $this->db->query($query);
        $this->db->bind('email',$data['email']);
        $this->db->execute();
        if($this->db->single()>0){
            return FALSE;
        }else {
            $query = "INSERT INTO user VALUES ('',:nama,:email,:password,:hakAkses,:tgl_lahir,:jk,'')";
            $this->db->query($query);
            $this->db->bind('nama',$data['nama']);
            $this->db->bind('email',$data['email']);
            $this->db->bind('password',$hashPasswd);
            $this->db->bind('hakAkses','member');
            $this->db->bind('tgl_lahir',$data['tgl_lahir']);
            $this->db->bind('jk',$data['jk']);
    
            $this->db->execute();
            return $this->db->rowCount();
        }
    }

    public function hapusDataUser($id){
        $query = "DELETE FROM user where id_user=:id";
        $this->db->query($query);
        $this->db->bind('id',$id);

        $this->db->execute();
        return $this->db->rowCount();
    }
    public function ubahDataUser($data){
        $query = "SELECT profil from user where id_user=:id_user";
        $this->db->query($query);
        $this->db->bind('id_user',$data['id_user']);
        $this->db->execute();
        $foto = $this->db->single();
        $namaFile = $_FILES['ubah-gambar']['name'];
        if($namaFile!=""){
            if(file_exists($_SERVER["DOCUMENT_ROOT"]."/rpl2/public/img/".$foto['profil'])){
                unlink($_SERVER["DOCUMENT_ROOT"]."/rpl2/public/img/".$foto['profil']);
            }
            $x = explode('.', $namaFile);
            $ekstensi = strtolower(end($x));
            $ekstensiYangDibolehkan = [
                'image/png',
                'image/jpg',
                'image/jpeg',
                'image/webp'
            ];
            $ukuranFile = $_FILES['ubah-gambar']['size'];
            $error = $_FILES['ubah-gambar']['error'];
            $tmpName = $_FILES['ubah-gambar']['tmp_name'];
                if (!in_array(mime_content_type($tmpName), $ekstensiYangDibolehkan)) {
                    echo "
                    <script>
                    alert('File tidak sesuai!');
                    document.location.href = '".BASEURL."/dashboard/profil';
                    </script>";
                }else if($ukuranFile > 1000 * 10000){
                    echo "
                    <script>
                    alert('File terlalu besar!');
                    document.location.href = '".BASEURL."/dashboard/profil';
                    </script>";
                }
                else {
                $file = $data['id_user'].".".$ekstensi;
                move_uploaded_file($tmpName,$_SERVER["DOCUMENT_ROOT"]."/rpl2/public/img/".$file);
                }
                $query = "UPDATE user set nama=:nama, email=:email, tgl_lahir=:tgl_lahir, jk=:jk, profil=:profil where id_user=:id_user";
                $this->db->query($query);
                $this->db->bind('nama',$data['nama']);
                $this->db->bind('email',$data['email']);
                $this->db->bind('tgl_lahir',$data['tgl_lahir']);
                $this->db->bind('jk',$data['jk']);
                $this->db->bind('profil',$file);
                $this->db->bind('id_user',$data['id_user']);
        
                $this->db->execute();
                return $this->db->rowCount();
            } else {
                $query = "UPDATE user set nama=:nama, email=:email, tgl_lahir=:tgl_lahir, jk=:jk where id_user=:id_user";
                $this->db->query($query);
                $this->db->bind('nama',$data['nama']);
                $this->db->bind('email',$data['email']);
                $this->db->bind('tgl_lahir',$data['tgl_lahir']);
                $this->db->bind('jk',$data['jk']);
                $this->db->bind('id_user',$data['id_user']);
        
                $this->db->execute();
                return $this->db->rowCount();
            }
    }
}
