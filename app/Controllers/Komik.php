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
                'Judul Komik ' . $slug . ' Tidak Tersedia \ Belum Terdaftar'
            );
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        session();

        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => 'Judul komik harus diisi.',
                    'is_unique' => 'Judul komik sudah ada.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penulis komik harus diisi.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerbit komik harus diisi.'
                ]
            ],
            'sampul' => [
                'rules' => 'uploaded[sampul]|max_size[sampul,2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Sampul Komik harus diisi',
                    'max_size' => 'Ukuran sampul terlalu besar',
                    'is_image' => 'File anda bukan gambar',
                    'mime_in' => 'File anda bukan gambar',
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        //ambil gambaer
        $fileSampul = $this->request->getFile('sampul');

        // generate nama sampul random
        $namaSampul = $fileSampul->getRandomName();

        //pindah gambar
        $fileSampul->move('img');


        // membuat url menjadi ramah user
        $slug = url_title($this->request->getVar('judul'), '-', true);

        // untuk mengambil get / post
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        // membuat flash data (seperti sweet alert)
        session()->setFlashdata('pesan', 'Data Komik Berhasil Ditambahkan');
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data Komik Berhasil Dihapus');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rules_judul = 'required';
        } else {
            $rules_judul = 'required|is_unique[komik.judul]';
        }

        $rules = [
            'judul' => [
                'rules' => $rules_judul,
                'errors' => [
                    'required' => 'Judul komik harus diisi.',
                    'is_unique' => 'Judul komik sudah ada.'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penulis komik harus diisi.'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penerbit komik harus diisi.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        // membuat flash data (seperti sweet alert)
        session()->setFlashdata('pesan', 'Data Komik Berhasil Diubah');
        return redirect()->to('/komik');
    }
}
