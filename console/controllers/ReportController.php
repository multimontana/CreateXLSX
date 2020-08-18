<?php

namespace console\controllers;

use common\models\Vulnerabilities;
use common\models\Targets;
use common\models\Company;
use common\models\CompanyTargets;
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
        $i = 0;
        $objPHPExcel = new PHPExcel();
        //First sheet
        $sheet = $objPHPExcel->getActiveSheet();

        while ($i < 3) {

            $objWorkSheet = $objPHPExcel->createSheet($i);

            if ($i == 0) {
                $objPHPExcel->setActiveSheetIndex(0);
                $titles = ['A' => 'Атака', 'B' => 'Запущена', 'C' => 'Время', 'D' => 'Эффективность', 'E' => 'Общий рейтинг', 'F' => 'Изменение',
                    'G' => 'Сотрудников', 'H' => 'Выдержали атаку', 'I' => 'Открыли письмо', 'J' => 'Перешли по ссылке', 'K' => 'Открыли вложение',
                    'L' => 'Имеют уязвимости', 'M' => 'Ввели данные в форму', 'N' => 'Сообщили об атаке'];

                foreach ($titles as $key => $title) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($key . 1, $title);
                }

                $companies = Company::find($id)->all();

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
            }
            if ($i == 1) {

                $ids = CompanyTargets::find('companyid', $id)->all();
                $arr = [];
                foreach ($ids as $item) {
                    array_push($arr, $item['targetid']);
                }
                $allData = [];
                foreach ($arr as $a) {
                    $t = (new Targets())->findAll($a);
                    array_push($allData, $t);
                }


                foreach ($allData as $key => $datas) {
                    foreach ($datas as $data) {
                        $rowCount = $key + 1;

                        $objWorkSheet
                            ->setCellValue('A' . $rowCount, $data['email'])
                            ->setCellValue('B' . $rowCount, $data['first_name'])
                            ->setCellValue('C' . $rowCount, $data['comment'])
                            ->setCellValue('D' . $rowCount, $data['moodle_course_timestart'])
                            ->setCellValue('E' . $rowCount, $data['ldap_login'])
                            ->setCellValue('F' . $rowCount, $data['full_name'])
                            ->setCellValue('G' . $rowCount, $data['first_name_transliterate'])
                            ->setCellValue('H' . $rowCount, $data['position'])
                            ->setCellValue('I' . $rowCount, date("d-m-Y", strtotime($data['created_at'])));
                    }

                }
            }
            if ($i == 2) {
                $val = Vulnerabilities::find()->all();

                foreach ($val as $key => $data) {
                    $rowCount = $key + 1;
                    $objWorkSheet
                        ->setCellValue('A' . $rowCount, $data['version'])
                        ->setCellValue('B' . $rowCount, $data['CVE'])
                        ->setCellValue('C' . $rowCount, $data['link'])
                        ->setCellValue('D' . $rowCount, $data['global_id'])
                        ->setCellValue('E' . $rowCount, date("d-m-Y", strtotime($data['created_at'])));
                }

            }
            $objWorkSheet->setTitle($i == 0 ? "Историа запусков" : ($i == 1 ? "История действий" : "Уязвимости"));

            $i++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('xlsx/template' . time() . '.xlsx');
    }
}
