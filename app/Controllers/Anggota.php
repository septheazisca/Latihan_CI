<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\anggotaModels;

class Anggota extends BaseController
{
    public function master_data_anggota()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelAnggota = new anggotaModels();
            $uri   = service('uri');
            $pages = $uri->getSegment(2);

            $dataAnggota = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();

            $data['pages']        = $pages;
            $data['data_anggota'] = $dataAnggota;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAnggota/master-data-anggota', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_anggota()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAnggota/input-anggota');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_anggota()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelAnggota = new anggotaModels();

            $nama        = $this->request->getPost('nama');
            $jenis       = $this->request->getPost('jenis');
            $no_tlp      = $this->request->getPost('no_tlp');
            $alamat      = $this->request->getPost('alamat');
            $email       = $this->request->getPost('email');
            // $password    = $this->request->getPost('password');
            

            $hasil = $modelAnggota->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "AGT001";
            } else {
                $kode   = $hasil['id_anggota'];
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id = "AGT" . sprintf("%03s", $noUrut);
            }

            $dataSimpan = [
                'id_anggota'       => $id,
                'nama_anggota'     => $nama,
                'jenis_kelamin'    => $jenis,
                'no_tlp'           => $no_tlp,
                'alamat'           => $alamat,
                'email'            => $email,
                'password_anggota' => password_hash('pass_anggota', PASSWORD_DEFAULT),
                'is_delete_anggota'=> '0',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s')
            ];

            $modelAnggota->saveDataAnggota($dataSimpan);
            session()->setFlashdata('success', 'Data Anggota Berhasil Ditambahkan!!');
            ?>
            <script>document.location = "<?= base_url('admin/master-data-anggota'); ?>";</script>
            <?php
        }
    }

    public function edit_data_anggota()
    {
        $modelAnggota = new anggotaModels();
        $uri     = service('uri');
        $idEdit  = $uri->getSegment(3);

        $dataAnggota = $modelAnggota->getDataAnggota(['sha1(id_anggota)' => $idEdit])->getRowArray();
        session()->set(['idUpdateAnggota' => $dataAnggota['id_anggota']]);

        $data['web_title']    = "Edit Data Anggota";
        $data['data_anggota'] = $dataAnggota;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAnggota/edit-anggota', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_anggota()
    {
        $modelAnggota = new anggotaModels();
        $idUpdate = session()->get('idUpdateAnggota');

        $nama   = $this->request->getPost('nama');
        $jenis  = $this->request->getPost('jenis');
        $no_tlp = $this->request->getPost('no_tlp');
        $alamat = $this->request->getPost('alamat');
        $email  = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $dataUpdate  = [
            'nama_anggota'  => $nama,
            'jenis_kelamin' => $jenis,
            'no_tlp'        => $no_tlp,
            'alamat'        => $alamat,
            'email'         => $email,
            'password_anggota'=> password_hash($password, PASSWORD_DEFAULT),
            'updated_at'    => date("Y-m-d H:i:s")
        ];
        $whereUpdate = ['id_anggota' => $idUpdate];

        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->remove('idUpdateAnggota');
        session()->setFlashdata('success', 'Data Anggota Berhasil Diperbaharui!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-anggota'); ?>";</script>
        <?php
    }

    public function hapus_data_anggota()
    {
        $modelAnggota = new anggotaModels();
        $uri     = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate  = ['is_delete_anggota' => '1', 'updated_at' => date("Y-m-d H:i:s")];
        $whereUpdate = ['sha1(id_anggota)' => $idHapus];

        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Anggota Berhasil Dihapus!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-anggota'); ?>";</script>
        <?php
    }
}
