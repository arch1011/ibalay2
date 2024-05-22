<?php
include '../database/config.php';

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['landlord_id'])) {
    $ownerId = intval($_GET['landlord_id']); // Ensure it's an integer to prevent SQL injection

    // Fetch owner details from the database based on the selected landlord_id
    $sqlOwnerDetails = "SELECT first_name, last_name FROM landlord_acc WHERE landlord_id = $ownerId";
    $resultOwnerDetails = mysqli_query($conn, $sqlOwnerDetails);

    if ($resultOwnerDetails && mysqli_num_rows($resultOwnerDetails) > 0) {
        $ownerDetails = mysqli_fetch_assoc($resultOwnerDetails);

        // Fetch bh_information details
        $sqlBHInfo = "SELECT * FROM bh_information WHERE landlord_id = $ownerId";
        $resultBHInfo = mysqli_query($conn, $sqlBHInfo);

        // Fetch tenants details by joining rented_rooms and tenant tables
        $sqlTenants = "SELECT t.* FROM tenant t 
                       JOIN rented_rooms rr ON t.TenantID = rr.TenantID 
                       WHERE rr.landlord_id = $ownerId";
        $resultTenants = mysqli_query($conn, $sqlTenants);

        // Create an Excel file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report.xlsx"');
        header('Cache-Control: max-age=0');

        // Initialize PhpSpreadsheet
        require 'vendor/autoload.php';
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Styles for the header row
        $styleHeader = [
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '088F8F'], 'endColor' => ['rgb' => '0000FF']]
        ];

        // Styles for the data rows
        $styleData = [
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'ADD8E6'], 'endColor' => ['rgb' => 'ADD8E6']]
        ];

        // Styles for the merged cells
        $styleMerge = [
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '088F8F'], 'endColor' => ['rgb' => '0000FF']]
        ];

        // Add merged cells
        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Boarding House Report');
        $spreadsheet->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleMerge);

        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Owner Name:');
        $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($styleData);
        $spreadsheet->getActiveSheet()->setCellValue('B2', $ownerDetails['first_name'] . ' ' . $ownerDetails['last_name']);

        // Add bh_information details to the Excel file
        $spreadsheet->getActiveSheet()->mergeCells('A4:B4');
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'bh_information Table');
        $spreadsheet->getActiveSheet()->getStyle('A4:B4')->applyFromArray($styleHeader);

        $row = 5;
        if ($resultBHInfo && mysqli_num_rows($resultBHInfo) > 0) {
            while ($rowBHInfo = mysqli_fetch_assoc($resultBHInfo)) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'BH Name:');
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->applyFromArray($styleData);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $rowBHInfo['BH_name']);
                $spreadsheet->getActiveSheet()->getStyle('B' . $row)->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 1), 'Address:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 1), $rowBHInfo['BH_address']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 1))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 2), 'Monthly Payment Rate:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 2))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 2), $rowBHInfo['monthly_payment_rate']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 2))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), 'Number of Kitchens:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 3), $rowBHInfo['number_of_kitchen']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 3))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 4), 'Number of Living Rooms:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 4))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 4), $rowBHInfo['number_of_living_room']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 4))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 5), 'Number of Rooms:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 5))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 5), $rowBHInfo['number_of_room']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 5))->applyFromArray($styleData);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 6), 'Number of Bathrooms:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 6))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 6), $rowBHInfo['number_of_bathroom']);
                $spreadsheet->getActiveSheet()->getStyle('B' . ($row + 6))->applyFromArray($styleData);
        
                $row += 8; // Move to the next row for the next record
            }
        }

        // Add tenants details to the Excel file
        $spreadsheet->getActiveSheet()->mergeCells('A' . $row . ':B' . $row);
        $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'Tenants Table');
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':B' . $row)->applyFromArray($styleHeader);

        $row++;
        if ($resultTenants && mysqli_num_rows($resultTenants) > 0) {
            while ($rowTenant = mysqli_fetch_assoc($resultTenants)) {
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, 'Tenant Name:');
                $spreadsheet->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $rowTenant['tenant_name']);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 1), 'Contact Number:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 1))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 1), $rowTenant['contact_number']);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 2), 'Gender:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 2))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 2), $rowTenant['gender']);
        
                $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), 'Age:');
                $spreadsheet->getActiveSheet()->getStyle('A' . ($row + 3))->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->setCellValue('B' . ($row + 3), $rowTenant['age']);
        
                $row += 5; // Move to the next row for the next record
            }
        }

        // Save Excel file
        $writer->save('php://output');

    } else {
        echo "Owner not found or no details available.";
    }
} else {
    echo "No owner selected.";
}

mysqli_close($conn);
?>
