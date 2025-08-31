<?php

namespace App\Controllers;

use App\Models\TamuModel;
use CodeIgniter\Controller;

class Laporan extends Controller
{
    protected $tamuModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['title'] = 'Laporan Tamu';

        $keyword = $this->request->getVar('keyword');

        $tamuQuery = $this->tamuModel;
        if ($keyword) {
            $tamuQuery->groupStart()
                ->like('nama', $keyword)
                ->orLike('nomor_telepon', $keyword)
                ->orLike('instansi', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('tujuan_kunjungan', $keyword)
                ->orLike('maksud_bertemu', $keyword)
                ->groupEnd();
        }

        $data['tamu'] = $tamuQuery->orderBy('dibuat_pada', 'DESC')
            ->paginate(10, 'laporan'); // 10 item per halaman
        $data['pager'] = $this->tamuModel->pager;

        $data['keyword'] = $keyword;

        return view('laporan/index', $data);
    }
}
