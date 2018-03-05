<form method="POST">
    <fieldset>
        <label>
            Username
            <input type="text" placeholder="Insert user name" name="user" required>
        </label>
        <label>
            Password
            <input type="password" placeholder="Insert your secret password" name="password" required>
        </label>
        <div>
            <input type="checkbox" id="confirmField">
            <label class="label-inline" for="confirmField">Send a copy to yourself</label>
        </div>
        <input class="button-primary" type="submit" value="Send">
    </fieldset>
</form>