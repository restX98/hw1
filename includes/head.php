<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Il mio sito web</title>
    <?php
    require_once '../classes/AssetMgr.php';
    AssetMgr::addCss('/css/base.css');
    AssetMgr::renderCss();
    AssetMgr::renderJs();
    ?>
</head>
<body>
