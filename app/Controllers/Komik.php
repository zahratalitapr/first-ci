<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];


        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        // jika komik tidak ada maka tampilkan 4040page
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Judul Komik' . $slug . 'Tidak Tersedia \ Belum Terdaftar'
            );
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Komik'
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // membuat url menjadi ramah user
        $slug = url_title($this->request->getVar('judul'), '-', true);
        // untuk mengambil get / post
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        // membuat flash data (seperti sweet alert)
        session()->setFlashdata('pesan', 'Data Komik Berhasil Ditambahkan');
        return redirect()->to('/komik');
    }
}
