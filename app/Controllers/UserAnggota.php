<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\anggotaModels;
use App\Models\BukuModels;
use CodeIgniter\HTTP\ResponseInterface;

class UserAnggota extends BaseController
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function login()
    {
        // kalau sudah login, langsung ke dashboard
        if (session()->get('login_anggota')) {
            return redirect()->to('/anggota/dashboard');
        }
        return view('Frontend/login_anggota');
    }
    public function autentikasi()
    {
        $model = new anggotaModels();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // validasi sederhana
        if ($email == '' || $password == '') {
            session()->setFlashdata('error', 'Email dan password wajib diisi!');
            return redirect()->back();
        }
        $user = $model->where('email', $email)
            ->where('is_delete_anggota', '0')
            ->first();
        // cek user + password
        if ($user && password_verify($password, $user['password_anggota'])) {
            session()->set([
                'id_anggota' => $user['id_anggota'],
                'nama_anggota' => $user['nama_anggota'],
                'email_anggota' => $user['email'],
                'no_tlp' => $user['no_tlp'],
                'alamat' => $user['alamat'],
                'login_anggota' => true
            ]);
            session()->setFlashdata('success', 'Login berhasil!');
            return redirect()->to('/anggota/dashboard');
        }
        session()->setFlashdata('error', 'Email atau password salah!');
        return redirect()->back();
    }
    public function dashboard()
    {
        if (!session()->get('login_anggota')) {
            return redirect()->to('/anggota/login');
        }
        $modelBuku = new BukuModels();
        // ambil data buku aktif
        $dataBuku = $modelBuku
            ->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])
            ->getResultArray();
        // hitung total
        $totalBuku = count($dataBuku);
        // hitung ebook
        $totalEbook = 0;
        foreach ($dataBuku as $b) {
            if (!empty($b['e_book'])) {
                $totalEbook++;
            }
        }
        $data = [
            'nama' => session()->get('nama_anggota'),
            'total_buku' => $totalBuku,
            'ebook' => $totalEbook,
            // sementara dummy (nanti kalau ada tabel peminjaman baru hidup)
            'pinjam' => 0,
            'kembali' => 0,
            // ambil 10 buku terbaru
            'buku' => array_slice($dataBuku, 0, 10)
        ];
        return view('Frontend/Template/header_anggota')
            . view('Frontend/Template/sidebar_anggota')
            . view('Frontend/dashboard_anggota', $data)
            . view('Frontend/Template/footer_anggota');
    }
    public function daftar_buku()
    {
        if (!session()->get('login_anggota')) {
            return redirect()->to('/anggota/login');
        }
        $modelBuku = new BukuModels();
        $data = [
            'nama' => session()->get('nama_anggota'),
            'buku' => $modelBuku
                ->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])
                ->getResultArray()
        ];
        return view('Frontend/Template/header_anggota')
            . view('Frontend/Template/sidebar_anggota')
            . view('Frontend/daftar_buku', $data)
            . view('Frontend/Template/footer_anggota');
    }
    public function profile()
    {
        return view('Frontend/Template/header_anggota')
            . view('Frontend/Template/sidebar_anggota')
            . view('Frontend/profile_anggota')
            . view('Frontend/Template/footer_anggota');
    }
    public function settings()
    {
        return view('Frontend/Template/header_anggota')
            . view('Frontend/Template/sidebar_anggota')
            . view('Frontend/settings_anggota')
            . view('Frontend/Template/footer_anggota');
    }
    public function update_profile()
    {
        $db = \Config\Database::connect();
        $id = session()->get('id_anggota');
        $data = [
            'nama_anggota' => $this->request->getPost('nama_anggota'),
            'email' => $this->request->getPost('email'),
            'no_tlp' => $this->request->getPost('no_tlp'),
            'alamat' => $this->request->getPost('alamat'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $db->table('tbl_anggota')
            ->where('id_anggota', $id)
            ->update($data);
        // update session juga
        session()->set([
            'nama_anggota' => $data['nama_anggota'],
            'email_anggota' => $data['email'],
            'no_tlp' => $data['no_tlp'],
            'alamat' => $data['alamat']
        ]);
        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }
    public function update_password()
    {
        $db = \Config\Database::connect();
        $old = $this->request->getPost('old_password');
        $new = $this->request->getPost('new_password');
        $confirm = $this->request->getPost('confirm_password');
        if ($new != $confirm) {
            return redirect()->back()->with('error', 'Password tidak cocok');
        }
        $id = session()->get('id_anggota');
        $cek = $db->table('tbl_anggota')
            ->where('id_anggota', $id)
            ->get()
            ->getRowArray();
        if (!password_verify($old, $cek['password_anggota'])) {
            return redirect()->back()->with('error', 'Password lama salah');
        }
        $db->table('tbl_anggota')
            ->where('id_anggota', $id)
            ->update([
                'password_anggota' => password_hash($new, PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Password berhasil diupdate');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/anggota/login');
    }
}
