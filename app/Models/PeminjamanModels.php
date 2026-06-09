<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModels extends Model
{
    protected $table = 'tbl_peminjaman';
    protected $tableTmp = 'tbl_temp_peminjaman';
    protected $tableDetail = 'tbl_detail_peminjaman';
    protected $tablePengembalian = 'tbl_pengembalian';
    public function getDataPeminjaman($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->orderBy('no_peminjaman', 'DESC');
        if ($where !== false) {
            $builder->where($where);
        }
        return $builder->get();
    }
    public function getDataPeminjamanJoin($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->join('tbl_anggota', 'tbl_anggota.id_anggota = tbl_peminjaman.id_anggota', 'LEFT');
        $builder->join('tbl_admin', 'tbl_admin.id_admin = tbl_peminjaman.id_admin', 'LEFT');
        $builder->orderBy('tbl_peminjaman.no_peminjaman', 'DESC');
        if ($where !== false) {
            $builder->where($where);
        }
        return $builder->get();
    }
    public function getDataTemp($where = false)
    {
        $builder = $this->db->table($this->tableTmp);
        $builder->select('*');
        if ($where !== false) {
            $builder->where($where);
        }
        return $builder->get();
    }
    public function getDataTempJoin($where = false)
    {
        $builder = $this->db->table($this->tableTmp);
        $builder->select('*');
        $builder->join('tbl_buku', 'tbl_buku.id_buku = tbl_temp_peminjaman.id_buku', 'LEFT');
        if ($where !== false) {
            $builder->where($where);
        }
        return $builder->get();
    }
    public function saveDataPeminjaman($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
    public function saveDataTemp($data)
    {
        return $this->db->table($this->tableTmp)->insert($data);
    }
    public function saveDataDetail($data)
    {
        return $this->db->table($this->tableDetail)->insert($data);
    }
    public function updateDataPeminjaman($data, $where)
    {
        return $this->db->table($this->table)
            ->where($where)
            ->update($data);
    }
    public function updateDataDetail($data, $where)
    {
        return $this->db->table($this->tableDetail)
            ->where($where)
            ->update($data);
    }
    public function hapusDataTemp($where)
    {
        return $this->db->table($this->tableTmp)->delete($where);
    }
    public function hapusDataPeminjaman($where)
    {
        return $this->db->table($this->table)->delete($where);
    }

    public function getDetailPeminjaman($no_peminjaman)
    {
        return $this->db->table('tbl_detail_peminjaman')
            ->select('
                tbl_detail_peminjaman.*,
                tbl_buku.judul_buku,
                tbl_buku.pengarang,
                tbl_buku.penerbit,
                tbl_buku.tahun
                ')
            ->join(
                'tbl_buku',
                'tbl_buku.id_buku = tbl_detail_peminjaman.id_buku',
                'LEFT'
            )
            ->where('tbl_detail_peminjaman.no_peminjaman', $no_peminjaman)
            ->get();
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

    public function saveDataPengembalian($data)
    {
        return $this->db->table($this->tablePengembalian)
            ->insert($data);
    }
    public function updateStatusBuku($no_peminjaman, $id_buku)
    {
        return $this->db->table($this->tableDetail)
            ->where('no_peminjaman', $no_peminjaman)
            ->where('id_buku', $id_buku)
            ->update([
                'status_pinjam' => 'Sudah Dikembalikan'
            ]);
    }
    public function cekBukuBelumKembali($no_peminjaman)
    {
        return $this->db->table($this->tableDetail)
            ->where('no_peminjaman', $no_peminjaman)
            ->where('status_pinjam', 'Sedang Dipinjam')
            ->countAllResults();
    }
    public function tambahStokBuku($id_buku)
    {
        return $this->db->table('tbl_buku')
            ->set('jumlah_eksemplar', 'jumlah_eksemplar + 1', false)
            ->where('id_buku', $id_buku)
            ->update();
    }

    public function getDataPengembalian($where = false)
    {
        $builder = $this->db->table('tbl_pengembalian');
        $builder->select("
tbl_pengembalian.*,
tbl_buku.judul_buku,
tbl_anggota.nama_anggota,
tbl_admin.nama_admin
");
        $builder->join(
            'tbl_peminjaman',
            'tbl_peminjaman.no_peminjaman = tbl_pengembalian.no_peminjaman',
            'left'
        );
        $builder->join(
            'tbl_anggota',
            'tbl_anggota.id_anggota = tbl_peminjaman.id_anggota',
            'left'
        );
        $builder->join(
            'tbl_buku',
            'tbl_buku.id_buku = tbl_pengembalian.id_buku',
            'left'
        );
        $builder->join(
            'tbl_admin',
            'tbl_admin.id_admin = tbl_pengembalian.id_admin',
            'left'
        );
        $builder->orderBy(
            'tbl_pengembalian.tgl_pengembalian',
            'DESC'
        );
        if ($where) {
            $builder->where($where);
        }
        return $builder->get();
    }
}
