<!DOCTYPE html>
<html>

<head>
    <title>Work Group</title>
</head>

<body>
    <h1>Data Work Group</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Emp ID</th>
            <th>NIK</th>
            <th>Name</th>
            <th>Gender</th>
        </tr>
        <?php foreach ($operation as $row): ?>
            <tr>
                <td><?= $row->empID ?></td>
                <td><?= $row->NIK ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->gender ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>