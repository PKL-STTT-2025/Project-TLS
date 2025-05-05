<!DOCTYPE html>
<html>

<head>
    <title>Operation Breakdown</title>
</head>

<body>
    <h1>Data Operation Breakdown</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Style</th>
            <th>Date Created</th>
        </tr>
        <?php foreach ($operation as $row): ?>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->style ?></td>
                <td><?= $row->date_created ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>