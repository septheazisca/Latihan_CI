<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\adminModels;

class Auth extends BaseController
{
    public function login()
    {
        return view('Backend/Login/login');
    }

    public function dashboard()
    {
        if (
            session()->get('ses_id') == "" ||
            session()->get('ses_user') == "" ||
            session()->get('ses_level') == ""
        ) {

            session()->setFlashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {

            $db = \Config\Database::connect();

            $data['total_buku'] = $db->table('tbl_buku')
                ->where('is_delete_buku', '0')
                ->countAllResults();

            $data['total_anggota'] = $db->table('tbl_anggota')
                ->where('is_delete_anggota', '0')
                ->countAllResults();

            $data['total_peminjaman'] = $db->table('tbl_peminjaman')
                ->countAllResults();

            $data['peminjaman_berjalan'] = $db->table('tbl_peminjaman')
                ->where('status_transaksi', 'Berjalan')
                ->countAllResults();

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Login/dashboard_admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function autentikasi()
    {
        $modelAdmin = new adminModels();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cekUsername = $modelAdmin->getDataAdmin([
            'username_admin'  => $username,
            'is_delete_admin' => '0'
        ])->getNumRows();

        if ($cekUsername == 0) {
            session()->setFlashdata('error', 'Username Tidak Ditemukan!');
        ?>
            <script>
                history.go(-1);
            </script>
            <?php
        } else {
            $dataUser = $modelAdmin->getDataAdmin([
                'username_admin'  => $username,
                'is_delete_admin' => '0'
            ])->getRowArray();

            $passwordUser = $dataUser['password_admin'];

            $verifikasiPassword = password_verify($password, $passwordUser);

            if (!$verifikasiPassword) {
                session()->setFlashdata('error', 'Password Tidak Sesuai!');
            ?>
                <script>
                    history.go(-1);
                </script>
            <?php
            } else {
                $dataSession = [
                    'ses_id'    => $dataUser['id_admin'],
                    'ses_user'  => $dataUser['nama_admin'],
                    'ses_level' => $dataUser['akses_level']
                ];
                session()->set($dataSession);
                session()->setFlashdata('success', 'Login Berhasil!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/dashboard-admin'); ?>";
                </script>
        <?php
            }
        }
    }

    public function logout()
    {
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_level');
        session()->setFlashdata('info', 'Anda telah keluar dari sistem!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin'); ?>";
        </script>
<?php
    }
}
