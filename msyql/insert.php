<?php
    $strDateStart = date("Y-m-d 00:00:00", strtotime("-1 day"));
    $strDateEnd = date("Y-m-d 24:00:00", strtotime("-1 day"));
    echo $strDateEnd;
    echo $strDateStart;
    die();

    $ch = curl_init();
    $api = "http://git.scm.baidu.com:8741/issues/27099.xml?showAssociations=true&include=children";
    $opt = array(
        CURLOPT_URL            => $api,                 //设置url
        CURLOPT_POST           => false,                //设置post标志，以post请求发送
        CURLOPT_RETURNTRANSFER => true,                 //将结果输出到一个文件流中，而不是直接输出到页面
        CURLOPT_HEADER         => false,                //不需要输出http头到输出流中
        CURLOPT_CONNECTTIMEOUT => 10,                   //设置连接等待时间
        CURLOPT_TIMEOUT        => 10                    //设置post请求最大可执行时间
    );
    curl_setopt_array($ch, $opt);
    $data = curl_exec($ch);
    curl_close($ch);
    echo $data;
    die();

    $ch = curl_init();
    $api = "http://pluto.baidu.local.com/PlutoSata/apiTaskDispatch";

    $arrPost = array(
        'name'      => 'test',
        'type'      => 0,
        'cmd'       => 'shell:aaa',
        'targetapk' => 'targetapk',
        'caseapk'   => 'caseapk',
        'skip'      => 'zvhiajnkzljoawegiujmars',
        'requirement' => array(
                'round' => 3,
                'id' => 2,
            )
    );

    $opt = array(
        CURLOPT_URL            => $api,                 //设置url
        CURLOPT_POST           => true,                //设置post标志，以post请求发送
        CURLOPT_POSTFIELDS     => http_build_query($arrPost),
        CURLOPT_RETURNTRANSFER => true,                 //将结果输出到一个文件流中，而不是直接输出到页面
        CURLOPT_HEADER         => false,                //不需要输出http头到输出流中
        CURLOPT_CONNECTTIMEOUT => 10,                   //设置连接等待时间
        CURLOPT_TIMEOUT        => 10                    //设置post请求最大可执行时间
    );
    curl_setopt_array($ch, $opt);
    $data = curl_exec($ch);
    curl_close($ch);
    print_r($data);
    die();

    // 快速插入 n 条数据
    $N = 100000;
    $dbConn = new PDO("mysql:host=127.0.0.1;dbname=test", "root", "");

    $start = microtime(true);

    $sql = "insert into foo (name, age) values (?, ?)";
    $stmt = $dbConn->prepare($sql);

    $i = 0;
    $arrNames = array('liufx', 'wangyn', 'fuck', 'you', 'laopo', 'hehe');
    while ($i++ < $N) {
        $age = rand(0, 5);
        $name = $arrNames[$age];
        // $stmt->execute(array($name, $age));
        
        $sql = "insert into foo (name, age) values ('$name', $age)";
        $stmt = $dbConn->query($sql);
    }

    $end = microtime(true);

    echo $end - $start;
