<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock;

Loc::loadMessages(__FILE__);

class MainNewsClass extends CBitrixComponent
{
    private function setCacheTime()
    {
        if ($this->arParams['CACHE_TYPE'] == 'N') {
            $this->arParams['CACHE_TIME'] = 0;
        } else {
            $this->arParams['CACHE_TIME'] = isset($this->arParams['CACHE_TIME']) && $this->arParams['CACHE_TIME']
                ? $this->arParams['CACHE_TIME'] : 36000000 ;
        }
    }

    private function setPageTitle()
    {
        $rsIBlock = CIBlock::GetList(array(), array(
            "ACTIVE" => "Y",
            "ID" => $this->arParams["IBLOCK_ID"],
            "SITE_ID" => SITE_ID,
        ));
        $IBData = $rsIBlock->GetNext();

        if (!$IBData) {
            ShowError(Loc::getMessage("COMPONENT_MAIN_NOT_FOUND_IBLOCK"));
            return false;
        }
        $this->arResult['PAGE_TITLE'] = $IBData['NAME'];
        return true;
    }

    private function resultData()
    {
        $this->setCacheTime();
        if (!isset($this->arParams['IBLOCK_ID']) || !$this->arParams['IBLOCK_ID']) {
            ShowError(Loc::getMessage("COMPONENT_MAIN_NOT_FOUND_IBLOCK"));
            return false;
        }
        $this->arResult['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
        if (!$this->setPageTitle())
            return false;

        $arNavParams = array(
            "nPageSize" => $this->arParams["ITEM_COUNT"],
            "bShowAll" => 'Y',
        );

        \CPageOption::SetOptionString('main', 'nav_page_in_session', 'N');
        $arNavigation = CDBResult::GetNavParams($arNavParams);

        $this->arResult["ITEMS"] = [];
        $arSelect = array(
            "ID",
            "NAME",
            "TIMESTAMP_X",
            "DETAIL_PAGE_URL",
            "PREVIEW_TEXT",
        );

        if (isset($this->arParams["DISPLAY_PREVIEW_IMAGE"]) && $this->arParams["DISPLAY_PREVIEW_IMAGE"] == 'Y') {
            $arSelect = array_merge($arSelect, ['PREVIEW_PICTURE']);
        }
        $arFilter = array (
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "IBLOCK_LID" => SITE_ID,
            "ACTIVE" => "Y",
        );

        if ($this->StartResultCache(false, [$arNavigation, $arFilter])) {

            $rsElement = CIBlockElement::GetList(false, $arFilter, false, $arNavParams, $arSelect);
            while($obElement = $rsElement->GetNextElement()) {

                $arItem = $obElement->GetFields();
                if (isset($this->arParams["DISPLAY_PREVIEW_IMAGE"]) && $this->arParams["DISPLAY_PREVIEW_IMAGE"] == 'Y') {
                    Iblock\Component\Tools::getFieldImageData(
                        $arItem,
                        array('PREVIEW_PICTURE'),
                        Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
                        'IPROPERTY_VALUES'
                    );
                }

                $arItem["TIMESTAMP_X"] = CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($arItem["TIMESTAMP_X"], CSite::GetDateFormat()));

                $this->arResult["ITEMS"][] = $arItem;
            }

            $this->arResult["NAV_STRING"] = $rsElement->GetPageNavStringEx(
                $navComponentObject,
                $this->arResult['PAGE_TITLE'],
                'my_news',
                false,
                $this
            );

            $this->arResult["NAV_RESULT"] = $rsElement;

            if (isset($_REQUEST["ajax"]) && ($_REQUEST["ajax"] == "yes")) {

                global $APPLICATION;
                $APPLICATION->RestartBuffer();
                $this->includeComponentTemplate();

            } else {
                $this->includeComponentTemplate();
            }
        }
    }

    private function includeModules()
    {
        if (!CModule::IncludeModule('iblock'))
        {
            ShowError(Loc::getMessage("COMPONENT_MAIN_MODULE_ERROR"));
            return false;
        }

        return true;
    }

    public function executeComponent()
    {
        $this->includeModules() && $this->resultData();
    }
}
