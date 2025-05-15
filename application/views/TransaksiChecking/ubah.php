<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Form Ubah Data
                </div>
                <div class="card-body">
                    <form action="<?= base_url('transaksi_checking/ubah/' . $transaksi_checking['id']); ?>" method="post">
                    <input type="hidden" name="id" value="<?= $transaksi_checking['id']; ?>">


                        <button type="submit" name="ubah" class="btn btn-primary btn-sm">Ubah Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
