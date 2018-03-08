<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css">
    <link rel="stylesheet" href="/assets/css/finalStyle.css">
    <title><?=$title?></title>
</head>
<body>
<header class="header">
    <h1><a href="/">❰Authentication Manager❱</a></h1>
    <nav class="navigation">
        <ul>
            <a href="/useradd"><li>Add User</li></a>
            <a href="/groupadd"><li>Add Group</li></a>
        </ul>
    </nav>
</header>
<main class="container">
    <?=$output?>
</main>

<footer class="footer">
        <div class="row">
            <div class="column">
                <h6>for BlueNote <?=date("Y")?></h6>
            </div>
        </div>
</footer>
</body>
</html>