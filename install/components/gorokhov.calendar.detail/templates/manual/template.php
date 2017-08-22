<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CJSCore::Init(array("jquery"));
$this->addExternalCss($this->GetFolder()."/css/jquery-ui.css");
$this->addExternalJs($this->GetFolder()."/js/jquery-ui.js");
?>
<?
if(!empty($arResult["CUR_MOUNT"])){
    ?>
    <table cellpadding="10" cellspacing="10" border="1">
        <?
            foreach($arResult["CUR_MOUNT"] as $week){
                ?>
                <tr>
                    <?
                        foreach($week as $day){
                            ?>
                            <td id="<?=$day["TIME"];?>" class="js-click-item">
                                <?=$day["DAY"]?> <?=$day["MOUNT_NAME_SPEECH"]?> <?=$day["YEAR"]?><br>
                                <?=$day["DAY_NAME"];?>
                            </td>
                            <?
                        }
                    ?>
                </tr>
                <?

            }
        ?>

    </table>
    <?
}
?>
<script type="text/javascript">
    JSParamsComponentCalendar = {
        ajaxPath : "<?=$arResult["AJAX_FOLDER"];?>"
    };
</script>
