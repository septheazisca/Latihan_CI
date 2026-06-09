<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModels;
use CodeIgniter\HTTP\ResponseInterface;

class Homepage extends BaseController
{
    public function index()
    {
        $modelBuku = new BukuModels();
        $data['data_buku'] = $modelBuku
            ->getDataBukuJoin([
                'tbl_buku.is_delete_buku' => '0'
            ])
            ->getResultArray();
        return view('homepage', $data);
    }
}
