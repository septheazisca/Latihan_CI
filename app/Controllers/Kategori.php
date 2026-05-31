<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\kategoriModels;

class Kategori extends BaseController
{
    public function master_data_kategori()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelKategori = new kategoriModels();
            $uri   = service('uri');
            $pages = $uri->getSegment(2);

            $dataKategori = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();

            $data['pages']         = $pages;
            $data['data_kategori'] = $dataKategori;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterKategori/master-data-kategori', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_kategori()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterKategori/input-kategori');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_kategori()
    {
        if (session()->get('ses_id') == "" or session()->get('ses_user') == "" or session()->get('ses_level') == "") {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin'); ?>";</script>
            <?php
        } else {
            $modelKategori = new kategoriModels();
            $nama          = $this->request->getPost('nama');

            $hasil = $modelKategori->autoNumber()->getRowArray();
            if (!$hasil) {
                $id = "KAT001";
            } else {
                $kode   = $hasil['id_kategori'];
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id = "KAT" . sprintf("%03s", $noUrut);
            }

            $dataSimpan = [
                'id_kategori'        => $id,
                'nama_kategori'      => $nama,
                'is_delete_kategori' => '0',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            $modelKategori->saveDataKategori($dataSimpan);
            session()->setFlashdata('success', 'Data Kategori Berhasil Ditambahkan!!');
            ?>
            <script>document.location = "<?= base_url('admin/master-data-kategori'); ?>";</script>
            <?php
        }
    }

    public function edit_data_kategori()
    {
        $modelKategori = new kategoriModels();
        $uri    = service('uri');
        $idEdit = $uri->getSegment(3);

        $dataKategori = $modelKategori->getDataKategori(['sha1(id_kategori)' => $idEdit])->getRowArray();
        session()->set(['idUpdateKategori' => $dataKategori['id_kategori']]);

        $data['web_title']     = "Edit Data Kategori";
        $data['data_kategori'] = $dataKategori;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/edit-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_kategori()
    {
        $modelKategori = new kategoriModels();
        $idUpdate      = session()->get('idUpdateKategori');
        $nama          = $this->request->getPost('nama');

        $dataUpdate  = ['nama_kategori' => $nama, 'updated_at' => date("Y-m-d H:i:s")];
        $whereUpdate = ['id_kategori' => $idUpdate];

        $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);
        session()->remove('idUpdateKategori');
        session()->setFlashdata('success', 'Data Kategori Berhasil Diperbaharui!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-kategori'); ?>";</script>
        <?php
    }

    public function hapus_data_kategori()
    {
        $modelKategori = new kategoriModels();
        $uri     = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate  = ['is_delete_kategori' => '1', 'updated_at' => date("Y-m-d H:i:s")];
        $whereUpdate = ['sha1(id_kategori)' => $idHapus];

        $modelKategori->updateDataKategori($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Kategori Berhasil Dihapus!');
        ?>
        <script>document.location = "<?= base_url('admin/master-data-kategori'); ?>";</script>
        <?php
    }
}
