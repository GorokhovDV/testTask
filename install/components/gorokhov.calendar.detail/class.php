<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class GorokhovCalendarDetail extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }
    public function GetApp(){
        return $GLOBALS['APPLICATION'];
    }
    public function executeComponent()
    {
        if(isset($_REQUEST["IS_AJAX"]) && $_REQUEST["IS_AJAX"] === "Y" && !empty($_REQUEST["time"])){
            if(\Bitrix\Main\Loader::includeModule("gorokhov.calendar")){
                if(\GorokhovCalendar\Helpers::trySave(strtotime($_REQUEST["time"]))){
                    $this->GetApp()->RestartBuffer();
                    $this->includeComponentTemplate("ajax");
                    echo $this->getApp()->EndBufferContentMan();
                    exit;
                }
            }
            $this->GetApp()->RestartBuffer();
            $this->includeComponentTemplate("error");
            echo $this->getApp()->EndBufferContentMan();
            exit;
        }
        if($this->startResultCache())
        {
            $this->arResult["AJAX_FOLDER"] = $this->GetPath()."/ajax.php";
            if(\Bitrix\Main\Loader::includeModule("gorokhov.calendar")){
                $this->arResult["CUR_MOUNT"] = \GorokhovCalendar\Helpers::RenderTable();
            }
            $this->includeComponentTemplate();
        }
        return true;
    }
}?>
