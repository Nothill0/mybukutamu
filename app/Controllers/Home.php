<?php

namespace App\Controllers;

use App\Models\TamuModel;
use CodeIgniter\Controller;

class Home extends Controller
{
    protected $tamuModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        helper(['form', 'url']);
    }

    /**
     * Metode ini akan menampilkan halaman publik (halaman depan).
     * Rute: /
     */
    public function publicIndex()
    {
        // homeuser diakses oleh user (/)
        return view('homeuser/index');
    }

    /**
     * Metode ini akan menampilkan dasbor admin.
     * Rute: /home
     */

    public function index()
    {
        $data['title'] = 'Beranda Admin';

        $keyword = $this->request->getVar('keyword');

        // --- Tamu Disetujui ---
        $tamuDisetujuiQuery = $this->tamuModel->where('status', 'disetujui');
        if ($keyword) {
            $tamuDisetujuiQuery->groupStart()
                ->like('nama', $keyword)
                ->orLike('nomor_telepon', $keyword)
                ->orLike('instansi', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('tujuan_kunjungan', $keyword)
                ->orLike('maksud_bertemu', $keyword)
                ->groupEnd();
        }
        $data['tamu_disetujui'] = $tamuDisetujuiQuery->orderBy('dibuat_pada', 'DESC')
            ->paginate(10, 'disetujui');
        $data['pager_disetujui'] = $this->tamuModel->pager;

        // --- Tamu Ditolak ---
        $tamuDitolakQuery = $this->tamuModel->where('status', 'ditolak');
        if ($keyword) {
            $tamuDitolakQuery->groupStart()
                ->like('nama', $keyword)
                ->orLike('nomor_telepon', $keyword)
                ->orLike('instansi', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('tujuan_kunjungan', $keyword)
                ->orLike('maksud_bertemu', $keyword)
                ->groupEnd();
        }
        $data['tamu_ditolak'] = $tamuDitolakQuery->orderBy('dibuat_pada', 'DESC')
            ->paginate(15, 'ditolak');
        $data['pager_ditolak'] = $this->tamuModel->pager;

        $pesanSukses = session()->getFlashdata('pesan_sukses');
        if ($pesanSukses) {
            $data['pesan_sukses'] = $pesanSukses;
        }

        $data['keyword'] = $keyword;

        return view('home/index', $data);
    }

    public function getChartData()
    {
        // Ambil data harian (7 hari terakhir)
        $dataHarian = $this->tamuModel
            ->select("DATE(dibuat_pada) as tanggal, COUNT(id) as jumlah")
            ->where("dibuat_pada > DATE_SUB(NOW(), INTERVAL 7 DAY)")
            ->groupBy("tanggal")
            ->orderBy("tanggal", "ASC")
            ->findAll();

        // Ambil data mingguan (10 minggu terakhir)
        $dataMingguan = $this->tamuModel
            ->select("YEARWEEK(dibuat_pada) as minggu, COUNT(id) as jumlah")
            ->where("dibuat_pada > DATE_SUB(NOW(), INTERVAL 10 WEEK)")
            ->groupBy("minggu")
            ->orderBy("minggu", "ASC")
            ->findAll();

        // Ambil data bulanan (12 bulan terakhir)
        $dataBulanan = $this->tamuModel
            ->select("MONTH(dibuat_pada) as bulan, YEAR(dibuat_pada) as tahun, COUNT(id) as jumlah")
            ->where("dibuat_pada > DATE_SUB(NOW(), INTERVAL 12 MONTH)")
            ->groupBy("bulan, tahun")
            ->orderBy("tahun", "ASC")
            ->orderBy("bulan", "ASC")
            ->findAll();

        // Ambil data tahunan (5 tahun terakhir)
        $dataTahunan = $this->tamuModel
            ->select("YEAR(dibuat_pada) as tahun, COUNT(id) as jumlah")
            ->where("dibuat_pada > DATE_SUB(NOW(), INTERVAL 5 YEAR)")
            ->groupBy("tahun")
            ->orderBy("tahun", "ASC")
            ->findAll();

        // Ambil data maksud bertemu paling sering (top 3)
        $dataMaksudBertemu = $this->tamuModel
            ->select("maksud_bertemu, COUNT(id) as jumlah")
            ->groupBy("maksud_bertemu")
            ->orderBy("jumlah", "DESC")
            ->limit(3)
            ->findAll();

        $response = [
            'harian' => $dataHarian,
            'mingguan' => $dataMingguan,
            'bulanan' => $dataBulanan,
            'tahunan' => $dataTahunan,
            'maksudBertemu' => $dataMaksudBertemu,
        ];

        return $this->response->setJSON($response);
    }
}
