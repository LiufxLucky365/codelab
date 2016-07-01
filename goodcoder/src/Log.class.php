<?php
echo base64_encode('www.prediksibola007.com');
die();


$l = "92.1";
$r = "52.1";
$o = "<";
var_dump(eval("return $l $o $r;"));

Class Log
{
    /**
     * @var 日志的根目录
     */
	private $strBasePath = 'log/';

	/**
	 * 保存错误信息
	 * @param $strMsg string 错误信息
	 * @return int 成功返回写入的字节数, 失败则返回false
	 */
	public static function error($strMsg) {
		$strPath = $this->strBasePath . 'error.log';

		$intWrote = file_put_contents($strPath, $strMsg, FILE_APPEND);

		return $intWrote > 0 ? $intWrote : false;
	}
}




