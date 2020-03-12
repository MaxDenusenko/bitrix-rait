<?php


class IBlockHelper
{
    public function BeforeDeleteNews($ID)
    {
        $arSelect = Array("ID");
        $arFilter = Array("IBLOCK_ID" => 1, "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        $entityIds = [];

        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $entityIds[$arFields['ID']] = $arFields['ID'];
        }

        if ($entityIds) {
            $entityTypeId = "IBLOCK_ELEMENT";
            $arVoteResult = CRatings::GetRatingVoteResult($entityTypeId, $entityIds);

            $helpArr = [];
            foreach ($arVoteResult as $id => $result) {
                if (isset($result['TOTAL_VALUE'])) {
                    $helpArr[$id] = $result['TOTAL_VALUE'];
                }
            }

            arsort($helpArr);

            foreach ($helpArr as $id_el => $sum) {

                if ($id_el == $ID) {
                    //mail
                    $arEventFields = array(
                        "ID" => $ID,
                    );
                    CEvent::Send("DELETE_GOOD_NEWS", 's1', $arEventFields, 'N');

                }
                break;
            }
        }
    }
}
