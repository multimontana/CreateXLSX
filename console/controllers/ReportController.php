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
        //First sheet
        $sheet = $objPHPExcel->getActiveSheet();

        //Start adding next sheets
        $i = 0;
        while ($i < 3) {

            $objWorkSheet = $objPHPExcel->createSheet($i);


            $objPHPExcel->setActiveSheetIndex(0);
            $titles = ['A' => 'Атака', 'B' => 'Запущена', 'C' => 'Время', 'D' => 'Эффективность', 'E' => 'Общий рейтинг', 'F' => 'Изменение',
                'G' => 'Сотрудников', 'H' => 'Выдержали атаку', 'I' => 'Открыли письмо', 'J' => 'Перешли по ссылке', 'K' => 'Открыли вложение',
                'L' => 'Имеют уязвимости', 'M' => 'Ввели данные в форму', 'N' => 'Сообщили об атаке'];

            foreach ($titles as $key => $title) {

                $objPHPExcel->getActiveSheet()->SetCellValue($key . 1, $title);
            }

            $companies = (new \yii\db\Query())
                ->select('*')
                ->from('company')
                ->all();
            foreach ($companies as $key => $company) {
                $rowCount = 2;
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $company['companyName']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, date("d-m-Y", strtotime($company['dateCreate'])));
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, date("h:m", strtotime($company['dateCreate'])));
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '100.00%');
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

            $objWorkSheet->setCellValue('A1', 'Helloeeeeeeeee' . $i)
                ->setCellValue('B2', 'asd!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

            $objWorkSheet->setCellValue('A1', 'Hellorrrrrrrrrrrr' . $i)
                ->setCellValue('B2', 'asd!')
                ->setCellValue('C1', 'Hello')
                ->setCellValue('D2', 'world!');

            $objWorkSheet->setTitle($i == 0 ? "Историа запусков" : ($i == 1 ? "История действий" : "Уязвимости"));

            $i++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('xlsx/template' . time() . '.xlsx');
    }
}
