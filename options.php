<?php
global $APPLICATION;

$currentSetting["SETTINGS_SAVE_INFOBLOCK"] = COption::GetOptionString("gorokhov.calendar","SETTINGS_SAVE_INFOBLOCK","N");
$currentSetting["SETTINGS_SAVE_HIGHTLOAD"] = COption::GetOptionString("gorokhov.calendar","SETTINGS_SAVE_HIGHTLOAD","N");
$currentSetting["hlblockId"] = COption::GetOptionString("gorokhov.calendar","hlblockId");
$currentSetting["iblockid"] = COption::GetOptionString("gorokhov.calendar","iblockid");


if(!empty($_REQUEST["GOROKHOV_SAVE"]))
{
    foreach($currentSetting as $key => $val){
        switch($key){
            case "SETTINGS_SAVE_INFOBLOCK":
            case "SETTINGS_SAVE_HIGHTLOAD": {
                if(isset($_REQUEST[$key]) && $_REQUEST[$key] === "Y"){
                    $currentSetting[$key] = $_REQUEST[$key];
                }else{
                    $currentSetting[$key] = "N";
                }
                break;
            }
            default : {
                break;
            }
        }
        COption::SetOptionString("gorokhov.calendar", $key, $currentSetting[$key]);
    }
    $curpage = $APPLICATION->GetCurPageParam();
    LocalRedirect($curpage);
}
$APPLICATION->SetTitle("Настройки модуля \"Тестовое задание\"");
$aTabs = array(
        array("DIV" => "settings", "TAB" => 'Настройки модуля "Тестовое задание"', "ICON"=>"main_user_edit", "TITLE"=>'Настройки модуля "Тестовое задание"'),
);

$tabControl = new CAdminTabControl("tabControl", $aTabs, true, true);
?>
<form name="find_form" method="POST" enctype="multipart/form-data" action="<?=$APPLICATION->GetCurPageParam()?>">
    <?
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    ?>
    <tr>
        <td>
            <div class="dl-adm-form-row">
                <table class="adm-detail-content-table edit-table">
                    <tbody>
                    <tr>
                        <td><input type="checkbox" name="SETTINGS_SAVE_INFOBLOCK" value="Y" id="SETTINGS_SAVE_INFOBLOCK" <?=(( $currentSetting["SETTINGS_SAVE_INFOBLOCK"] === "Y" )?"checked":"")?>></td>
                        <td width="100%"><label for="SETTINGS_SAVE_INFOBLOCK">Сохранять клик в инфоблоке</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="SETTINGS_SAVE_HIGHTLOAD" value="Y" id="SETTINGS_SAVE_HIGHTLOAD" <?=(( $currentSetting["SETTINGS_SAVE_HIGHTLOAD"] === "Y" )?"checked":"")?>></td>
                        <td width="100%"><label for="SETTINGS_SAVE_HIGHTLOAD">Сохранять клик в HightLoad</label></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    <?
    $tabControl->Buttons();
    ?>
    <input type="submit" class="adm-btn-save" name="GOROKHOV_SAVE" value="Сохранить"  />
    <?
    $tabControl->End();
    ?>
</form>
