<?php

namespace console\controllers;

use PHPExcel_Writer_Excel2007;
use yii\console\Controller;
use PHPExcel;


class ReportController extends Controller
{
    /**
     * @param $id
     */
    public function actionStart($id)
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $titles = ['A' => 'Атака', 'B' => 'Запущена', 'C' => 'Время', 'D' => 'Эффективность', 'E' => 'Общий рейтинг', 'F' => 'Изменение',
            'G' => 'Сотрудников', 'H' => 'Выдержали атаку', 'I' => 'Открыли письмо', 'J' => 'Перешли по ссылке', 'K' => 'Открыли вложение',
            'L' => 'Имеют уязвимости', 'M' => 'Ввели данные в форму', 'N' => 'Сообщили об атаке'];

        foreach ($titles as $key => $title) {

            $objPHPExcel->getActiveSheet()->SetCellValue($key . 1, $title);
        }

        $companies= (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->limit(10)
            ->all();
        foreach ($companies as $key=>$company) {
            $rowCount = 2;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $company['companyName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, date("d-m-Y", strtotime($company['dateCreate'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, date("h:m",strtotime($company['dateCreate'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount,'100.00%');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '-1036');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '-1036');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '517');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $company['sendAttachment']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '517');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $company['link_text']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $company['attachment_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, '348');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, '0');
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, '');

        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('xlsx/some_excel_file' . time() . '.xlsx');
    }
}
