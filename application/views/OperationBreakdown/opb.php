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
            <th>Id User</th>
            <th>Id Buyer</th>
            <th>Front Pic</th>
            <th>Id Line</th>
            <th>Json Layout</th>
            <th>Pic Layout</th>
            <th>Parent Id</th>
            <th>Master</th>
            <th>Date Deleted</th>
        </tr>
        <?php foreach ($operation as $row): ?>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->style ?></td>
                <td><?= $row->date_created ?></td>
                <td><?= $row->id_user ?></td>
                <td><?= $row->id_buyer ?></td>
                <td><?= $row->front_pic ?></td>
                <td><?= $row->id_line ?></td>
                <td><?= $row->json_layout ?></td>
                <td><?= $row->pic_layout ?></td>
                <td><?= $row->parent_id ?></td>
                <td><?= $row->master ?></td>
                <td><?= $row->date_deleted ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>