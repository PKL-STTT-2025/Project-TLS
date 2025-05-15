<h2>Laporan Harian</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Hari</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_harian as $row): ?>
            <tr>
                <td><?= $row->hari ?></td>
                <td><?= $row->jumlah ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>