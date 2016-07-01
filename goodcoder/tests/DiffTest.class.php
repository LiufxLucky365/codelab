<?php
/**
 * Diff测试类
 * @author liufuxin 2015.12.13
 */
require('thirdsrc/autoload.php');
require('src/Diff.class.php');

class DiffTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException Exception
	 */
	public function testInitWithWrongType() {
		new Diff('-l examples/diff_file/diff_l -r examples/diff_file/diff_r -t WORONG_TYPE');
	}

	/**
	 * @expectedException Exception
	 */
	public function testInitWithWrongLeftFile() {
		new Diff('-l __FILE_NOT_EXISTES__ -r examples/diff_file/diff_r -t json');
	}

	/**
	 * @expectedException Exception
	 */
	public function testInitWithWrongRightFile() {
		new Diff('-l examples/diff_file/src/diff_l -r __FILE_NOT_EXISTES__ -t json');
	}

	/**
	 * 测试编码设置
	 */
	public function testSetEncode() {
		$objDiff = new Diff('-l examples/diff_file/diff_l -r examples/diff_file/diff_r -t json');

		// 默认utf-8
		$arrOpt = $objDiff->getOption();
		$this->assertEquals('utf-8', $arrOpt['-e']);

		// 设置为gbk
		$objDiff->setEncode('gbk');

		$arrOpt = $objDiff->getOption();
		$this->assertEquals('gbk', $arrOpt['-e']);
	}

	/**
	 * 测试版本输出
	 */
	public function testVersion() {
		$this->assertEquals('0.5', Diff::getVersion());
	}

	/**
	 * 测试json比较
	 */
	public function testJsonDiff() {
		$objDiff = new Diff('-l examples/diff_file/diff_l -r examples/diff_file/diff_r -t json');
		$objDiff->diff();

		// 5处不同
		$this->assertEquals(5, $objDiff->getDiffNum());
	}

	/**
	 * 测试xml比较
	 */
	public function testXmlDiff() {
		$objDiff = new Diff('-l examples/diff_file/diff_l.xml -r examples/diff_file/diff_r.xml -t xml');
		$objDiff->diff();

		// 3处不同
		$this->assertEquals(3, $objDiff->getDiffNum());
	}
}











