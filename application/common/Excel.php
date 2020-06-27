<?php

namespace app\common;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    /**
     * 使用PHPEXECL导入
     *
     * @param string $file      文件地址
     * @param int    $sheet     工作表sheet(传0则获取第一个sheet)
     * @param int    $columnCnt 列数(传0则自动获取最大列)
     * @param array  $options   操作选项
     *                          array mergeCells 合并单元格数组
     *                          array formula    公式数组
     *                          array format     单元格格式数组
     *
     * @return array
     * @throws Exception
     */
    public static function import(string $file = '', int $sheet = 0, int $columnCnt = 0, &$options = [])
    {
        try {
            $file = iconv("utf-8", "gb2312", $file); // 转码

            if (empty($file) or !file_exists($file)) {
                throw new \Exception('文件不存在!');
            }

            $objRead = IOFactory::createReader('Xlsx');

            if (!$objRead->canRead($file)) {
                $objRead = IOFactory::createReader('Xls');

                if (!$objRead->canRead($file)) {
                    throw new \Exception('只支持导入Excel文件！');
                }
            }

            empty($options) && $objRead->setReadDataOnly(true); // 如果不需要获取特殊操作，则只读内容，可以大幅度提升读取Excel效率
            $obj = $objRead->load($file); // 建立excel对象
            $currSheet = $obj->getSheet($sheet); // 获取指定的sheet表

            if (isset($options['mergeCells'])) {
                $options['mergeCells'] = $currSheet->getMergeCells(); // 读取合并行列
            }

            if (0 == $columnCnt) {
                $columnH = $currSheet->getHighestColumn(); // 取得最大的列号
                $columnCnt = Coordinate::columnIndexFromString($columnH); // 兼容原逻辑，循环时使用的是小于等于
            }

            $rowCnt = $currSheet->getHighestRow(); // 获取总行数
            $data   = [];

            // 读取内容
            for ($_row = 1; $_row <= $rowCnt; $_row++) {
                $isNull = true;

                for ($_column = 1; $_column <= $columnCnt; $_column++) {
                    $cellName = Coordinate::stringFromColumnIndex($_column);
                    $cellId   = $cellName . $_row;
                    $cell     = $currSheet->getCell($cellId);

                    if (isset($options['format'])) {
                        $format = $cell->getStyle()->getNumberFormat()->getFormatCode(); // 获取格式
                        $options['format'][$_row][$cellName] = $format; // 记录格式
                    }

                    if (isset($options['formula'])) {
                        $formula = $currSheet->getCell($cellId)->getValue(); // 获取公式，公式均为=号开头数据

                        if (0 === strpos($formula, '=')) {
                            $options['formula'][$cellName . $_row] = $formula;
                        }
                    }

                    if (isset($format) && 'm/d/yyyy' == $format) {
                        $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd'); // 日期格式翻转处理
                    }

                    $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());

                    if (!empty($data[$_row][$cellName])) {
                        $isNull = false;
                    }
                }

                // 判断是否整行数据为空，是的话删除该行数据
                if ($isNull) {
                    unset($data[$_row]);
                }
            }

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
