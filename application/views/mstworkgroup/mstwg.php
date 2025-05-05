<!DOCTYPE html>
<html>

<head>
    <title>Work Group</title>
</head>

<body>
    <h1>Data Work Group</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Workgroup</th>
            <th>Active</th>
            <th>Id Div</th>
            <th>Id Group Shift</th>
            <th>Zone</th>
        </tr>
        <?php foreach ($operation as $row): ?>
            <tr>
                <td><?= $row->idWG ?></td>
                <td><?= $row->Workgroup ?></td>
                <td><?= $row->Active ?></td>
                <td><?= $row->idDiv ?></td>
                <td><?= $row->idGroupShift ?></td>
                <td><?= $row->zona ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>