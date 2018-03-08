<form method="POST">
    <fieldset>
        <input type="hidden" value="<?=$group?>" name="group">

        <label>
            <p>Group name</p>
            <input type="text" value="<?=$group?>" name="newgroup">
        </label>
        <label for="option">
            <p>Users in this group</p>
        </label>
        <?php foreach($activeusers as $user): ?>
            <input id="option" type="checkbox" name="users[]" value="<?=$user?>" checked> <?=$user?><br>
        <?php endforeach ?>
        <?php foreach($inactiveusers as $user): ?>
            <input id="option" type="checkbox" name="users[]" value="<?=$user?>"> <?=$user?><br>
        <?php endforeach ?>
        <br />
        <input class="button-primary" type="submit" value="Save">
    </fieldset>
</form>