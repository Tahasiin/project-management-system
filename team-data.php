<?php

require_once 'Classes/PHPExcel.php';

$connect = mysqli_connect("localhost", "root", "", "pms");

$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheetINdex(0);

$row = 2;
$query = "SELECT * FROM `teams` ";
$result = $connect->query($query);
if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $objPHPExcel->getActiveSheet()
                ->setCellValue('A' . $row, $data->serial_no)
                ->setCellValue('B' . $row, $data->project_id)
                ->setCellValue('C' . $row, $data->supervisor1)
                ->setCellValue('D' . $row, $data->supervisor2)
                ->setCellValue('E' . $row, $data->supervisor3)
                ->setCellValue('F' . $row, $data->student_id)
                ->setCellValue('G' . $row, $data->student_name)
                ->setCellValue('H' . $row, $data->student_email)
                ->setCellValue('I' . $row, $data->student_phone)
                ->setCellValue('J' . $row, $data->project_title)
                ->setCellValue('K' . $row, $data->interested_area)
                ->setCellValue('L' . $row, $data->shift)
                ->setCellValue('M' . $row, $data->type);
        $row++;
        $row++;
        
    }
} else {
    echo "Error: " . $query . "<br>" . $connect->error;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);

$objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'No')
        ->setCellValue('B1', 'Project ID')
        ->setCellValue('C1', 'Supervisor1')
        ->setCellValue('D1', 'Supervisor2')
        ->setCellValue('E1', 'Supervisor3')
        ->setCellValue('F1', 'Student ID')
        ->setCellValue('G1', 'Student Name')
        ->setCellValue('H1', 'Student Email')
        ->setCellValue('I1', 'Cell')
        ->setCellValue('J1', 'Project Title')
        ->setCellValue('K1', 'Area_of_interest')
        ->setCellValue('L1', 'Shift')
        ->setCellValue('M1', 'Type');


$objPHPExcel->getActiveSheet()->getStyle('H1:H'.$objPHPExcel->getActiveSheet()->getHighestRow())
    ->getAlignment()->setWrapText(true); 

$objPHPExcel->getActiveSheet()->getStyle('I1:I'.$objPHPExcel->getActiveSheet()->getHighestRow())
    ->getAlignment()->setWrapText(true); 


$objPHPExcel->getActiveSheet()->getStyle('H1:H'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('I1:I'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    ),
);


$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($style);
//$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);




header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="team-data.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>