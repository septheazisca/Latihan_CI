<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\adminModels;
use CodeIgniter\HTTP\ResponseInterface;
// Import Model M_Admin
use App\Models\M_Admin;

class Admin extends BaseController
{
    public function login()
    {
        return view('backend/login/login');
    }

    // public function dashboard()
    // {
    //     echo view('backend/template/header');
    //     echo view('backend/template/sidebar');
    //     echo view('backend/login/dashboard_admin');
    //     echo view('backend/template/footer');
    // }

    public function dashboard()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
<?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/Login/dashboard_admin');
            echo view('Backend/Template/footer');
        }
    }

    public function autentikasi()
    {
        $modelAdmin = new adminModels();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cekUsername = $modelAdmin->getDataAdmin([
            'username_admin' => $username,
            'is_delete_admin' => '0'
        ])->getNumRows();

        if ($cekUsername == 0) {
            session()->setFlashdata('error', 'Username Tidak Ditemukan!');
            return redirect()->back(); // Cara lebih rapi daripada menggunakan JS history.go
        } else {
            $dataUser = $modelAdmin->getDataAdmin([
                'username_admin' => $username,
                'is_delete_admin' => '0'
            ])->getRowArray();

            $passwordUser = $dataUser['password_admin'];

            if (!password_verify($password, $passwordUser)) {
                session()->setFlashdata('error', 'Password Tidak Sesuai!');
                return redirect()->back();
            } else {
                $dataSession = [
                    'ses_id'    => $dataUser['id_admin'],
                    'ses_user'  => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level'],
                    'logged_in' => true
                ];

                session()->set($dataSession);
                session()->setFlashdata('success', 'Login Berhasil!');

                return redirect()->to(base_url('admin/dashboard-admin'));
            }
        }
    }

    public function logout(){
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_level');
        session()->setFlashdata('info','Anda telah keluar dari sistem!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin');?>";
        </script>
        <?php
    }
}
