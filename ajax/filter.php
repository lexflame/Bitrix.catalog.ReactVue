<?php

    define("NO_KEEP_STATISTIC", true);
    define("NOT_CHECK_PERMISSIONS", true);
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

    use Bitrix\Main\Loader;
    use Bitrix\Iblock\ElementTable;

    if (!Loader::includeModule("iblock")) die();

        use Bitrix\Main\Application;
        use Bitrix\Main\Web\Json;

        $response = Application::getInstance()->getContext()->getResponse();
        $response->addHeader("Content-Type", "application/json");

        $data = [
            'items' => $items,
            'page' => $page,
            'totalPages' => $totalPages
        ];

    }

    header('Content-Type: application/json');
    $response->flush(Json::encode($data));
    die();
