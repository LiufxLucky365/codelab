<?php
    //$strTest = "我虽然不是你大爷\n但我却是你爸爸\n你大爷也可以是我\n这行没有关键词\n这行只有你大爷\n这行只有我\n这行两个我我\n";
    //$rule  = "/.*(我|大爷).*(我|大爷).*\n/";

    $strTest = "
    abc\n
    AbC\n
    aAC\n
    AaC\n
    aaC\n";
    $rule  = "/.*(A|C).*(A|C).*\n/";
    $a = preg_match($rule, $strTest, $result);
    print_r($a);
    print_r($result);
    die();

    $strTest = '{"code":1,"message":"db update error[sql] UPDATE  staffUser SET activeStatus=20, activeStatusName=\'\u5df2\u542f\u7528\', staffUname=\'liufuxin\', staffUnameLaw=\'\u5218\u590d\u65b0123\', staffPhone=\'13349895095\', roleId=10, roleName=\'\u767e\u5ea6\u7ba1\u7406\u5458\', companyId=10, companyName=\'\u767e\u5ea6\', updateTime=1478834388 WHERE (staffUid= 310005001) [error] s:50:\"Duplicate entry \'13349895095\' for key \'staffPhone\'\";","result":""}';
    $rule  = "/Duplicate .* for key '([a-zA-Z]+)'/";
    $a = preg_match($rule, $strTest, $result);
    print_r($a);
    print_r($result);
    die();

    $strTest = '/url?q=http://bj.5i5j.com/community/196121&sa=U&ved=0ahUKEwi-ooSi0s_PAhVBrY8KHQ3fB_QQFgg8MAc&usg=AFQjCNE0p3mSd7dg019Iaq-8Bi8FRe5vHw';
    $rule  = "/\/url\?q=(.*)&sa/i";
    $a = preg_match($rule, $strTest, $result);
    print_r($a);
    print_r($result);
    empty($a);
    die();

    $strTest = 'produ@qq.com';
    $rule  = "/.*@baidu.com$/";
    $a = preg_match($rule, $strTest, $result);
    print_r($a);
    print_r($result);
    die();

    /**
     * 1. 不能以test开头
     * 2. 开头必须是数字或字母
     * 3. 只能包含字母 数组 或者_
     */
    $strTest = 'produ';
    $rule  = "/^(?!test)[\da-zA-Z_]+$/";
    $a = preg_match($rule, $strTest, $result);
    print_r($a);
    print_r($result);
    die();

	$target = "[u'appsflyer-data.diff.html', u'com.adamrocker.android.input.simeji_preferences.diff.html']";
    $strRuler = "/u\'(.*?)\'/";
    $arr = preg_match_all($strRuler, $target, $match);
    print_r($match);
	die();

    $resFile = new SplFileObject('/Users/liufuxin/Downloads/query_data.txt', 'rb');
    $arrQuery = array();

    while (!$resFile->eof()) {
        // 解析出 area 和 query
        $strLine = $resFile->current();
        // $strLine = strtolower( trim( iconv("utf-8", "gbk", $strLine) ) );
        // $strLine = "en baseball superstars 2013        en";
        
        $pattern = "/^(en|id|br\s)?(.*?)(en|id|br)?$/";
        $intMatch = preg_match_all($pattern, $strLine, $arrMatch);
        
        // 前后都有area (===4), 以后一个为准
        $strArea = count($arrMatch) === 4 ? $arrMatch[3][0] : $arrMatch[1][0];
        $strQuery = trim($arrMatch[2][0]);
        if (empty($strArea)) {
            // return false;
        }

        print_r($strArea); echo "\t";
        print_r($strQuery);
        echo "\n";

        $resFile->next();
    }

    die();


	$test = "User liufuinx does not have the permission to create issue in the space";
    $strRuler = "/User (.+) does not have the permission to create issue in the space/";
    $arr = preg_match($strRuler, $test, $match);
    print_r($arr);
    print_r($match);
    die();

	$strContent = "nama game nama game this is nama game";

    // 去掉内容开头的name nama 'nama|name game'
    $strContent = preg_replace("/^(nama game|name game|nama|name)/", "", $strContent);
    echo $strContent;
    die();

	$str = "a b   c";

	//  匹配多空格
	preg_match_all('/\s+/i', $str, $ret);
	print_r($ret);

	// 替换多空格为一个
	echo preg_replace("/[\s]+/"," ",$str) . "\n";

	// 替换符号
	$str = ", % & ** ( ) . 。 # @ - _ ";
	