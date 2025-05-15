<h2><?= $title ?></h2>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Defect</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $row): ?>
            <tr>
                <td><?= $row['hari'] ?></td>
                <td><?= $row['jumlah'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>