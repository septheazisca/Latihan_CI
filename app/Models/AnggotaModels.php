<?php

namespace App\Models;

use CodeIgniter\Model;

class anggotaModels extends Model
{
    protected $table = 'tbl_anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = [
        'id_anggota',
        'nama_anggota',
        'jenis_kelamin',
        'no_telp',
        'alamat',
        'email',
        'password_anggota',
        'is_delete_anggota',
        'created_at',
        'updated_at'
    ];
    // Ambil semua anggota (untuk dropdown)
    public function getDataAnggota($where = false)
    {
        if ($where === false) {
            return $this->findAll(); // 🔥 pakai ini dulu
        } else {
            return $this->where($where)->first();
        }
    }
    // Search anggota (optional untuk Select2 AJAX)
    public function searchAnggota($keyword)
    {
        return $this->groupStart()
            ->like('id_anggota', $keyword)
            ->orLike('nama_anggota', $keyword)
            ->groupEnd()
            ->where('is_delete_anggota', 0)
            ->orderBy('nama_anggota', 'ASC')
            ->findAll();
    }

    public function saveDataAnggota($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataAnggota($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }

    public function autoNumber()
    {
        $builder = $this->db->table($this->table);
        $builder->select("id_anggota");
        $builder->orderBy("id_anggota", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
    }
}
