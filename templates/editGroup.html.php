<form method="POST">
    <fieldset>
        <input type="hidden" value="<?= $group ?>" name="group">

        <label>
            <p>Group name</p>
            <?php if ($group !== 'admin'): ?>
                <input type="text" id="username" value="<?= $group ?>" name="newgroup">
            <?php endif ?>
            <?php if ($group === 'admin'): ?>
                <input type="text" id="username" value="<?= $group ?>" name="newgroup" disabled>
            <?php endif ?>
        </label>
        <label for="option">
            <p>Users in this group</p>
        </label>
        <?php foreach ($activeusers as $user): ?>
            <?php if ($user !== '' && ($user !== 'admin' || $group !== 'admin')): ?>
                <input id="option" type="checkbox" name="users[]" value="<?= $user ?>" checked> <?= $user ?><br>
            <?php endif ?>
        <?php endforeach ?>
        <?php foreach ($inactiveusers as $user): ?>
            <?php if ($user !== ''): ?>
                <input id="option" type="checkbox" name="users[]" value="<?= $user ?>"> <?= $user ?><br>
            <?php endif ?>
        <?php endforeach ?>
        <br/>
        <input class="button-primary" type="submit" value="Save">
    </fieldset>
</form>