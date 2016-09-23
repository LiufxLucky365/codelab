<?php
function isMobile($mobile) {
    if (!is_numeric($mobile)) {
    }
    $ret = preg_match_all('/1\d{10}/', $mobile, $match);
    var_dump($match);
    return $ret;
}

$phone = "0791-87887887887881727，13837958853,13837958853";
$a = isMobile($phone);
var_dump($a);
die();


function test($a = null) {
    var_dump($a);
}
test(array());
die();


$a = [1, 3, 4, '好'];
print_r(json_encode($a));
die();

$a = [1, 3, 4];
var_dump(in_array("3a", $a));
var_dump(in_array("3a", $a, true));

var_dump(intval("2a2e"));
var_dump("1e2112" == "1e211");
var_dump("0e132456789"=="0e7124511451155");
die();

class foo
{
    public function send() {
        $param = array(
            'a' => 1,
            'b' => 2,
        );
        return call_user_func_array(array($this, '_send'), array($param));
        // $this->_send($param);
    }

    public function _send($a) {
        var_dump($a);
    }
}

$objFoo = new foo();
$objFoo->send();
die();


$floatRight = (float) 0;
var_dump($floatRight);
switch ($floatRight) {
    case ($floatRight>=0 && $floatRight<0.3):
        $arrSortClass[1]++;
        break;
    case ($floatRight>=0.8 && $floatRight<=1):
        $arrSortClass[2]++;
        break;
    default:
        break;
}
var_dump($arrSortClass);
die();


$ss = '\u4e2d\u65e5\u53cb\u597d\u533b\u9662';
echo mb_convert_encoding($ss, 'utf-8', 'gbk');
die();

$string = "●●●●●●●●●●13380";
echo substr($string, -5);
die();

$data = file_get_contents('/Users/liufuxin/Downloads/pluto_iphone_report_file.log');

$plistBegin   = '<?xml version="1.0"';
$plistEnd   = '</plist>';
$pos1 = strpos($data, $plistBegin);
$pos2 = strpos($data, $plistEnd);
$data2 = substr ($data,$pos1,$pos2-$pos1);
echo $data2;
die();


$v3 = '值';
    $v4 = &$v3;
    unset($v4);
    var_dump($v3, $v4);
die();

$tmp = 0 == "a"? 1: 2; 
var_dump($tmp);
die();

$a = array(
            'taskid'         => 475,
            'taskname'       => 'musi_monkey_case',
            'type'           => 0,
            'cmd'            => 'shell:monkey --pct-touch 55 --pct-motion 45 -v --throttle 100 -p com.baidu.sumeru.implugin 8000',
            'targetapk'      => 'http://172.22.132.248/im-plugin/timely/2016_01_21_16_46_54/ActivityMain-debug.apk',
            'caseapk'        => '',
            'reportdir'      => '/mnt/sdcard/musi_report',
            'screenshotRate' => 5,
            'uninstallApk'   => 1,
        );
echo json_encode($a);die();


$strGPApi = 'http://api.9apps.com/app/search';

// e.g. http://api.9apps.com/app/search?v=2&langCode=id&app=kbxxx&start=0&keyword=coc&versionCode=43&um_ch=&gp=0&platformId=1&size=20
$arrOpt = array(
    'v'           => 2,
    'app'         => 'kbxxx',
    'start'       => 0,
    'versionCode' => 43,
    'um_ch'       => '',
    'gp'          => 0,
    'platformId'  => 1,
    'keyword'     => 'facebook',
    'langCode'    => 'id',
    'size'        => 10,
);
$strUrlReq = $strGPApi . "?" . http_build_query($arrOpt);
$jsonRet = get($strUrlReq, 10);

if ($jsonRet !== false) {
    $arrRet = json_decode($jsonRet, true);
    print_r($arrRet);die();

    $arrApp = array_map(function($item) use ($strAreaReal) {
        static $intRank = 1;    // app搜索中的排名

        return array(
            'rank'          => $intRank++,
            'app_name'      => $item['title'],
            'app_icon'      => $item['icon'],
            'app_package'   => $item['package_name'],
            'app_packageid' => $item['package_id'],
            'app_score'     => (int) $item['rate_score'],
            'all_download'  => (int) $item['download_total'],
        );
    }, $arrRet['apps']);
}


	
	function get($api, $CURLOPT_TIMEOUT=5, $header=false, $headers=array()){
		$ch = curl_init();
		$opt=array(
			CURLOPT_URL            => $api,					//设置url
			CURLOPT_POST           => false,  				//设置post标志，以post请求发送
			CURLOPT_RETURNTRANSFER => true,       //将结果输出到一个文件流中，而不是直接输出到页面
			CURLOPT_HEADER         => $header,				//不需要输出http头到输出流中
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_CONNECTTIMEOUT => 10, 		//设置连接等待时间
			CURLOPT_TIMEOUT        => $CURLOPT_TIMEOUT					//设置post请求最大可执行时间
		);
		curl_setopt_array($ch, $opt);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
