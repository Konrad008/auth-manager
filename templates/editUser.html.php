<form method="POST">
    <fieldset>
        <input type="hidden" value="<?=$user?>" name="user">

        <label>
            <p>Username</p>
            <input type="text" value="<?=$user?>" name="newuser">
        </label>
        <a class="button button-outline" href="/changepass/<?=$user?>">Change password</a>
        <label for="option">
        <p>User groups</p>
        </label>
        <?php foreach($activegroups as $group): ?>
        <input id="option" type="checkbox" name="groups[]" value="<?=$group?>" checked> <?=$group?><br>
        <?php endforeach ?>
        <?php foreach($inactivegroups as $group): ?>
        <input id="option" type="checkbox" name="groups[]" value="<?=$group?>"> <?=$group?><br>
        <?php endforeach ?>
        <br />
        <input class="button-primary" type="submit" value="Save">
    </fieldset>
</form>