<?php

namespace App\Models;

use CodeIgniter\Model;

class TamuModel extends Model
{
    protected $table = 'tamu';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Jika Anda tidak menggunakan soft delete

    protected $allowedFields = [
        'nama',
        'nomor_telepon',
        'email',
        'alamat',
        'instansi',
        'tujuan_kunjungan',
        'maksud_bertemu',
        'jalur_foto',
        'status',
        'disetujui_oleh',
        'ditolak_oleh',
        'dibuat_pada',
        'diperbarui_pada' // PASTIKAN KOLOM INI ADA
    ];

    // Dates
    protected $useTimestamps = true; // Mengaktifkan timestamps
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dibuat_pada';
    protected $updatedField  = 'diperbarui_pada';
    protected $deletedField  = 'dihapus_pada'; // Jika Anda menggunakan soft delete
}
