<?php
/**
 * Created by PhpStorm.
 * User: Office
 * Date: 21.08.2017
 * Time: 18:57
 */
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
        "gorokhov:gorokhov.calendar.detail",
        "",
        Array(
                
        )
);