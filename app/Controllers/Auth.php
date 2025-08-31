<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    /**
     * Menampilkan halaman login.
     * Jika admin sudah login, akan diarahkan ke halaman beranda.
     */

    public function index()
    {
        // Periksa apakah sesi 'logged_in' ada.
        if (session()->get('logged_in')) {
            // Jika sudah login, arahkan ke URL 'homeadmin'.
            return redirect()->to(base_url('home'));
        }

        // Siapkan data untuk view, dalam hal ini judul halaman.
        $data['title'] = 'Login Admin Buku Tamu';

        return view('auth/login', $data);
    }

    /**
     * Memproses data yang dikirimkan dari form login.
     */
    public function login()
    {
        // Inisialisasi objek sesi.
        $session = session();
        // Inisialisasi model PenggunaModel untuk berinteraksi dengan tabel 'pengguna'.
        $model = new PenggunaModel();

        // Ambil nilai 'username' dan 'password' dari request POST.
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Periksa apakah username atau password kosong.
        if (empty($username) || empty($password)) {
            // Jika kosong, set flashdata 'pesan' dengan pesan error.
            // Flashdata adalah data sesi yang hanya tersedia untuk request berikutnya.
            $session->setFlashdata('pesan', 'Username dan password harus diisi!');
            // Arahkan kembali ke halaman login.
            return redirect()->to(base_url('login'));
        }

        // ==== VERIFIKASI KREDENSIAL ====
        // Cari data pengguna di database berdasarkan username.
        // ->first() akan mengembalikan baris pertama yang ditemukan sebagai array (sesuai returnType di model).
        $dataPengguna = $model->where('username', $username)->first();

        // Periksa apakah pengguna ditemukan.
        if ($dataPengguna) {
            if ($password === $dataPengguna['password']) {
                // Jika password cocok, buat array data sesi yang akan disimpan.
                $ses_data = [
                    'id_pengguna'   => $dataPengguna['id'],
                    'username'      => $dataPengguna['username'],
                    'logged_in'     => TRUE // Penanda bahwa pengguna sudah login
                ];
                // Simpan data ke dalam sesi.
                $session->set($ses_data);

                // Set flashdata untuk pesan sukses setelah login.
                $session->setFlashdata('pesan_sukses', 'Login berhasil! Selamat datang, ' . $dataPengguna['username']);
                // Arahkan ke halaman beranda ('home').
                return redirect()->to(base_url('home'));
            } else {
                // Password salah.
                $session->setFlashdata('pesan', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            // Username tidak ditemukan.
            $session->setFlashdata('pesan', 'Username tidak ditemukan!');
            return redirect()->to(base_url('login'));
        }
    }

    /**
     * Menangani proses logout.
     * Menghapus semua data sesi dan mengarahkan kembali ke halaman login.
     */
    public function logout()
    {
        $session = session();
        // Menghancurkan (menghapus) semua data sesi yang sedang aktif.
        $session->destroy();
        // Arahkan kembali ke halaman login setelah logout.
        return redirect()->to(base_url('login'));
    }
}
