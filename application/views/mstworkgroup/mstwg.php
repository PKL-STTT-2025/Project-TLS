<style>
    .main-container {
        margin-left: 240px;
        /* pastikan ini lebih dari lebar sidebar */
        padding: 20px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #fff;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<div style="margin-left: 50px; padding: 20px;">
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
</div>