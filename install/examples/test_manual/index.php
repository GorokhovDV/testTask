<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "12312");
?>
<?
$APPLICATION->IncludeComponent(
        "gorokhov:gorokhov.calendar.detail",
        "manual",
        Array(
        )
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>