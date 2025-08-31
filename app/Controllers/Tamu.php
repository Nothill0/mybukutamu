<?php

namespace App\Controllers;

use App\Models\TamuModel;
use App\Models\PenggunaModel;
use CodeIgniter\Controller;

class Tamu extends Controller
{
    protected $tamuModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        helper(['form', 'url']);
    }

    /**
     * Menampilkan form untuk menambah tamu baru.
     */

    public function tambah()
    {
        $data['title'] = 'Form Tambah Tamu';
        $data['validation'] = \Config\Services::validation();

        return view('tamu/tambah', $data);
    }

    /**
     * data yang dikirimkan dari form tambah/edit tamu.
     */

    public function simpan()
    {
        $rules = [
            'nama'              => 'required|min_length[3]',
            'nomor_telepon'     => 'required|numeric|min_length[8]',
            'email'             => 'permit_empty|valid_email',
            'alamat'            => 'required',
            'tujuan_kunjungan'  => 'required',
            'maksud_bertemu'    => 'required',
            'foto_data'         => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $nama               = $this->request->getPost('nama');
        $nomor_telepon      = $this->request->getPost('nomor_telepon');
        $email              = $this->request->getPost('email');
        $alamat             = $this->request->getPost('alamat');
        $instansi           = $this->request->getPost('instansi');
        $tujuan_kunjungan   = $this->request->getPost('tujuan_kunjungan');
        $maksud_bertemu     = $this->request->getPost('maksud_bertemu');
        $foto_data_uri      = $this->request->getPost('foto_data');

        $jalur_foto = null;
        if (!empty($foto_data_uri)) {
            list($type, $foto_data_uri) = explode(';', $foto_data_uri);
            list(, $foto_data_uri) = explode(',', $foto_data_uri);
            $foto_data_uri = base64_decode($foto_data_uri);

            $nama_file = 'tamu_' . time() . '_' . uniqid() . '.png';
            $folder_upload = FCPATH . 'uploads/tamu/';
            if (!is_dir($folder_upload)) {
                mkdir($folder_upload, 0777, true);
            }
            file_put_contents($folder_upload . $nama_file, $foto_data_uri);
            $jalur_foto = 'uploads/tamu/' . $nama_file;
        }

        $this->tamuModel->save([
            'nama'              => $nama,
            'nomor_telepon'     => $nomor_telepon,
            'email'             => $email,
            'alamat'            => $alamat,
            'instansi'          => $instansi,
            'tujuan_kunjungan'  => $tujuan_kunjungan,
            'maksud_bertemu'    => $maksud_bertemu,
            'jalur_foto'        => $jalur_foto,
            'status'            => 'menunggu'
        ]);

        // Baris ini sudah benar
        session()->setFlashdata('pesan_sukses', 'Data tamu berhasil ditambahkan dan menunggu persetujuan.');

        // BARIS YANG DIPERBAIKI: Arahkan ke halaman form tambah lagi agar modal muncul
        return redirect()->to(base_url('tamu/tambah'));
    }

    /**
     * Menampilkan daftar tamu yang menunggu persetujuan.
     */
    public function persetujuan()
    {
        $keyword = $this->request->getVar('keyword');
        $tamuMenungguQuery = $this->tamuModel->where('status', 'menunggu');

        if ($keyword) {
            $tamuMenungguQuery->groupStart()
                ->like('nama', $keyword)
                ->orLike('nomor_telepon', $keyword)
                ->orLike('instansi', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('tujuan_kunjungan', $keyword)
                ->orLike('maksud_bertemu', $keyword)
                ->groupEnd();
        }

        $data['tamu_menunggu'] = $tamuMenungguQuery->orderBy('dibuat_pada', 'DESC')
            ->paginate(10, 'menunggu');
        $data['pager'] = $this->tamuModel->pager;
        $data['title'] = 'Persetujuan Tamu';
        $data['pesan_sukses'] = session()->getFlashdata('pesan_sukses');
        $data['pesan_error'] = session()->getFlashdata('pesan');
        $data['keyword'] = $keyword;

        return view('tamu/persetujuan', $data);
    }

    /**
     * Menampilkan detail data tamu.
     */
    public function detail($id = null)
    {
        $tamu = $this->tamuModel->find($id);

        if (!$tamu) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tamu tidak ditemukan.');
        }

        $data['tamu'] = $tamu;
        $data['title'] = 'Detail Tamu';

        if ($tamu['disetujui_oleh'] || $tamu['ditolak_oleh']) {
            $penggunaModel = new PenggunaModel();
            if ($tamu['disetujui_oleh']) {
                $admin_setuju = $penggunaModel->find($tamu['disetujui_oleh']);
                $data['admin_setuju_nama'] = $admin_setuju['username'] ?? 'Tidak diketahui';
            }
            if ($tamu['ditolak_oleh']) {
                $admin_tolak = $penggunaModel->find($tamu['ditolak_oleh']);
                $data['admin_tolak_nama'] = $admin_tolak['username'] ?? 'Tidak diketahui';
            }
        }

        return view('tamu/detail', $data);
    }

    /**
     * Menampilkan form edit tamu.
     */
    public function edit($id = null)
    {
        $tamu = $this->tamuModel->find($id);

        if (!$tamu) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tamu tidak ditemukan.');
        }

        $data['tamu'] = $tamu;
        $data['title'] = 'Edit Data Tamu';
        $data['validation'] = \Config\Services::validation();

        return view('tamu/edit', $data);
    }

    /**
     * Memproses update data tamu.
     */
    public function update($id)
    {
        $rules = [
            'nama'              => 'required|min_length[3]',
            'nomor_telepon'     => 'required|numeric|min_length[8]',
            'email'             => 'permit_empty|valid_email',
            'alamat'            => 'required',
            'tujuan_kunjungan'  => 'required',
            'maksud_bertemu'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $nama               = $this->request->getPost('nama');
        $nomor_telepon      = $this->request->getPost('nomor_telepon');
        $email              = $this->request->getPost('email');
        $alamat             = $this->request->getPost('alamat');
        $instansi           = $this->request->getPost('instansi');
        $tujuan_kunjungan   = $this->request->getPost('tujuan_kunjungan');
        $maksud_bertemu     = $this->request->getPost('maksud_bertemu');
        $foto_data_uri      = $this->request->getPost('foto_data');

        $tamu_lama = $this->tamuModel->find($id);
        if (!$tamu_lama) {
            session()->setFlashdata('pesan', 'Data tamu tidak ditemukan untuk diperbarui.');
            return redirect()->back();
        }

        $jalur_foto_lama = $tamu_lama['jalur_foto'];
        $jalur_foto_baru = $jalur_foto_lama;

        if (!empty($foto_data_uri)) {
            if (strpos($foto_data_uri, 'data:image/png;base64,') === 0) {
                $foto_data_uri = str_replace('data:image/png;base64,', '', $foto_data_uri);
            } else if (strpos($foto_data_uri, 'data:image/jpeg;base64,') === 0) {
                $foto_data_uri = str_replace('data:image/jpeg;base64,', '', $foto_data_uri);
            } else {
                session()->setFlashdata('pesan', 'Format data foto tidak valid.');
                return redirect()->back()->withInput();
            }

            $foto_data_decoded = base64_decode($foto_data_uri);
            if ($foto_data_decoded === false) {
                session()->setFlashdata('pesan', 'Gagal mendekode data foto. Pastikan foto diambil dengan benar.');
                return redirect()->back()->withInput();
            }

            $nama_file = 'tamu_' . time() . '_' . uniqid() . '.png';
            $folder_upload = FCPATH . 'uploads/tamu/';

            if (!is_dir($folder_upload)) {
                if (!mkdir($folder_upload, 0777, true)) {
                    session()->setFlashdata('pesan', 'Gagal membuat folder upload.');
                    return redirect()->back()->withInput();
                }
            }

            if (file_put_contents($folder_upload . $nama_file, $foto_data_decoded)) {
                $jalur_foto_baru = 'uploads/tamu/' . $nama_file;
                if ($jalur_foto_lama && file_exists(FCPATH . $jalur_foto_lama) && $jalur_foto_lama != $jalur_foto_baru) {
                    unlink(FCPATH . $jalur_foto_lama);
                }
            } else {
                session()->setFlashdata('pesan', 'Gagal menyimpan foto baru.');
                return redirect()->back()->withInput();
            }
        }

        $data_update = [
            'nama'              => $nama,
            'nomor_telepon'     => $nomor_telepon,
            'email'             => $email,
            'alamat'            => $alamat,
            'instansi'          => $instansi,
            'tujuan_kunjungan'  => $tujuan_kunjungan,
            'maksud_bertemu'    => $maksud_bertemu,
            'jalur_foto'        => $jalur_foto_baru,
        ];

        if ($this->tamuModel->update($id, $data_update)) {
            session()->setFlashdata('pesan_sukses', 'Data tamu berhasil diperbarui.');
            return redirect()->to(base_url('tamu/persetujuan'));
        } else {
            session()->setFlashdata('pesan', 'Gagal memperbarui data tamu.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Menghapus data tamu.
     */
    public function delete($id = null)
    {
        $tamu = $this->tamuModel->find($id);

        if (!$tamu) {
            session()->setFlashdata('pesan', 'Data tamu tidak ditemukan.');
            return redirect()->back();
        }

        if ($tamu['jalur_foto'] && file_exists(FCPATH . $tamu['jalur_foto'])) {
            unlink(FCPATH . $tamu['jalur_foto']);
        }

        $this->tamuModel->delete($id);
        session()->setFlashdata('pesan_sukses', 'Data tamu berhasil dihapus.');
        return redirect()->to(base_url('home'));
    }

    /**
     * Mengubah status tamu menjadi 'disetujui'.
     */
    public function setujui($id = null)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('pesan', 'Anda tidak memiliki akses.');
            return redirect()->to(base_url('login'));
        }

        $admin_id = session()->get('id_pengguna');
        $this->tamuModel->update($id, [
            'status' => 'disetujui',
            'disetujui_oleh' => $admin_id,
            'ditolak_oleh' => null
        ]);
        session()->setFlashdata('pesan_sukses', 'Tamu berhasil disetujui.');
        return redirect()->to(base_url('tamu/persetujuan'));
    }

    /**
     * Mengubah status tamu menjadi 'ditolak'.
     */
    public function tolak($id = null)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('pesan', 'Anda tidak memiliki akses.');
            return redirect()->to(base_url('login'));
        }

        $admin_id = session()->get('id_pengguna');
        $this->tamuModel->update($id, [
            'status' => 'ditolak',
            'ditolak_oleh' => $admin_id,
            'disetujui_oleh' => null
        ]);
        session()->setFlashdata('pesan_sukses', 'Tamu berhasil ditolak.');
        return redirect()->to(base_url('tamu/persetujuan'));
    }
}
