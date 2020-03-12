<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    'NAME' => Loc::getMessage("COMPONENT_MAIN_NEWS_NAME"),
    'DESCRIPTION' => Loc::getMessage("COMPONENT_MAIN_NEWS_DESCRIPTION"),
    'PATH' => array(
        'ID' => 'Main-news'
    ),
);
