<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::where('status', 'done')->get();
    }

    /**
     * Define the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            'PART NUMBER',
            'DEFINITION',
            'QTY',
            'DATE',
            'BIOMED (Requester)',
            'DEPARTMENT',
            'Reason',
            'Work Order Number',
            'Left in Stock',
        ];
    }

    /**
     * Map the data for each row.
     */
    public function map($order): array
    {
        return [
            $order->part_number,
            $order->definition,
            $order->qty,
            Carbon::parse($order->date)->format('Y-m-d'), // Ensure it's parsed correctly
            $order->biomed->name, // Assuming biomed is a related user model
            $order->department->name, // Assuming department is a related model
            $order->reason,
            $order->work_order_number,
            $order->left_in_stock,
        ];
    }

    /**
     * Apply styles to the sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Set all rows height to 15
        foreach ($sheet->getRowIterator() as $row) {
            $sheet->getRowDimension($row->getRowIndex())->setRowHeight(15);
        }
    
        // Apply styles for the header row (A1:I1)
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'underline' => Font::UNDERLINE_SINGLE,
                'color' => ['argb' => 'FFFFFF'], // Font color white
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'C00000'], // Background color #C00000
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black borders
                ],
            ],
        ]);
    
        // Style for 'PART NUMBER' and 'DEFINITION' (Columns A & B) with background color #92D050
        $sheet->getStyle('A1:B1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '92D050'] // Background color for PART NUMBER & DEFINITION
            ],
        ]);
    
        // Apply text center alignment and underline for all data rows
        $sheet->getStyle('A2:I1000')->applyFromArray([
            'font' => [
                'underline' => Font::UNDERLINE_SINGLE
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black borders
                ],
            ],
        ]);
    
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(15.14); // PART NUMBER
        $sheet->getColumnDimension('B')->setWidth(36.43); // DEFINITION
        $sheet->getColumnDimension('C')->setWidth(8.43);  // QTY
        $sheet->getColumnDimension('D')->setWidth(15.30); // DATE
        $sheet->getColumnDimension('E')->setWidth(21.30); // BIOMED
        $sheet->getColumnDimension('F')->setWidth(21.86); // DEPARTMENT
        $sheet->getColumnDimension('G')->setWidth(8.43);  // Reason
        $sheet->getColumnDimension('H')->setWidth(21.14); // Work Order Number
        $sheet->getColumnDimension('I')->setWidth(12.86); // Left in Stock
    
        // Apply styles to the text from A2 to end with color #4472C4 and borders
        $sheet->getStyle('A2:A1000')->applyFromArray([
            'font' => [
                'color' => ['argb' => '4472C4'], // Text color #4472C4
                'bold' => false,
                'underline' => Font::UNDERLINE_NONE
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black borders
                ],
            ],
        ]);
    
        // Apply styles to the text from B2 to end with color #808080, left aligned, and borders
        $sheet->getStyle('B2:B1000')->applyFromArray([
            'font' => [
                'color' => ['argb' => '808080'], // Text color #808080
                'bold' => false,
                'underline' => Font::UNDERLINE_NONE
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT // Align text to the left
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black borders
                ],
            ],
        ]);
    
        // Apply styles to the text from C2:I1000 with color black, no underline, and borders
        $sheet->getStyle('C2:I1000')->applyFromArray([
            'font' => [
                'color' => ['argb' => '000000'], // Text color black
                'bold' => false,
                'underline' => Font::UNDERLINE_NONE
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Center alignment
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Black borders
                ],
            ],
        ]);
    
        return [];
    }
    
    
        
}
