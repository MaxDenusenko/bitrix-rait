<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arCurrentValues */

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if(!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE_ID"]!="-"?$arCurrentValues["IBLOCK_TYPE_ID"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

$arComponentParameters = array(
    "PARAMETERS" => array(

        "IBLOCK_TYPE_ID" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("COMPONENT_MAIN_NEWS_IBLOCK_TYPE_ID_PARAMETER"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "news",
            "REFRESH" => "Y",
        ),

        "IBLOCK_ID" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("COMPONENT_MAIN_IBLOCK_ID_PARAMETER"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),

        "ITEM_COUNT" => array(
            "PARENT" => "VISUAL",
            "NAME" => GetMessage("COMPONENT_MAIN_ITEM_COUNT_PARAMETER"),
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ),

        "DISPLAY_PREVIEW_IMAGE" => array(
            "PARENT" => "VISUAL",
            "NAME" => GetMessage("COMPONENT_MAIN_DISPLAY_PREVIEW_IMAGE_PARAMETER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),

        "DISPLAY_DETAIL_PAGE_LINK" => array(
            "PARENT" => "VISUAL",
            "NAME" => GetMessage("COMPONENT_MAIN_DISPLAY_DETAIL_PAGE_LINK_PARAMETER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),

        "SET_TITLE" => array(),
        "CACHE_TIME" => array(),

    ),
);
