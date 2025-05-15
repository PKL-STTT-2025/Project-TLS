<div class="container">
    <h3> Input Defect Detail </h3>
    <div class= "row mt-3">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item"> Kode Defect : <?=$transaksi_checking['kode_defect']?></li>
                <li class="list-group-item"> Deskripsi Defect : <?=$transaksi_checking['deskripsi_defect']?></li>
                <li class="list-group-item">Kategori : <?=$transaksi_checking['kategori']?></li>
                <li class="list-group-item">Jumlah Defect : <?=$transaksi_checking['kategori']?></li>

</ul>
            <a herf="<?base_url();?>transaksi_checking" class="btn btn-primary mt-3">Kembali</a>
            <a herf="<?base_url();?>transaksi_checking/ubah/<?=$transaksi_checking['id']?>" class="btn btn-warning mt-3">Ubah</a>
            <a herf="<?base_url();?>transaksi_checking/hapus/<?=$transaksi_checking['id']?>" class="btn btn-danger mt-3" onclick="return confirm('Yakin?');">Hapus</a>

        
</div>
</div>
</div>
<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src = "https://cdn.jsdelivery.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src = "https://cdn.jsdelivery.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src = "https://cdn.jsdelivery.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>






