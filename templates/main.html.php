<div class="container">
    <?php if (isset($_COOKIE['notice'])): ?>
    <div class="row">
        <div class="column">
            <h3><?=$_COOKIE['notice']?></h3>
        </div>
    </div>
    <?php unset($_COOKIE['notice']) ?>
    <?= setcookie('notice', null, -1, '/') ?>
    <?php endif ?>
    <div class="row">
        <div class="column">
            <table>
                <thead>
                <tr>
                    <th>Users</th>
<!--                    <th>Hash</th>-->
                    <th>Groups</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $username => $user): ?>
                <tr>
                    <td><?=$user->getUsername()?></td>
<!--                    <td> $user->getHash() </td>-->
                    <td><?=implode(', ', $user->getGroups())?></td>
                </tr>
                <?php endforeach; ?>
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
                <?php foreach($groups as $groupname => $group): ?>
                    <tr>
                        <td><?=$group->getName()?></td>
                        <td><?=implode(', ', $group->getUsers())?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>