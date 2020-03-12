<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?>

<?$APPLICATION->IncludeComponent(
    "modified:main_news",
    "",
    Array(
        "CACHE_TIME" => "0",
        "CACHE_TYPE" => "N",
        "DISPLAY_DETAIL_PAGE_LINK" => "Y",
        "DISPLAY_PREVIEW_IMAGE" => "Y",
        "IBLOCK_ID" => "1",
        "IBLOCK_TYPE_ID" => "content",
        "ITEM_COUNT" => "10",
        "SET_TITLE" => "Y"
    )
);?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>