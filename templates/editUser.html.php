<form method="POST">
    <fieldset>
        <input type="hidden" value="<?= $user ?>" name="user">
        <label>
            <p>Username</p>
            <?php if ($user !== 'admin'): ?>
                <input type="text" id="username" value="<?= $user ?>" name="newuser">
            <?php endif ?>
            <?php if ($user === 'admin'): ?>
                <input type="text" id="username" value="<?= $user ?>" name="newuser" disabled>
            <?php endif ?>
        </label>
        <a class="button button-outline" href="/changepass/<?= $user ?>">Change password</a>
        <label for="option">
            <p>User groups</p>
        </label>
        <?php foreach ($activegroups as $group): ?>
            <?php if ($group !== '' && ($user !== 'admin' || $group !== 'admin')): ?>
                <input id="option" type="checkbox" name="groups[]" value="<?= $group ?>" checked> <?= $group ?><br>
            <?php endif ?>
        <?php endforeach ?>
        <?php if ($inactivegroups !== []): ?>
            <?php foreach ($inactivegroups as $group): ?>
                <input id="option" type="checkbox" name="groups[]" value="<?= $group ?>"> <?= $group ?><br>
            <?php endforeach ?>
        <?php endif ?>
        <br/>
        <input class="button-primary" type="submit" value="Save">
    </fieldset>
</form>