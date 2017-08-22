<?
IncludeModuleLangFile(__FILE__);
use \Bitrix\Main\ModuleManager,
    \Bitrix\Main\Loader,
    \Bitrix\Main\Localization\Loc;
Class Gorokhov_Calendar extends CModule
{
    var $MODULE_ID = "gorokhov.calendar";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;

    function __construct()
    {
        Loc::loadMessages(__FILE__);
        $this->MODULE_VERSION = "0.0.1";
        $this->MODULE_VERSION_DATE = "18.08.2017";
        $this->MODULE_NAME = "Тестовое задание (Календарь)";
        $this->MODULE_DESCRIPTION = "Данный модуль написан Гороховым Денисом, в качестве демонстрации возможностей)";
    }

    function DoInstall()
    {
        $ibID = $this->InstallIblocks();
        if($hibID = $this->InstallhightLoads()){
            $this->InstallFiles();
            RegisterModule("gorokhov.calendar");
            COption::SetOptionString("gorokhov.calendar","hlblockId",$hibID);
            COption::SetOptionString("gorokhov.calendar","iblockid",$ibID);
            COption::SetOptionString("gorokhov.calendar","SETTINGS_SAVE_HIGHTLOAD","Y");
            COption::SetOptionString("gorokhov.calendar","SETTINGS_SAVE_INFOBLOCK","Y");
            return true;
        }
        return false;
    }

    function DoUninstall()
    {
        $this->UnInstallIblocks();
        $this->UnInstallFiles();
        $ibID = $this->UnInstallhightLoads();
        UnRegisterModule("gorokhov.calendar");
        return true;
    }
    function InstallhightLoads(){
        if(Loader::includeModule('iblock') && Loader::includeModule('highloadblock')){
            $result = \Bitrix\Highloadblock\HighloadBlockTable::add([
                    "NAME" => "CalendarEvents",
                    "TABLE_NAME" => "calendar_events"
            ]);
            if($result->isSuccess()){
                $id = $result->getId();
                $oUserTypeEntity    = new \CUserTypeEntity();
                $aUserFields    = array(
                        'ENTITY_ID'         => 'HLBLOCK_'.$id,
                        'FIELD_NAME'        => 'UF_GCALENDAR_DATE',
                        'USER_TYPE_ID'      => 'datetime',
                        'XML_ID'            => 'UF_GCALENDAR_DATE',
                        'SORT'              => 500,
                        'MULTIPLE'          => 'N',
                        'MANDATORY'         => 'N',
                        'SHOW_FILTER'       => 'N',
                        'SHOW_IN_LIST'      => '',
                        'EDIT_IN_LIST'      => '',
                        'IS_SEARCHABLE'     => 'N',
                        'SETTINGS'          => array(
                        ),
                        'EDIT_FORM_LABEL'   => array(
                                'ru'    => Loc::getMessage("HLOAD_DATE_INSERT_NAME"),
                        ),
                        'LIST_COLUMN_LABEL' => array(
                                'ru'    => Loc::getMessage("HLOAD_DATE_INSERT_NAME"),
                        ),
                        'LIST_FILTER_LABEL' => array(
                                'ru'    => Loc::getMessage("HLOAD_DATE_INSERT_NAME"),
                        ),
                        'ERROR_MESSAGE'     => array(
                                'ru'    => Loc::getMessage("HLOAD_DATE_INSERT_NAME"),
                        ),
                        'HELP_MESSAGE'      => array(
                                'ru'    => Loc::getMessage("HLOAD_DATE_INSERT_NAME"),
                        ),
                );
                $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields );
                if($iUserFieldId > 0){
                    $aUserFields    = array(
                            'ENTITY_ID'         => 'HLBLOCK_'.$id,
                            'FIELD_NAME'        => 'UF_GCALENDAR_CLICK',
                            'USER_TYPE_ID'      => 'datetime',
                            'XML_ID'            => 'UF_GCALENDAR_CLICK',
                            'SORT'              => 500,
                            'MULTIPLE'          => 'N',
                            'MANDATORY'         => 'N',
                            'SHOW_FILTER'       => 'N',
                            'SHOW_IN_LIST'      => '',
                            'EDIT_IN_LIST'      => '',
                            'IS_SEARCHABLE'     => 'N',
                            'SETTINGS'          => array(
                            ),
                            'EDIT_FORM_LABEL'   => array(
                                    'ru'    => Loc::getMessage("HLOAD_DATE_CLICK_NAME"),
                            ),
                            'LIST_COLUMN_LABEL' => array(
                                    'ru'    => Loc::getMessage("HLOAD_DATE_CLICK_NAME"),
                            ),
                            'LIST_FILTER_LABEL' => array(
                                    'ru'    => Loc::getMessage("HLOAD_DATE_CLICK_NAME"),
                            ),
                            'ERROR_MESSAGE'     => array(
                                    'ru'    => Loc::getMessage("HLOAD_DATE_CLICK_NAME"),
                            ),
                            'HELP_MESSAGE'      => array(
                                    'ru'    => Loc::getMessage("HLOAD_DATE_CLICK_NAME"),
                            ),
                    );
                    $iUserFieldId   = $oUserTypeEntity->Add( $aUserFields );
                }
            }
            return $result->getId();
        }
        return false;
    }
    function UnInstallhightLoads(){
        if(Loader::includeModule('iblock') && Loader::includeModule('highloadblock')){
            Bitrix\Highloadblock\HighloadBlockTable::delete(COption::GetOptionString("gorokhov.calendar", "hlblockId"));
        }
    }
    function InstallIblocks()
    {
        global $DB;
        $this->errors = false;
        $iblockID = false;
        if(Loader::includeModule("iblock")){
            $arFields = Array(
                    'ID'=>'calendar_events',
                    'SECTIONS'=>'N',
                    'IN_RSS'=>'N',
                    'SORT'=>100,
                    'LANG'=>Array(
                            'en'=>Array(
                                    'NAME'=>Loc::getMessage("IBLOCK_TYPE_NAME"),
                                    'SECTION_NAME'=>'',
                                    'ELEMENT_NAME'=>Loc::getMessage("IBLOCK_TYPE_ELEMENT_NAME")
                            )
                    )
            );
            $obBlocktype = new \CIBlockType;
            $DB->StartTransaction();
            $res = $obBlocktype->Add($arFields);
            if(!$res)
            {
                $DB->Rollback();
                $this->errors[] = 'Error: '.$obBlocktype->LAST_ERROR;
            }
            else{
                $DB->Commit();
                $ib = new \CIBlock;
                $arFields = Array(
                        "ACTIVE" => "Y",
                        "NAME" => Loc::getMessage("IBLOCK_NAME"),
                        "CODE" => "calendar_events",
                        "LIST_PAGE_URL" => "",
                        "DETAIL_PAGE_URL" => "",
                        "IBLOCK_TYPE_ID" => "calendar_events",
                        "SITE_ID" => $this->getSitesList(),
                        "SORT" => 500
                );
                $iblockID = $ib->Add($arFields);
            }
        }
        if (!$this->errors) {

            return $iblockID;
        } else
            return $this->errors;
    }
    function UnInstallIblocks()
    {
        global $DB;
        $this->errors = false;
        $res = \CIBlock::GetList(
                Array(),
                Array(
                        'TYPE'=>'calendar_events',
                        'SITE_ID'=>$this->getSitesList(),
                ), true
        );
        while($ar_res = $res->Fetch())
        {
            $resElements = \CIBlockElement::GetList([],[
                    "IBLOCK_ID" => $ar_res["ID"]
            ],false,false,["ID"]);
            while($arElement = $resElements->Fetch()){
                \CIBlockElement::Delete($arElement);
            }
            $DB->StartTransaction();
            if(!\CIBlock::Delete($ar_res["ID"]))
            {
                $this->errors[] = GetMessage("IBLOCK_DELETE_ERROR");
                $DB->Rollback();
            }
            else
                $DB->Commit();
        }
        $DB->StartTransaction();
        if(!CIBlockType::Delete('calendar_events')){
            $DB->Rollback();
            $this->errors[] = GetMessage("IBLOCK_TYPE_DELETE_ERROR");
        }
        $DB->Commit();
    }
    function getSitesList(){
        $rsSites = CSite::GetList($by="sort", $order="desc");
        $sites = [];
        while ($arSite = $rsSites->Fetch())
        {
            $sites[] = $arSite["ID"];
        }
        return $sites;
    }
    function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        /*
         * Insert DB UnInstallation
         * */
        if (!$this->errors) {
            return true;
        } else
            return $this->errors;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        $installDir = ( is_dir($_SERVER["DOCUMENT_ROOT"]."/local/modules/gorokhov.calendar") === true )  ? "local" : "bitrix" ;
        $ditDir = ( is_dir($_SERVER["DOCUMENT_ROOT"]."/local/components")  === true )  ? "local" : "bitrix" ;
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/".$installDir."/modules/gorokhov.calendar/install/components", $_SERVER["DOCUMENT_ROOT"]."/".$ditDir."/components/gorokhov", true, true);
        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/".$installDir."/modules/gorokhov.calendar/install/examples", $_SERVER["DOCUMENT_ROOT"]."/", true, true);
        return true;
    }

    function UnInstallFiles()
    {
        $installDir = ( is_dir($_SERVER["DOCUMENT_ROOT"]."/local/components/gorokhov.calendar") === true )  ? "local" : "bitrix" ;
        DeleteDirFilesEx("/".$installDir."/components/gorokhov/gorokhov.calendar");
        DeleteDirFilesEx("/test_manual");
        DeleteDirFilesEx("/test_ui");
        return true;
    }
}