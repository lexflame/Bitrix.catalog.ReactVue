<?php 

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Data\Cache;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CatalogVueAjaxComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']) ?: 3600;
        return $arParams;
    }

    public function executeComponent()
    {
        if (!Loader::includeModule("iblock")) return;

        global $APPLICATION;

        $context = Context::getCurrent();
        $request = $context->getRequest();
        $filter = [];

        if ($request->isAjaxRequest() && $request->get('ajax_filter') === 'Y') {
            $this->includeComponentTemplate(); // пустой ajax-шаблон
            return;
        }

        // Управляемый кеш
        $cache = Cache::createInstance();
        $cacheId = 'catalog_vueajax_' . md5(serialize($this->arParams));
        $cacheTime = $this->arParams['CACHE_TIME'];
        $cachePath = '/custom/catalog/vueajax';

        if ($cache->initCache($cacheTime, $cacheId, $cachePath)) {
            $vars = $cache->getVars();
            $this->arResult = $vars['arResult'];
        } elseif ($cache->startDataCache()) {
            $elements = [];
            $res = ElementTable::getList([
                'filter' => ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'], 'ACTIVE' => 'Y'],
                'select' => ['ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE']
            ]);
            while ($row = $res->fetch()) {
                $row['PICTURE_SRC'] = \CFile::GetPath($row['PREVIEW_PICTURE']);
                $elements[] = $row;
            }

            $this->arResult['ITEMS'] = $elements;

            if (defined("BX_COMP_MANAGED_CACHE")) {
                $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
                $taggedCache->startTagCache($cachePath);
                $taggedCache->registerTag("iblock_id_" . $this->arParams["IBLOCK_ID"]);
                $taggedCache->endTagCache();
            }

            $cache->endDataCache(['arResult' => $this->arResult]);
        }

        $this->includeComponentTemplate();
    }
}
