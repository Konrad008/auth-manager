<div class="row">
    <div class="column">
        <table>
            <thead>
            <tr>
                <th>User</th>
                <th>Groups</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user => $groups): ?>
                <tr>
                    <td><?= $user ?></td>
                    <td><?php foreach ($groups as $group) {
                            echo $group . ' ';
                        } ?></td>
                    <td class="iamlazy"><span class="mainpage-button"><a href="/useredit/<?= $user ?>">✎</a></span></td>
                        <td class="iamlazy"><?php if ($user !== 'admin'): ?><span class="mainpage-button"><a href="/userdelete/<?= $user ?>">✗</a></span><?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="column">
        <table>
            <thead>
            <tr>
                <th>Group</th>
                <th>Users</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($grupy as $group => $users): ?>
                <tr>
                    <td><?= $group ?></td>
                    <td><?php foreach ($users as $user) {
                            echo $user . ' ';
                        } ?></td>
                    <td class="iamlazy"><span class="mainpage-button"><a href="/groupedit/<?= $group ?>">✎</a></span>
                    </td>
                    <td class="iamlazy"><?php if ($group !== 'admin'): ?><span class="mainpage-button"><a href="/groupdelete/<?= $group ?>">✗</a></span><?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>