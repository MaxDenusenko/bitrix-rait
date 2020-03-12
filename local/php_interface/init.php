<?php
session_start();

AddEventHandler("iblock", "OnBeforeIBlockElementDelete", array("IBlockHelper", "BeforeDeleteNews"));

CModule::AddAutoloadClasses(
    '',
    array(
        'IBlockHelper' => '/local/php_interface/helpers/IBlockHelper.php',
    )
);
