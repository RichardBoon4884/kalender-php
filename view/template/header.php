<!DOCTYPE html>
<html>
<head>
    <title><?= $htmlentities["title"] ?></title>
    <link rel="stylesheet" href="style/main1.css">
    <link rel="stylesheet" href="style/window.css">
    <script type="text/javascript" src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/main.js"></script>
    <script type="text/javascript" src="scripts/object.js"></script>
    <?php if (isset($htmlentities["headAtr"])) {echo $htmlentities["headAtr"];} ?>
</head>
<body>
<nav id="top"><h1>Kalander</h1><span id="buttonAdd" class="button">Toevoegen</span></nav>