<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\adminModels;
use App\Models\anggotaModels;
use App\Models\rakModels;
use App\Models\KategoriModels;
use App\Models\BukuModels;
use App\Models\PeminjamanModels;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Color\Color;

class Admin extends BaseController
{
    public function login()
    {
        return view('Backend/Login/login');
    }

    public function dashboard()
    {
        if (
            session()->get('ses_id') == "" or
            session()->get('ses_user') == "" or
            session()->get('ses_level') == ""
        ) {
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

    // ===================== CRUD MODULE ADMIN =====================

    public function master_data_admin()
    {
        if (
            session()->get('ses_id') == "" or
            session()->get('ses_user') == "" or
            session()->get('ses_level') == ""
        ) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {
            $modelAdmin = new adminModels();

            $uri   = service('uri');
            $pages = $uri->getSegment(2);

            $dataUser = $modelAdmin->getDataAdmin([
                'is_delete_admin' => '0',
                'akses_level !='  => '1'
            ])->getResultArray();

            $data['pages']     = $pages;
            $data['data_user'] = $dataUser;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/master-data-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function input_data_admin()
    {
        if (
            session()->get('ses_id') == "" or
            session()->get('ses_user') == "" or
            session()->get('ses_level') == ""
        ) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
        <?php
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAdmin/input-admin');
            echo view('Backend/Template/footer');
        }
    }

    public function simpan_data_admin()
    {
        if (
            session()->get('ses_id') == "" or
            session()->get('ses_user') == "" or
            session()->get('ses_level') == ""
        ) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
        ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
            <?php
        } else {
            $modelAdmin = new adminModels();

            $nama     = $this->request->getPost('nama');
            $username = $this->request->getPost('username');
            $level    = $this->request->getPost('level');

            $cekUname = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
            if ($cekUname > 0) {
                session()->setFlashdata('error', 'Username sudah digunakan!!');
            ?>
                <script>
                    history.go(-1);
                </script>
            <?php
            } else {
                $hasil = $modelAdmin->autoNumber()->getRowArray();
                if (!$hasil) {
                    $id = "ADM001";
                } else {
                    $kode   = $hasil['id_admin'];
                    $noUrut = (int) substr($kode, -3);
                    $noUrut++;
                    $id = "ADM" . sprintf("%03s", $noUrut);
                }

                $dataSimpan = [
                    'id_admin'        => $id,
                    'nama_admin'      => $nama,
                    'username_admin'  => $username,
                    'password_admin'  => password_hash('pass_admin', PASSWORD_DEFAULT),
                    'akses_level'     => $level,
                    'is_delete_admin' => '0',
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s')
                ];

                $modelAdmin->saveDataAdmin($dataSimpan);
                session()->setFlashdata('success', 'Data Admin Berhasil Ditambahkan!!');
            ?>
                <script>
                    document.location = "<?= base_url('admin/master-data-admin'); ?>";
                </script>
            <?php
            }
        }
    }

    public function edit_data_admin()
    {
        $modelAdmin = new adminModels();

        $uri    = service('uri');
        $idEdit = $uri->getSegment(3);

        $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();

        session()->set(['idUpdate' => $dataAdmin['id_admin']]);

        $page = $uri->getSegment(2);

        $data['page']       = $page;
        $data['web_title']  = "Edit Data Admin";
        $data['data_admin'] = $dataAdmin;

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterAdmin/edit-admin', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function update_data_admin()
    {
        $modelAdmin = new adminModels();

        $idUpdate = session()->get('idUpdate');
        $nama     = $this->request->getPost('nama');
        $level    = $this->request->getPost('level');

        if ($nama == "" or $level == "") {
            session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
            ?>
            <script>
                history.go(-1);
            </script>
        <?php
        } else {
            $dataUpdate = [
                'nama_admin'  => $nama,
                'akses_level' => $level,
                'updated_at'  => date("Y-m-d H:i:s")
            ];

            $whereUpdate = ['id_admin' => $idUpdate];

            $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
            session()->remove('idUpdate');
            session()->setFlashdata('success', 'Data Admin Berhasil Diperbaharui!');
        ?>
            <script>
                document.location = "<?= base_url('admin/master-data-admin'); ?>";
            </script>
        <?php
        }
    }

    public function hapus_data_admin()
    {
        $modelAdmin = new adminModels();

        $uri     = service('uri');
        $idHapus = $uri->getSegment(3);

        $dataUpdate = [
            'is_delete_admin' => '1',
            'updated_at'      => date("Y-m-d H:i:s")
        ];

        $whereUpdate = ['sha1(id_admin)' => $idHapus];

        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->setFlashdata('success', 'Data Admin Berhasil Dihapus!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-data-admin'); ?>";
        </script>
        <?php
    }


    // ===================== CRUD MODULE ANGGOTA =====================

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
            $password    = $this->request->getPost('password');

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
                'password_anggota' => password_hash($password, PASSWORD_DEFAULT),
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

        $dataUpdate  = [
            'nama_anggota'  => $nama,
            'jenis_kelamin' => $jenis,
            'no_tlp'        => $no_tlp,
            'alamat'        => $alamat,
            'email'         => $email,
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


    // ===================== CRUD MODULE RAK =====================

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


    // ===================== CRUD MODULE KATEGORI =====================

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


    // ===================== CRUD MODULE BUKU =====================

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
            $coverBuku->move(FCPATH.'Assets/CoverBuku', $namaFile1);

            // Upload e-book
            $eBook     = $this->request->getFile('e_book');
            $ext2      = $eBook->getClientExtension();
            $namaFile2 = "E-Book-".date("ymdHis").".".$ext2;
            $eBook->move(FCPATH.'Assets/E-Book', $namaFile2);

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
                $coverBuku->move(FCPATH.'Assets/CoverBuku', $namaFile1);
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
                $eBook->move(FCPATH.'Assets/E-Book', $namaFile2);
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
        
        $pathCover = FCPATH.'Assets/CoverBuku/'.$dataHapus['cover_buku'];
        $pathEbook = FCPATH.'Assets/E-Book/'.$dataHapus['e_book'];

        if(file_exists($pathCover)){
            unlink($pathCover);
        }
        if(file_exists($pathEbook)){
            unlink($pathEbook);
        }

        $modelBuku->hapusDataBuku(['sha1(id_buku)' => $idHapus]);
        session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!');
        ?>
        <script>document.location = "<?= base_url('admin/master-buku');?>";</script>
        <?php
    }

    
    // ===================== TRANSAKSI PEMINJAMAN =====================

    public function data_transaksi_peminjaman()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelPeminjaman = new PeminjamanModels();
            $dataPeminjaman  = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray();

            $uri  = service('uri');
            $page = $uri->getSegment(2);

            $data['page']            = $page;
            $data['web_title']       = "Data Transaksi Peminjaman";
            $data['dataPeminjaman']  = $dataPeminjaman;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Transaksi/data-transaksi-peminjaman', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function peminjaman_step1()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $uri  = service('uri');
            $page = $uri->getSegment(2);

            $data['page']      = $page;
            $data['web_title'] = "Transaksi Peminjaman";

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Transaksi/peminjaman-step-1', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function peminjaman_step2()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelAnggota    = new anggotaModels();
            $modelBuku       = new BukuModels();
            $modelPeminjaman = new PeminjamanModels();
            $uri             = service('uri');
            $page            = $uri->getSegment(2);

            if($this->request->getPost('id_anggota')){
                $idAnggota = $this->request->getPost('id_anggota');
                session()->set(['idAgt' => $idAnggota]);
            } else {
                $idAnggota = session()->get('idAgt');
            }

            $cekPeminjaman = $modelPeminjaman->getDataPeminjaman(['id_anggota' => $idAnggota, 'status_transaksi' => 'Berjalan'])->getNumRows();
            if($cekPeminjaman > 0){
                session()->setFlashdata('error','Transaksi Tidak Dapat Dilakukan, Masih Ada Transaksi Peminjaman yang Belum Diselesaikan!!');
                ?>
                <script>history.go(-1);</script>
                <?php
            } else {
                $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();
                $dataBuku = $modelBuku->getDataBukuJoin(['tbl_buku.is_delete_buku' => '0'])->getResultArray();

                $jumlahTemp  = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();
                $dataTemp    = $modelPeminjaman->getDataTempJoin(['tbl_temp_peminjaman.id_anggota' => $idAnggota])->getResultArray();

                $data['page']         = $page;
                $data['web_title']    = "Transaksi Peminjaman";
                $data['dataAnggota']  = $dataAnggota;
                $data['dataBuku']     = $dataBuku;
                $data['jumlahTemp']   = $jumlahTemp;
                $data['dataTemp']     = $dataTemp;

                echo view('Backend/Template/header', $data);
                echo view('Backend/Template/sidebar', $data);
                echo view('Backend/Transaksi/peminjaman-step-2', $data);
                echo view('Backend/Template/footer', $data);
            }
        }
    }

    public function simpan_temp_pinjam()
    {
        $modelPeminjaman = new PeminjamanModels();
        $modelBuku       = new BukuModels();

        $uri      = service('uri');
        $idBuku   = $uri->getSegment(3);
        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

        $adaTemp      = $modelPeminjaman->getDataTemp(['sha1(id_buku)' => $idBuku])->getNumRows();
        $adaBerjalan  = $modelPeminjaman->getDataPeminjaman(['id_anggota' => session()->get('idAgt'), 'status_transaksi' => 'Berjalan'])->getNumRows();

        if($adaTemp){
            session()->setFlashdata('error','Satu Anggota Hanya Bisa Meminjam 1 Buku dengan Judul yang Sama!');
            ?>
            <script>history.go(-1);</script>
            <?php
        } elseif($adaBerjalan){
            session()->setFlashdata('error','Masih ada transaksi peminjaman yang belum diselesaikan, silakan selesaikan peminjaman sebelumnya terlebih dahulu!');
            ?>
            <script>history.go(-1);</script>
            <?php
        } else {
            $dataSimpanTemp = [
                'id_anggota'   => session()->get('idAgt'),
                'id_buku'      => $dataBuku['id_buku'],
                'jumlah_temp'  => '1'
            ];
            $modelPeminjaman->saveDataTemp($dataSimpanTemp);

            $stok        = $dataBuku['jumlah_eksemplar'] - 1;
            $dataUpdate  = ['jumlah_eksemplar' => $stok];
            $modelBuku->updateDataBuku($dataUpdate, ['sha1(id_buku)' => $idBuku]);
            ?>
            <script>document.location = "<?= base_url('admin/peminjaman-step-2');?>";</script>
            <?php
        }
    }

    public function hapus_peminjaman()
    {
        $modelPeminjaman = new PeminjamanModels();
        $modelBuku       = new BukuModels();

        $uri    = service('uri');
        $idBuku = $uri->getSegment(3);

        $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

        $modelPeminjaman->hapusDataTemp(['sha1(id_buku)' => $idBuku, 'id_anggota' => session()->get('idAgt')]);

        $stok       = $dataBuku['jumlah_eksemplar'] + 1;
        $dataUpdate = ['jumlah_eksemplar' => $stok];
        $modelBuku->updateDataBuku($dataUpdate, ['sha1(id_buku)' => $idBuku]);
        ?>
        <script>document.location = "<?= base_url('admin/peminjaman-step-2');?>";</script>
        <?php
    }

    public function simpan_transaksi_peminjaman()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelPeminjaman = new PeminjamanModels();

            $idPeminjaman  = date("ymdHis");
            $time_sekarang = time();
            $kembali       = date("Y-m-d", strtotime("+7 days", $time_sekarang));
            $jumlahPinjam  = $modelPeminjaman->getDataTemp(['id_anggota' => session()->get('idAgt')])->getNumRows();

            $dataQR  = $idPeminjaman;
            $labelQR = $idPeminjaman;

            $qrCode = new QrCode(
                data: $dataQR,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
            );

            $logo = new Logo(
                path: FCPATH.'Assets/logo_ubsi.png',
                resizeToWidth: 50,
                punchoutBackground: true
            );

            $label = new Label(
                text: $labelQR,
                textColor: new Color(255, 0, 0)
            );

            $writer = new PngWriter();
            $result = $writer->write($qrCode, $logo, $label);

            $namaQR = "qr_".$idPeminjaman.".png";
            $result->saveToFile(FCPATH.'Assets/qr_code/'.$namaQR);

            $dataSimpan = [
                'no_peminjaman'     => $idPeminjaman,
                'id_anggota'        => session()->get('idAgt'),
                'tgl_pinjam'        => date("Y-m-d"),
                'total_pinjam'      => $jumlahPinjam,
                'id_admin'          => session()->get('ses_id'),
                'status_transaksi'  => 'Berjalan',
                'status_ambil_buku' => 'Sudah Diambil',
                'qr_code'           => $namaQR
            ];
            $modelPeminjaman->saveDataPeminjaman($dataSimpan);

            $dataTemp = $modelPeminjaman->getDataTemp(['id_anggota' => session()->get('idAgt')])->getResultArray();
            foreach($dataTemp as $sementara){
                $simpanDetail = [
                    'no_peminjaman' => $idPeminjaman,
                    'id_buku'       => $sementara['id_buku'],
                    'status_pinjam' => 'Sedang Dipinjam',
                    'perpanjangan'  => '2',
                    'tgl_kembali'   => $kembali
                ];
                $modelPeminjaman->saveDataDetail($simpanDetail);
            }

            $modelPeminjaman->hapusDataTemp(['id_anggota' => session()->get('idAgt')]);
            session()->remove('idAgt');
            session()->setFlashdata('success','Data Peminjaman Buku Berhasil Disimpan!');
            ?>
            <script>document.location = "<?= base_url('admin/data-transaksi-peminjaman');?>";</script>
            <?php
        }
    }

    public function detail_peminjaman()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelPeminjaman = new PeminjamanModels();

            $uri    = service('uri');
            $idDetail = $uri->getSegment(3);

            $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin(['sha1(tbl_peminjaman.no_peminjaman)' => $idDetail])->getRowArray();
            $dataDetail     = $modelPeminjaman->getDataDetail(['tbl_detail_peminjaman.no_peminjaman' => $dataPeminjaman['no_peminjaman']])->getResultArray();

            $page = $uri->getSegment(2);

            $data['page']           = $page;
            $data['web_title']      = "Detail Peminjaman";
            $data['dataPeminjaman'] = $dataPeminjaman;
            $data['dataDetail']     = $dataDetail;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Transaksi/detail-peminjaman', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function data_pengembalian()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelPeminjaman = new PeminjamanModels();

            // Ambil data peminjaman yang masih berjalan
            $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin([
                'tbl_peminjaman.status_transaksi' => 'Berjalan'
            ])->getResultArray();

            $uri  = service('uri');
            $page = $uri->getSegment(2);

            $data['page']           = $page;
            $data['web_title']      = "Data Pengembalian";
            $data['dataPeminjaman'] = $dataPeminjaman;

            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/Transaksi/data-pengembalian', $data);
            echo view('Backend/Template/footer', $data);
        }
    }

    public function proses_pengembalian()
    {
        if(session()->get('ses_id')=='' or session()->get('ses_user')=='' or session()->get('ses_level')==''){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            ?>
            <script>document.location = "<?= base_url('admin/login-admin');?>";</script>
            <?php
        } else {
            $modelPeminjaman = new PeminjamanModels();
            $modelBuku       = new BukuModels();

            $uri          = service('uri');
            $idPeminjaman = $uri->getSegment(3);

            // Ambil data peminjaman
            $dataPeminjaman = $modelPeminjaman->getDataPeminjamanJoin([
                'sha1(tbl_peminjaman.no_peminjaman)' => $idPeminjaman
            ])->getRowArray();

            // Ambil semua detail buku yang dipinjam
            $dataDetail = $modelPeminjaman->getDataDetail([
                'tbl_detail_peminjaman.no_peminjaman' => $dataPeminjaman['no_peminjaman']
            ])->getResultArray();

            // Generate no pengembalian
            $noPengembalian = "PEN".date("ymdHis");

            // Proses setiap buku
            foreach($dataDetail as $detail){

                // Kembalikan stok buku
                $dataBuku = $modelBuku->getDataBuku([
                    'id_buku' => $detail['id_buku']
                ])->getRowArray();

                $stokBaru = $dataBuku['jumlah_eksemplar'] + 1;
                $modelBuku->updateDataBuku(
                    ['jumlah_eksemplar' => $stokBaru],
                    ['id_buku' => $detail['id_buku']]
                );

                // Update status detail
                $modelPeminjaman->updateDataDetail(
                    ['status_pinjam' => 'Sudah Dikembalikan'],
                    [
                        'no_peminjaman' => $dataPeminjaman['no_peminjaman'],
                        'id_buku'       => $detail['id_buku']
                    ]
                );

                // Hitung denda jika terlambat
                $tglKembali  = strtotime($detail['tgl_kembali']);
                $tglSekarang = strtotime(date('Y-m-d'));
                $selisih     = $tglSekarang - $tglKembali;
                $hariTelat   = round($selisih / 86400);

                // Denda Rp 1.000 per hari
                if($hariTelat > 0){
                    $denda = $hariTelat * 1000;
                } else {
                    $denda = 0;
                }

                // Simpan ke tbl_pengembalian
                $dataSimpanKembali = [
                    'no_pengembalian' => $noPengembalian,
                    'no_peminjaman'   => $dataPeminjaman['no_peminjaman'],
                    'id_buku'         => $detail['id_buku'],
                    'denda'           => $denda,
                    'tgl_pengembalian'=> date('Y-m-d'),
                    'id_admin'        => session()->get('ses_id')
                ];
                $modelPeminjaman->saveDataPengembalian($dataSimpanKembali);
            }

            // Update status peminjaman jadi Selesai
            $modelPeminjaman->updateDataPeminjaman(
                ['status_transaksi' => 'Selesai'],
                ['no_peminjaman' => $dataPeminjaman['no_peminjaman']]
            );

            session()->setFlashdata('success', 'Pengembalian Buku Berhasil Diproses!');
            ?>
            <script>document.location = "<?= base_url('admin/data-pengembalian');?>";</script>
            <?php
        }
    }

}
