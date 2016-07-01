<?php
require_once('src/Log.class.php');

class Diff {
    /**
     * @var 版本信息
     */
    private static $strVersion = '0.5';

    /**
     * @var 配置数组
     */
    private $arrOpt            = array();
    
    /**
     * @var Diff结果上报数组
     */
    private $arrReport         = array();
    
    /**
     * @var 统计不同数目
     */
    private $intDiffNum        = 0;
    
    /**
     * @var 被比较的文件数组
     */
    private $arrLeft           = array();
    private $arrRight          = array();

    /**
     * 输出版本信息
     * @return string 版本信息
     */
    public static function getVersion() {
        return self::$strVersion;
    }

    /**
     * 输出帮助信息
     * @return string 帮助信息
     */
    public static function getUsage() {
        $strUsage = <<<EOF
Usage:
-v print version
-h print this Usage
-l left file which to diff
-r right file which to diff
-t file type, 'json' or 'xml'
-o output file
-e ouput encode, 'utf-8' is default value
EOF;

        return $strUsage;
    }

    /**
     * 从参数字符串中解析并设置配置
     * @param $argument string | array 若是字符串, 空格隔开, 解析为数组 e.g. -t json -l LEFT_FILE -r RIGHT_FIEL ...
     * @return boolean 操作成功返回true
     */
    public function __construct($argument) {
        if (is_array($argument)) {
            $arrArg = $argument;
        } elseif (is_string($argument)) {
            $arrArg = explode(' ', $argument);
        } else {
            $this->error("Excepted 'array' or 'string', but " . gettype($argument) . " given");
        }

        // 允许的参数
        $arrOpt = array(
            '-t' => '',      // 待DIFF的数据/文件类型，测试题要求实现json/xml两种类型的DIFF功能
            '-l' => '',      // 待DIFF的左文件
            '-r' => '',      // 待DIFF的右文件
            '-o' => '',      // 存储对比结果的文件
            '-e' => 'utf-8', // 编码格式，支持gbk和utf8两种格式，默认为utf8
            '-h' => '',      // 输出帮助信息
            '-v' => '',      // 输出版本信息
        );

        // 参数解析，将$arrOpt中对应参数设置响应的值
        while (count($arrArg) > 0) {
            $strArg = array_shift($arrArg);
            if (array_key_exists($strArg, $arrOpt)) {
                // 不需要参数的值
                if (in_array($strArg, array('-h', '-v'))) {
                    $strArgVal = true;
                } else {
                    // 配置项-x后一项即为该配置项的用户定义值
                    $strArgVal = array_shift($arrArg);
                }

                if (!empty($strArgVal)) {
                    if ($strArg == '-t' && !in_array($strArgVal, array('json', 'xml'))) {
                        $this->error("wrong argument value: type $strArgVal");
                    }
                    $arrOpt[$strArg] = is_string($strArgVal) ? strtolower($strArgVal) : $strArgVal;
                } else {
                    $this->error("wrong argument num");
                }
            } else {
                $this->error("wrong argument");
            }
        }

        $this->arrOpt = $arrOpt;

        // 若要获取帮助信息 或者 版本信息则忽略其他配置
        if (!$arrOpt['-h'] && !$arrOpt['-v']) {
            // 解析左侧文件 右侧文件 操作类型
            if (!is_file($arrOpt['-l']) || !is_file($arrOpt['-r'])) {
                $this->error("file not exist");
            }

            // 检查type是否符合预期
            if (!in_array($arrOpt['-t'], array('json', 'xml'))) {
                $this->error("type is illeage: " . $arrOpt['-t']);
            }
            $this->arrLeft  = $this->parse($arrOpt['-l']);
            $this->arrRight = $this->parse($arrOpt['-r']);
        }

        return true;
    }

    /**
     * 获取配置
     * @return array 返回当前配置信息
     */
    public function getOption() {
        return $this->arrOpt;
    }

    /**
     * 获取diff数目
     * @return int diff数目
     */
    public function getDiffNum() {
        return $this->intDiffNum;
    }

    /**
     * 设置输出文件
     * @param $strOutputFile string 输出文件路径
     * @return boolean 正常则返回true
     */
    public function setOutput($strOutputFile) {
        $this->arrOpt['-o'] = $strOutputFile;
        return true;
    }

    /**
     * 设置输出编码
     * @param $strEncode string 目标编码
     * @return boolean 正常则返回true
     */
    public function setEncode($strEncode) {
        $this->arrOpt['-e'] = $strEncode;
        return true;
    }

    /**
     * 文件解析：根据类型进行文件解析，json则将整个文件解析为大的数组，元素为每行的json数组；xml则将整个文件解析为一个数组
     * @param $strFilePath string 目标文件路径
     * @return array 解析后的数组
     */
    private function parse($strFilePath) {
        $resFile   = new SplFileObject($strFilePath, 'rb');
        $arrParsed = array();

        switch ($this->arrOpt['-t']) {
            case 'json':
                while (!$resFile->eof()) {
                    $arrParsed[] = json_decode($resFile->current(), true);
                    $resFile->next();
                }
                break;
            case 'xml':
                $resXml    = simplexml_load_file($strFilePath);
                $arrParsed = json_decode(json_encode($resXml), true);
                break;
        }

        return $arrParsed;
    }

