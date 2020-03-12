<? use Bitrix\Main\Page\Asset;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<html>

<head>
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle(false);?></title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">

    <?php
    //CSS
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/normalize.css');
    ?>

    <?
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery-3.4.1.min.js');
    ?>
</head>

    <body>

    <?$APPLICATION->ShowPanel();?>
