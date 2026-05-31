<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModels;
use App\Models\KategoriModels;
use App\Models\RakModels;
use CodeIgniter\HTTP\ResponseInterface;

class Buku extends BaseController
{
public function master_buku()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelBuku = new BukuModels;
            $dataBuku  = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();

            $uri   = service('uri');
            $page  = $uri->getSegment(2);

            $data['page']      = $page;
            $data['web_title'] = "Master Data Buku";
            $data['dataBuku']  = $dataBuku;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/master-data-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_buku()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelKategori = new KategoriModels();
            $modelRak      = new RakModels();
            $uri           = service('uri');
            $page          = $uri->getSegment(2);

            $data['page']          = $page;
            $data['web_title']     = "Input Data Buku";
            $data['data_kategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
            $data['data_rak']      = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/input-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function simpan_buku()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelBuku = new BukuModels();

            $judulBuku       = $this->request->getPost('judul_buku');
            $pengarang       = $this->request->getPost('pengarang');
            $penerbit        = $this->request->getPost('penerbit');
            $tahun           = $this->request->getPost('tahun');
            $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
            $kategoriBuku    = $this->request->getPost('kategori_buku');
            $keterangan      = $this->request->getPost('keterangan');
            $rak             = $this->request->getPost('rak');

            // Validasi cover buku
            if(!$this->validate([
                'cover_buku' => 'uploaded[cover_buku]|max_size[cover_buku,1024]|ext_in[cover_buku,jpg,jpeg,png]',
            ])){
                session()->setFlashdata('error', 'Format file yang diizinkan : jpg, jpeg, png dengan maksimal ukuran 1 MB');
                return redirect()->to('/admin/input-buku')->withInput();
            }

            // Validasi e-book
            if(!$this->validate([
                'e_book' => 'uploaded[e_book]|max_size[e_book,10240]|ext_in[e_book,pdf]',
            ])){
                session()->setFlashdata('error', 'Format file yang diizinkan : pdf dengan maksimal ukuran 10 MB');
                return redirect()->to('/admin/input-buku')->withInput();
            }

            // Upload cover buku
            $coverBuku  = $this->request->getFile('cover_buku');
            $ext1       = $coverBuku->getClientExtension();
            $namaFile1  = "Cover-Buku-".date("ymdHis").".".$ext1;
            $coverBuku->move('Assets/CoverBuku', $namaFile1);

            // Upload e-book
            $eBook     = $this->request->getFile('e_book');
            $ext2      = $eBook->getClientExtension();
            $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
            $eBook->move('Assets/E-Book', $namaFile2);

            // Auto number
            $hasil = $modelBuku->autoNumber()->getRowArray();
            if(!$hasil){
                $id = "BKU001";
            } else {
                $kode   = $hasil['id_buku'];
                $noUrut = (int) substr($kode, -3);
                $noUrut++;
                $id = "BKU".sprintf("%03s", $noUrut);
            }

            $dataSimpan = [
                'id_buku'          => $id,
                'judul_buku'       => ucwords($judulBuku),
                'pengarang'        => ucwords($pengarang),
                'penerbit'         => ucwords($penerbit),
                'tahun'            => $tahun,
                'jumlah_eksemplar' => $jumlahEksemplar,
                'id_kategori'      => $kategoriBuku,
                'keterangan'       => $keterangan,
                'id_rak'           => $rak,
                'cover_buku'       => $namaFile1,
                'e_book'           => $namaFile2,
                'is_delete_buku'   => '0',
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s')
            ];

            $modelBuku->saveDataBuku($dataSimpan);
            session()->setFlashdata('success', 'Data Buku Berhasil Ditambahkan!');
            ?>
            <script>document.location = "<?= base_url('admin/master-buku');?>";</script>
            <?php
        }
    }

    public function edit_buku()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $uri           = service('uri');
            $idEdit        = $uri->getSegment(3);
            $modelBuku     = new BukuModels();
            $modelKategori = new KategoriModels();
            $modelRak      = new RakModels();

            $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idEdit])->getRowArray();
            session()->set(['idUpdate' => $dataBuku['id_buku']]);

            $page = $uri->getSegment(2);

            $data['page']          = $page;
            $data['web_title']     = "Edit Data Buku";
            $data['data_buku']     = $dataBuku;
            $data['data_kategori'] = $modelKategori->getDataKategori(['is_delete_kategori' => '0'])->getResultArray();
            $data['data_rak']      = $modelRak->getDataRak(['is_delete_rak' => '0'])->getResultArray();

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterBuku/edit-buku', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

   public function update_buku()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelBuku = new BukuModels();

            $idUpdate        = session()->get('idUpdate');
            $judulBuku       = $this->request->getPost('judul_buku');
            $pengarang       = $this->request->getPost('pengarang');
            $penerbit        = $this->request->getPost('penerbit');
            $tahun           = $this->request->getPost('tahun');
            $jumlahEksemplar = $this->request->getPost('jumlah_eksemplar');
            $kategoriBuku    = $this->request->getPost('kategori_buku');
            $keterangan      = $this->request->getPost('keterangan');
            $rak             = $this->request->getPost('rak');

            $dataBukuLama = $modelBuku->getDataBuku(['id_buku' => $idUpdate])->getRowArray();

            $coverBuku = $this->request->getFile('cover_buku');
            $eBook     = $this->request->getFile('e_book');

            // Cek apakah cover buku diganti
            if($coverBuku->getError() == 4){
                // Tidak ada file baru, pakai yang lama
                $namaFile1 = $dataBukuLama['cover_buku'];
            } else {
                // Validasi file baru
                if(!$this->validate([
                    'cover_buku' => 'max_size[cover_buku,1024]|ext_in[cover_buku,jpg,jpeg,png]',
                ])){
                    session()->setFlashdata('error', 'Format cover : jpg, jpeg, png maksimal 1 MB');
                    return redirect()->back()->withInput();
                }
                // Hapus file lama
                unlink('Assets/CoverBuku/'.$dataBukuLama['cover_buku']);
                // Upload file baru
                $ext1      = $coverBuku->getClientExtension();
                $namaFile1 = "Cover-Buku-".date("ymdHis").".".$ext1;
                $coverBuku->move('Assets/CoverBuku', $namaFile1);
            }

            // Cek apakah e-book diganti
            if($eBook->getError() == 4){
                // Tidak ada file baru, pakai yang lama
                $namaFile2 = $dataBukuLama['e_book'];
            } else {
                // Validasi file baru
                if(!$this->validate([
                    'e_book' => 'max_size[e_book,10240]|ext_in[e_book,pdf]',
                ])){
                    session()->setFlashdata('error', 'Format e-book : pdf maksimal 10 MB');
                    return redirect()->back()->withInput();
                }
                // Hapus file lama
                unlink('Assets/E-Book/'.$dataBukuLama['e_book']);
                // Upload file baru
                $ext2      = $eBook->getClientExtension();
                $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
                $eBook->move('Assets/E-Book', $namaFile2);
            }

            $dataUpdate = [
                'judul_buku'       => ucwords($judulBuku),
                'pengarang'        => ucwords($pengarang),
                'penerbit'         => ucwords($penerbit),
                'tahun'            => $tahun,
                'jumlah_eksemplar' => $jumlahEksemplar,
                'id_kategori'      => $kategoriBuku,
                'keterangan'       => $keterangan,
                'id_rak'           => $rak,
                'cover_buku'       => $namaFile1,
                'e_book'           => $namaFile2,
                'updated_at'       => date('Y-m-d H:i:s')
            ];

            $whereUpdate = ['id_buku' => $idUpdate];
            $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('success', 'Data Buku Berhasil Diperbarui!');
            ?>
            <script>document.location = "<?= base_url('admin/master-buku');?>";</script>
            <?php
        }
    }

    public function hapus_buku()
    {
        $modelBuku = new BukuModels;

        $uri     = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataHapus = $modelBuku->getDataBuku(['sha1(id_buku)' => $idHapus])->getRowArray();
        
        // Cek dulu apakah file ada sebelum dihapus
        $pathCover = FCPATH.'Assets/CoverBuku/'.$dataHapus['cover_buku'];
        $pathEbook = FCPATH.'Assets/E-Book/'.$dataHapus['e_book'];

        if(!empty($dataHapus['cover_buku']) && file_exists($pathCover)){
            unlink($pathCover);
        }
        if(!empty($dataHapus['e_book']) && file_exists($pathEbook)){
            unlink($pathEbook);
        }

        $modelBuku->hapusDataBuku(['sha1(id_buku)' => $idHapus]);
        session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!');
        ?>
        <script>document.location = "<?= base_url('admin/master-buku');?>";</script>
        <?php
    }
}
