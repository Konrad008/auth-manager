<form method="POST">
    <fieldset>
        <input type="hidden" value="<?= $user ?>" name="user">
        <label>
            <p>New password</p>
            <input type="text" placeholder="top-secret" name="password">
        </label>
        <input class="button-primary" type="submit" value="Save">
    </fieldset>
</form>