<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CJSCore::Init(array("jquery"));
$this->addExternalCss($this->GetFolder()."/css/jquery-ui.css");
$this->addExternalJs($this->GetFolder()."/js/jquery-ui.js");
?>
<div id="datepicker"></div>
<script type="text/javascript">
    JSParamsComponentCalendar = {
        ajaxPath : "<?=$arResult["AJAX_FOLDER"];?>"
    };
</script>