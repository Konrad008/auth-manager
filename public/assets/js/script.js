(function () {
    // No special chars in usernames and group names!
    var el = document.getElementById('username');
    if (el !== null) {
        el.onkeypress = function (e) {
            var prohibited = "!@#$%^&*()+=;:`~\|'?/.><, \"_-][}{\\-";
            var key = String.fromCharCode(e.which);
            if (prohibited.indexOf(key) >= 0) {
                console.log('Invalid key pressed!');
                return false;
            }
            return true;
        };
    }
})();