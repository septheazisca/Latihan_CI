<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\rakModels;

class Rak extends BaseController
{

    public function master_data_rak()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelRak = new rakModels();
            $uri   = service('uri');
            $pages = $uri->getSegment(2);

            $dataRak = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            $data['pages']    = $pages;
            $data['data_rak'] = $dataRak;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterRak/master-data-rak', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_rak()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterRak/input-rak');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_rak()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelRak = new rakModels();
            $nama     = $this->request->getPost('nama');

            $hasil = $modelRak->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "RAK001";
            } else {
                $kode   = $hasil['id_rak'];
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id = "RAK" . sprintf("%03s", $noUrut);
            }

            $dataSimpan = [
                'id_rak'        => $id,
                'nama_rak'      => $nama,
                'is_delete_rak' => '0',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            $modelRak->saveDataRak($dataSimpan);
            session()->setFlashdata('success', 'Data Rak Berhasil Ditambahkan!!');
            ?>
            <script>document.location = "<?= base_url('admin/master-data-rak'); ?>";</script>
            <?php
        }
    }

    public function edit_data_rak()
    {
        $modelRak = new rakModels();
        $uri    = service('uri');
        $idEdit = $uri->getSegment(3);

        $dataRak = $modelRak->getDataRak(['sha1(id_rak)' => $idEdit])->getRowArray();
        session()->set(['idUpdateRak' => $dataRak['id_rak']]);

        $data['web_title'] = "Edit Data Rak";
        $data['data_rak']  = $dataRak;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterRak/edit-rak', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_rak()
    {
        $modelRak = new rakModels();
        $idUpdate = session()->get('idUpdateRak');
        $nama     = $this->request->getPost('nama');

        $dataUpdate  = ['nama_rak' => $nama, 'updated_at' => date("Y-m-d H:i:s")];
        $whereUpdate = ['id_rak' => $idUpdate];

        $modelRak->updateDataRak($dataUpdate, $whereUpdate);
        session()->remove('idUpdateRak');
        session()->setFlashdata('success', 'Data Rak Berhasil Diperbaharui!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-rak'); ?>";</script>
        <?php
    }

    public function hapus_data_rak()
    {
        $modelRak = new rakModels();
        $uri     = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate  = ['is_delete_rak' => '1', 'updated_at' => date("Y-m-d H:i:s")];
        $whereUpdate = ['sha1(id_rak)' => $idHapus];

        $modelRak->updateDataRak($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Rak Berhasil Dihapus!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-rak'); ?>";</script>
        <?php
    }
}
