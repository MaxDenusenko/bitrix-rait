<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if ($arParams['SET_TITLE'] == 'Y') {
    $APPLICATION->SetTitle($arResult['PAGE_TITLE']);
}
?>

<?php if (count($arResult['ITEMS'])) : ?>
    <div class="item_container">
        <div class="flex_container news-list">
            <?php foreach ($arResult['ITEMS'] as $ITEM) : ?>

                <div class="flex_container-child news-item">

                    <?php if (isset($arParams['DISPLAY_PREVIEW_IMAGE']) && $arParams['DISPLAY_PREVIEW_IMAGE'] == 'Y') : ?>
                        <div class="image_container">
                            <img src="<?=$ITEM['PREVIEW_PICTURE']['SRC']?>" alt="<?= $ITEM['NAME'] ?>">
                        </div>
                    <?php endif; ?>

                    <p><?= $ITEM['PREVIEW_TEXT'] ?></p>

                    <?php if (isset($arParams['DISPLAY_DETAIL_PAGE_LINK']) && $arParams['DISPLAY_DETAIL_PAGE_LINK'] == 'Y') : ?>
                        <a href="<?= $ITEM['DETAIL_PAGE_URL'] ?>">
                            <p><?= $ITEM['NAME'] ?></p>
                        </a>
                    <?php else : ?>
                        <p><?= $ITEM['NAME'] ?></p>
                    <?php endif; ?>

                    <p><small><?= $ITEM['TIMESTAMP_X'] ?></small></p>

                    <p>
                        <?$APPLICATION->IncludeComponent("bitrix:rating.vote","",
                            Array(
                                "ENTITY_TYPE_ID" => "IBLOCK_ELEMENT",
                                "ENTITY_ID" => $ITEM["ID"],
                                "TOTAL_VALUE" => "1",
                            ),
                            null,
                            array("HIDE_ICONS" => "Y")
                        );?>
                    </p>

                </div>

            <?php endforeach; ?>
        </div>

        <?php if ($arResult['NAV_STRING']) : ?>

            <div class="nav_container">
                <?= $arResult['NAV_STRING'] ?>
            </div>

        <?php endif; ?>
    </div>
<?php endif; ?>
