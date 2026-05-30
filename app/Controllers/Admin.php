<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\adminModels;
use App\Models\anggotaModels;
use App\Models\rakModels;
use App\Models\KategoriModels;

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
}
