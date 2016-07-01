<?php
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=itest_offline", "root", "");
    $file = new SplFileObject('uname', 'rb');
    $intCount = 0;
    $arrUid = array();

    while (!$file->eof()) {
        $uname = trim( $file->current() );
        $file->next();

        $strFindUser = "select uid from user where uname='$uname'";
        $stmt = $pdo->query($strFindUser);
        if (!empty($arrUser = $stmt->fetchAll())) {
            $intUid = intval($arrUser[0]['uid']);
            $arrUid[] = $intUid;

            if (!empty($intUid)) {
                $strFindAddress = "select * from gift_address where uid=$intUid";
                $stmt = $pdo->query($strFindAddress);
                $arrAddress = $stmt->fetchAll();

                if (!empty($arrAddress)) {
                    $arrAddress = $arrAddress[0];
                    if (empty($arrAddress['address'])) {
                        $intCount++;
                    }
                    // echo $arrAddress['uid'].",".$arrAddress['first_name'].",".$arrAddress['address'].",".$arrAddress['tel'].",".$arrAddress['email']."\n";
                }
            }
        }
    }

    echo join(',', $arrUid);
