<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModels;
use App\Models\BukuModels;
use App\Models\PeminjamanModels;
use CodeIgniter\HTTP\ResponseInterface;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;


class Peminjaman extends BaseController
{
    // Transaksi Peminjaman
    public function peminjaman_step1()
    {
        $modelAnggota = new AnggotaModels();
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $data = [
            'page' => $page,
            'web_title' => "Transaksi Peminjaman",
            'dataAnggota' => $modelAnggota->getDataAnggota()
        ];
        return view('Backend/Template/header', $data)
            . view('Backend/Template/sidebar', $data)
            . view('Backend/Transaksi/peminjaman-step-1', $data)
            . view('Backend/Template/footer', $data);
    }
    public function peminjaman_step2()
    {
        $modelAnggota = new AnggotaModels();
        $modelBuku = new BukuModels();
        $modelPeminjaman = new PeminjamanModels();
        $uri = service('uri');
        $page = $uri->getSegment(2);
        // Ambil ID Anggota dari POST atau SESSION
        if ($this->request->getPost('id_anggota')) {
            $idAnggota = $this->request->getPost('id_anggota');
            session()->set(['idAgt' => $idAnggota]);
        } else {
            $idAnggota = session()->get('idAgt');
        }
        // Cek apakah masih ada transaksi berjalan
        $cekPeminjaman = $modelPeminjaman
            ->getDataPeminjaman([
                'id_anggota' => $idAnggota,
                'status_transaksi' => "Berjalan"
            ])
            ->getNumRows();
        if ($cekPeminjaman > 0) {
            session()->setFlashdata(
                'error',
                'Transaksi Tidak Dapat Dilakukan, Masih Ada Transaksi Peminjaman yang Belum Diselesaikan!!'
            );
            echo "<script>history.go(-1);</script>";
            return;
        }
        $dataAnggota = $modelAnggota->getDataAnggota([
            'id_anggota' => $idAnggota
        ]);
        $dataBuku = $modelBuku
            ->getDataBukuJoin()
            ->getResultArray();
        // Ambil data temp peminjaman
        $jumlahTemp = $modelPeminjaman
            ->getDataTemp(['id_anggota' => $idAnggota])
            ->getNumRows();
        $dataTemp = $modelPeminjaman
            ->getDataTempJoin(['tbl_temp_peminjaman.id_anggota' =>
            $idAnggota])
            ->getResultArray();
        // Kirim ke view
        $data = [
            'page' => $page,
            'web_title' => "Transaksi Peminjaman",
            'dataAnggota' => $dataAnggota,
            'dataBuku' => $dataBuku,
            'dataTemp' => $dataTemp,
            'jumlahTemp' => $jumlahTemp
        ];
        return view('Backend/Template/header', $data)
            . view('Backend/Template/sidebar', $data)
            . view('Backend/Transaksi/peminjaman-step-2', $data)
            . view('Backend/Template/footer', $data);
    }
    public function simpan_temp_pinjam()
    {
        $modelPeminjaman = new PeminjamanModels();
        $modelBuku = new BukuModels();
        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
        // Ambil data buku
        $dataBuku = $modelBuku
            ->getDataBuku(['sha1(id_buku)' => $idBuku])
            ->getRowArray();
        // Cek apakah buku sudah ada di temp
        $adaTemp = $modelPeminjaman
            ->getDataTemp(['sha1(id_buku)' => $idBuku])
            ->getNumRows();
        // Cek transaksi berjalan
        $adaBerjalan = $modelPeminjaman
            ->getDataPeminjaman([
                'id_anggota' => session()->get('idAgt'),
                'status_transaksi' => "Berjalan"
            ])
            ->getNumRows();
        // Validasi
        if ($adaTemp > 0) {
            session()->setFlashdata(
                'error',
                'Satu Anggota Hanya Bisa Meminjam 1 Buku dengan Judul yang
Sama!'
            );
            return redirect()->back();
        }
        if ($adaBerjalan > 0) {
            session()->setFlashdata(
                'error',
                'Masih ada transaksi peminjaman yang belum diselesaikan!'
            );
            return redirect()->back();
        }
        // Simpan ke temp
        $dataSimpanTemp = [
            'id_anggota' => session()->get('idAgt'),
            'id_buku' => $dataBuku['id_buku'],
            'jumlah_temp' => 1
        ];
        $modelPeminjaman->saveDataTemp($dataSimpanTemp);
        // Update stok buku
        $stok = $dataBuku['jumlah_eksemplar'] - 1;
        $dataUpdate = [
            'jumlah_eksemplar' => $stok
        ];
        $modelBuku->updateDataBuku($dataUpdate, ['sha1(id_buku)' => $idBuku]);
        return redirect()->to(base_url('admin/peminjaman-step-2'));
    }
    public function hapus_peminjaman()
    {
        $modelPeminjaman = new PeminjamanModels();
        $modelBuku = new BukuModels();
        $uri = service('uri');
        $idBuku = $uri->getSegment(3);
        // Ambil data buku
        $dataBuku = $modelBuku
            ->getDataBuku(['sha1(id_buku)' => $idBuku])
            ->getRowArray();
        // Hapus dari temp peminjaman
        $modelPeminjaman->hapusDataTemp([
            'sha1(id_buku)' => $idBuku,
            'id_anggota' => session()->get('idAgt')
        ]);
        // Kembalikan stok
        $stok = $dataBuku['jumlah_eksemplar'] + 1;
        $dataUpdate = [
            'jumlah_eksemplar' => $stok
        ];
        $modelBuku->updateDataBuku($dataUpdate, ['sha1(id_buku)' => $idBuku]);
        return redirect()->to(base_url('admin/peminjaman-step-2'));
    }
    public function simpan_transaksi_peminjaman()
    {
        $modelPeminjaman = new PeminjamanModels();
        $idPeminjaman = date("ymdHis");
        $timeSekarang = time();
        $kembali = date("Y-m-d", strtotime("+7 days", $timeSekarang));
        // Hitung jumlah pinjam
        $jumlahPinjam = $modelPeminjaman
            ->getDataTemp(['id_anggota' => session()->get('idAgt')])
            ->getNumRows();
        // ================= QR CODE =================
        $dataQR = $idPeminjaman;
        $labelQR = $idPeminjaman;
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($dataQR)
            ->encoding(new Encoding("UTF-8"))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath(FCPATH . 'Assets/ubsi.png')
            ->logoResizeToWidth(50)
            ->logoPunchoutBackground(true)
            ->labelText($labelQR)
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->build();
        $namaQR = "qr_" . $idPeminjaman . ".png";
        $result->saveToFile(FCPATH . 'Assets/qr_code/' . $namaQR);
        // ================= SIMPAN HEADER =================
        $dataSimpan = [
            'no_peminjaman' => $idPeminjaman,
            'id_anggota' => session()->get('idAgt'),
            'tgl_pinjam' => date("Y-m-d"),
            'total_pinjam' => $jumlahPinjam,
            'id_admin' => session()->get('ses_id'),
            'status_transaksi' => "Berjalan",
            'status_ambil_buku' => "Sudah Diambil",
            'qr_code' => $namaQR
        ];
        $modelPeminjaman->saveDataPeminjaman($dataSimpan);
        // ================= SIMPAN DETAIL =================
        $dataTemp = $modelPeminjaman
            ->getDataTemp(['id_anggota' => session()->get('idAgt')])
            ->getResultArray();
        foreach ($dataTemp as $sementara) {
            $simpanDetail = [
                'no_peminjaman' => $idPeminjaman,
                'id_buku' => $sementara['id_buku'],
                'status_pinjam' => "Sedang Dipinjam",
                'perpanjangan' => "2",
                'tgl_kembali' => $kembali
            ];
            $modelPeminjaman->saveDataDetail($simpanDetail);
        }
        // ================= HAPUS TEMP =================
        $modelPeminjaman->hapusDataTemp([
            'id_anggota' => session()->get('idAgt')
        ]);
        session()->remove('idAgt');
        session()->setFlashdata('success', 'Data Peminjaman Buku Berhasil Disimpan!');
        return redirect()->to(base_url('admin/data-transaksi-peminjaman'));
    }
    public function data_transaksi_peminjaman()
    {
        $modelPeminjaman = new PeminjamanModels();
        $uri = service('uri');
        $page = $uri->getSegment(2);
        // Ambil data transaksi + join anggota
        $dataPeminjaman = $modelPeminjaman
            ->getDataPeminjamanJoin()
            ->getResultArray();
        $data = [
            'page' => $page,
            'web_title' => 'Data Transaksi Peminjaman',
            'dataPeminjaman' => $dataPeminjaman
        ];
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/data-transaksi-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function detail_transaksi($no_peminjaman)
    {
        $modelPeminjaman = new PeminjamanModels();
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $transaksi = $modelPeminjaman
            ->getDataPeminjamanJoin([
                'tbl_peminjaman.no_peminjaman' => $no_peminjaman
            ])
            ->getRowArray();
        $detailBuku = $modelPeminjaman
            ->getDetailPeminjaman($no_peminjaman)
            ->getResultArray();
        $data = [
            'page' => $page,
            'web_title' => 'Detail Transaksi Peminjaman',
            'transaksi' => $transaksi,
            'detailBuku' => $detailBuku
        ];
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/detail-transaksi-peminjaman', $data);
        echo view('Backend/Template/footer', $data);
    }

    public function proses_pengembalian($no_peminjaman, $id_buku)
    {
        $modelPeminjaman = new PeminjamanModels();
        $detail = $modelPeminjaman
            ->getDetailPeminjaman($no_peminjaman)
            ->getResultArray();
        $dataBuku = null;
        foreach ($detail as $row) {
            if ($row['id_buku'] == $id_buku) {
                $dataBuku = $row;
                break;
            }
        }
        if (!$dataBuku) {
            session()->setFlashdata(
                'error',
                'Data buku tidak ditemukan'
            );
            return redirect()->back();
        }
        if ($dataBuku['status_pinjam'] == 'Sudah Dikembalikan') {
            session()->setFlashdata(
                'error',
                'Buku sudah dikembalikan'
            );
            return redirect()->back();
        }
        $denda = 0;
        $hariIni = date('Y-m-d');
        if ($hariIni > $dataBuku['tgl_kembali']) {
            $hariTelat = floor(
                (strtotime($hariIni) - strtotime($dataBuku['tgl_kembali']))
                    / 86400
            );
            $denda = $hariTelat * 1000;
        }
        $noPengembalian =
            'KMB' . date('ymdHis');
        $modelPeminjaman->saveDataPengembalian([
            'no_pengembalian' => $noPengembalian,
            'no_peminjaman' => $no_peminjaman,
            'id_buku' => $id_buku,
            'denda' => $denda,
            'tgl_pengembalian' => date('Y-m-d'),
            'id_admin' => session()->get('ses_id')
        ]);
        $modelPeminjaman->updateStatusBuku(
            $no_peminjaman,
            $id_buku
        );
        $modelPeminjaman->tambahStokBuku(
            $id_buku
        );
        $sisa = $modelPeminjaman
            ->cekBukuBelumKembali($no_peminjaman);
        if ($sisa == 0) {
            $modelPeminjaman->updateDataPeminjaman(
                [
                    'status_transaksi' => 'Selesai'
                ],
                [
                    'no_peminjaman' => $no_peminjaman
                ]
            );
        }
        session()->setFlashdata(
            'success',
            'Buku berhasil dikembalikan'
        );
        return redirect()->back();
    }

    public function data_pengembalian()
    {
        $modelPeminjaman = new PeminjamanModels();
        $uri = service('uri');
        $page = $uri->getSegment(2);
        $data = [
            'page' => $page,
            'web_title' => 'Data Pengembalian Buku',
            'pengembalian' => $modelPeminjaman
                ->getDataPengembalian()
                ->getResultArray()
        ];
        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Transaksi/data-pengembalian', $data);
        echo view('Backend/Template/footer', $data);
    }
}
