<?php
    $arrTarget = [];
    $objTarget = new SplFileObject('search_phone', 'rb');
    while(!$objTarget->eof()) {
        $strLine = strtolower($objTarget->current());
        list($strModel, $strBrand) = explode(' ', $strLine);
        $arrTarget[] = [
            'model' => str_replace('+', ' ', trim($strModel)),
            'brand' => trim($strBrand),
        ];
        $objTarget->next();
    }
    // print_r($arrTarget);


    $objPDO = new PDO("mysql:host=127.0.0.1;dbname=pluto_offline;port=3306;charset=utf8;", 'root', '');
    $arrResult = [];

    foreach ($arrTarget as $item) {
        $objStmt = $objPDO->query("SELECT 
            p.id, p.phoneModel, p.phoneBrand, d.product, a.name
            from t_pluto_phone as p 
            left join t_pluto_product as d on p.product=d.product
            left join t_pluto_product_auth as a on d.id=a.product_id and (a.role='charger' or a.role='manage')
            where p.phoneModel='{$item['model']}' and p.phoneBrand='{$item['brand']}'
        ");
        $arrRet = $objStmt->fetchAll(PDO::FETCH_ASSOC);
        if ($arrRet) {
            // print_r($arrRet);
            $arrResult = array_merge($arrResult, $arrRet);
        }
    }

    foreach ($arrResult as $item) {
        $item['name'] = iconv("utf-8", "gbk", $item['name']);
        echo join(',', $item) . "\n";
    }