    /**
     * 根据diff类型执行相应的比较动作
     * @return boolean 正常则返回true
     */
    public function diff() {
        switch ($this->arrOpt['-t']) {
            case 'json':
                $this->compareJson();
                break;
            case 'xml':
                $this->compareXml();
                break;
            default:
                break;
        }
        return true;
    }

    /**
     * 比较json类型, 并将比较结果保存到arrReport属性中
     * @return boolean 正常则返回true
     */
    private function compareJson() {
        $arrLeft   = $this->arrLeft;
        $arrRight  = $this->arrRight;
        $arrIdx    = array_unique( array_merge(array_keys($arrLeft), array_keys($arrRight)) );

        $this->arrReport = array_map(function($arrLJson, $arrRJson) {
            return $this->compareArr($arrLJson, $arrRJson);
        }, $arrLeft, $arrRight);

        return true;
    }

    /**
     * 比较xml类型, 并将比较结果保存到arrReport属性中
     * @return boolean 正常则返回true
     */
    private function compareXml() {
        $this->arrReport = $this->compareArr($this->arrLeft, $this->arrRight);

        return true;
    }

    /**
     * 比较左右数组，规则如下：
     * 1. 一个有，一个没有则不同
     * 2. 均有，但一个为数组，一个为字符串，则不同
     * 3. 均有，均为数组，则递归调用
     * 4. 均有，均为字符串，则比较
     * @param $arrLeft array 比较的左侧数组
     * @param $arrRight array 比较的右侧数组
     * @param &$arrNode array 存放比较结果树的引用
     * @return array 比较结果树
     */
    private function compareArr($arrLeft, $arrRight, &$arrNode=array()) {
        // 检查输入
        if (is_null($arrLeft)) {
            return 'left is NULL';
        }
        if (is_null($arrRight)) {
            return 'right is NULL';
        }

        // 获取待diff数组的键值合集
        $arrKey = array_unique( array_merge(array_keys($arrLeft), array_keys($arrRight)) );

        foreach ($arrKey as $key) {
            $lItem    = array_key_exists($key, $arrLeft) ? $arrLeft[$key] : null;
            $rItem    = array_key_exists($key, $arrRight) ? $arrRight[$key] : null;
            $strLType = gettype($lItem);
            $strRType = gettype($rItem);

            // 如果左右该键的值类型相同 则具体再比较
            if ($strLType === $strRType) {
                switch ($strLType) {
                    // 类型为int | string 则直接比较
                    case 'integer':
                    case 'string':
                        if ($lItem !== $rItem) {
                            $this->intDiffNum++;

                            $arrNode[$key] = array(
                                'leaf'  => true,
                                'left'  => $lItem, 
                                'right' => $rItem,
                            );
                        }
                        break;
                    // 类型为array 则递归
                    case 'array':
                        $this->compareArr($lItem, $rItem, $arrNode[$key]);
                        break;
                    default:
                        break;
                }
            } else {
                // 左右类型不同
                $this->intDiffNum++;

                $arrNode[$key] = array(
                    'leaf'  => true,
                    'left'  => $lItem, 
                    'right' => $rItem,
                );
            }
        }

        return $arrNode;
    }

    /**
     * 输出格式化结果
     * @return boolean 正常则返回true
     */
    public function outputResult() {
        printf("there are %d diff[s], next is the detail differences." . PHP_EOL . "++++++++++++" . PHP_EOL, $this->intDiffNum);

        if ($this->arrOpt['-t'] == 'json') {
            foreach ($this->arrReport as $intLineno => $value) {
                $intLineno++;   // 基数从1开始
                echo "---line $intLineno:" . PHP_EOL;

                if (!empty($value)) {
                    $this->outputLine($value);
                } else {
                    echo "parse error";
                }
                echo PHP_EOL;
            }
        }

        if ($this->arrOpt['-t'] == 'xml') {
            $this->outputLine($this->arrReport);
        }

        return true;
    }

    /**
     * 将diff信息数组格式化输出到一行
     * @param $arrLine array | string 正常情况为数组，即diff信息；异常则为string的出错信息
     */
    private function outputLine($arrLine, $strPath='') {
        if (is_array($arrLine)) {
            foreach ($arrLine as $key => $value) {
                if (array_key_exists('leaf', $value) && $value['leaf'] === true) {
                    echo $strPath . "--> $key" . PHP_EOL;
                    echo "\t> " . $value['left'] . PHP_EOL;
                    echo "\t< " . $value['right'] . PHP_EOL;
                } else {
                    $this->outputLine($value, $strPath . "--> $key");
                }
            }
        } else {
            echo $arrLine . PHP_EOL;
        }
    }

    /**
     * 输出结果
     * @return boolean 正常则返回true
     */
    public function output() {
        try {
            ob_start();
            $this->outputResult();
            $strOut = ob_get_contents();
            ob_clean();

            // 检查编码
            $strOut = iconv($this->arrOpt['-e'], 'gbk', $strOut);

            // 检查输出文件
            if (!empty($this->strOutputFile)) {
                $resFile = new SplFileObject($this->arrOpt['-o'], 'a');
                $resFile->fwrite($strOut);
            } else {
                echo $strOut;
            }
        } catch (Exception $e) {
            $this->error('输出文件异常: ' .$e->getMessage());
        }

        return true;
    }

    /**
     * 自定义抛出异常
     * @param $strMsg string 错误信息
     * @return boolean 正常返回true
     */
    private function error($strMsg) {
        // 记入日志
        Log::error($strMsg);

        // 抛出异常
        throw new Exception($strMsg);

        return true;
    }
}



