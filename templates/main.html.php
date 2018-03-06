<div class="container">
    <div class="row">
        <div class="column">
            <table>
                <thead>
                <tr>
                    <th>Users</th>
                    <th>Groups</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user => $groups): ?>
                <tr>
                    <td><?=$user?></td>
                    <td><?php foreach ($groups as $group) {echo $group.' ';} ?></td>
                </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table>
                <thead>
                <tr>
                    <th>Groups</th>
                    <th>Users</th>
                </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>