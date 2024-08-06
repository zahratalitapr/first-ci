<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Ubah Data Komik</h2>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <form action="/komik/update/<?= $komik['id']; ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $komik['slug']; ?>">
                <!-- Section Judul -->
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= (old('judul')) ? old('judul') : $komik['judul']; ?>">
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('judul') : ''; ?>
                        </div>
                    </div>
                </div>

                <!-- Section Penulis -->
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('penulis')) ? 'is-invalid' : ''; ?>" id="penulis" name="penulis" value="<?= (old('penulis')) ? old('penulis') : $komik['penulis']; ?>">
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('penulis') : ''; ?>
                        </div>
                    </div>
                </div>

                <!-- Section Penerbit -->
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('penerbit')) ? 'is-invalid' : ''; ?>" id="penerbit" name="penerbit" value="<?= (old('penerbit')) ? old('penerbit') : $komik['penerbit']; ?>">
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('penerbit') : ''; ?>
                        </div>
                    </div>
                </div>

                <!-- Sampul -->
                <div class="row mb-3">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul Buku</label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul" value="<?= old('sampul'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>