<?

namespace GorokhovCalendar;

use \Bitrix\Highloadblock as HL,
    \Bitrix\Main\Loader as Loader;

class Helpers {
    static function SaveIBlock($timestamp = false){
        $itemId = false;
        if(Loader::includeModule("iblock")) {
            $el = new \CIBlockElement;
            $arFields = [
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID" => \COption::GetOptionString("gorokhov.calendar", "iblockid"),
                    "NAME" => date("d.m.Y", $timestamp),
                    "ACTIVE" => "Y"
            ];
            if ($itemId = $el->Add($arFields)) {
                return ($itemId > 0);
            }
        }
        return ($itemId > 0);
    }
    static function SaveHLoad($timestamp = false){
        if(Loader::includeModule("highloadblock")){
            global $DB;
            $data = [
                    "UF_GCALENDAR_DATE" => date($DB->DateFormatToPHP(FORMAT_DATETIME)),
                    "UF_GCALENDAR_CLICK" => date($DB->DateFormatToPHP(FORMAT_DATETIME), $timestamp)
            ];
            $hlblock = HL\HighloadBlockTable::getById(\COption::GetOptionString("gorokhov.calendar","hlblockId"))->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $result = $entity_data_class::add($data);
            return ($result->getId() > 0);
        }
        return false;
    }
    static function trySave($timestamp = false){
        $ret = true;
        if(intval($timestamp) > 0){
            if(\COption::GetOptionString("gorokhov.calendar","SETTINGS_SAVE_HIGHTLOAD","N") === "Y"){
                $ret &= self::SaveHLoad($timestamp);
            }
            if(\COption::GetOptionString("gorokhov.calendar","SETTINGS_SAVE_INFOBLOCK","N") === "Y"){
                $ret &= self::SaveIBlock($timestamp);
            }
        }
        return $ret;
    }
    static function RenderTable($timestamp = false){
        if(!$timestamp){
            $timestamp = strtotime(date("d.m.Y"));
        }
        $j = 1;
        $cal = [];
        $week = -1;
        $mountStart = $mountEnd = false;
        while($j<date("t")){
            $week++;
            for($i = 1; $i<=7;$i++){
                if(($mountStart === false && date("N",strtotime(date("01.m.Y",$timestamp))) > $i) || ($mountEnd === true && date("t",$timestamp) < ($week*7+$i))){
                    if($mountStart === false && date("N",strtotime(date("01.m.Y",$timestamp))) > $i){
                        $reedTimeStamp = strtotime(date("01.m.Y",$timestamp)) - ((date("N",strtotime(date("01.m.Y",$timestamp))) - $i)*24*3600);
                    }elseif(($mountEnd === true && date("t",$timestamp) < ($week*7+$i))){
                        $reedTimeStamp = strtotime(date("t",$timestamp).".".date("m",$timestamp).".".date("Y",$timestamp)) + (($week*7+$i) - date("t",$timestamp) - 1)*24*3600;
                    }
                    $thisMount = false;
                }else{
                    $reedTimeStamp = strtotime($j.".".date("m",$timestamp).".".date("Y",$timestamp));
                    if($mountStart === false && date("N",strtotime(date("01.m.Y",$timestamp))) == $i){
                        $mountStart = true;
                    }
                    if($mountEnd === false && date("t",$timestamp) == ($week*7+$i)){
                        $mountEnd = true;
                    }
                    $thisMount = true;
                    $j++;
                }
                $cal[$week][$i] = [
                        "DAY" => date("d",$reedTimeStamp),
                        "MOUNT" =>  date("m",$reedTimeStamp),
                        "YEAR" =>  date("Y",$reedTimeStamp),
                        "DAY_NAME" =>  FormatDate("l",$reedTimeStamp),
                        "MOUNT_NAME" =>  FormatDate("f",$reedTimeStamp),
                        "MOUNT_NAME_SPEECH" =>  FormatDate("F",$reedTimeStamp),
                        "IS_THIS_MOUNT" =>  $thisMount,
                        "TIME" => date("d.m.Y",$reedTimeStamp)
                ];
            }
        }
        return $cal;
    }
}