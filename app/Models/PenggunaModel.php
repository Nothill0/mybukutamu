<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table      = 'pengguna';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'password']; // Hanya kolom ini yang bisa diisi/diperbarui
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    // Kita tidak menggunakan validasi di model untuk kesederhanaan awal
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
