<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Iblock\ElementTable;

if (!Loader::includeModule("iblock")) die();

$filter = json_decode($_GET['filter'], true);
$iblockId = 2; // Замените на ваш ID

$res = ElementTable::getList([
    'filter' => ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'], // + dynamic filter
    'select' => ['ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE']
]);

$items = [];
while ($row = $res->fetch()) {
    $row['PICTURE_SRC'] = CFile::GetPath($row['PREVIEW_PICTURE']);
    $items[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['items' => $items]);
