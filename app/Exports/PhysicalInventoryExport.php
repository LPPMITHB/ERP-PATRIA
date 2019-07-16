<?php

namespace App\Exports;

use App\Models\Snapshot; 
use App\Models\SnapshotDetail; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class PhysicalInventoryExport implements FromCollection, WithHeadings, WithEvents
{
    use Exportable, RegistersEventListeners;

    public function registerEvents(): array
    {
        $temp = Snapshot::find($this->id);

        return [
            // Handle by a closure.
            AfterSheet::class => function(AfterSheet $event) use($temp){
                $date = date('d F Y', strtotime($temp->created_at));
                $total_data = $temp->snapshotDetails->count();

                $headerStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                ];

                $titleStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ];

                $footerStyle = [
                    'font' => [
                        'bold' => true,
                    ],
                ];

                //Make Logo and Title
                $event->sheet->insertNewRowBefore(1,3);
                $event->sheet->mergeCells('A1:H3');
                $event->sheet->setCellValue('A1','LIST STOCK TAKING '.$date);
                $event->sheet->getStyle('A1')->applyFromArray($titleStyle);
                $event->sheet->getStyle('A1')->getAlignment()->setVertical('center');                
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                //Make Header
                $event->sheet->insertNewRowBefore(5,1);
                $event->sheet->mergeCells('A4:A5');
                $event->sheet->mergeCells('B4:B5');
                $event->sheet->mergeCells('C4:C5');
                $event->sheet->mergeCells('D4:D5');
                $event->sheet->mergeCells('H4:H5');
                $event->sheet->setCellValue('E5','Qty');
                $event->sheet->setCellValue('F5','Qty');
                $event->sheet->setCellValue('G5','Qty');
                $event->sheet->getStyle('A4:H5')->getAlignment()->setVertical('center');
                $event->sheet->getStyle('A4:H5')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A4:H5')->applyFromArray($headerStyle);
                $event->sheet->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getColumnDimension('H')->setAutoSize(true);

                $total = 5+$total_data+7;
                //For Data
                $event->sheet->styleCells(
                    'A1:H'.$total,
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => 'thin',
                            ],
                        ]
                    ]
                );

                $footer_start = $total-5;
                //Footer
                $event->sheet->setCellValue('C'.$footer_start,'T O T A L');
                $event->sheet->setCellValue('E'.$footer_start,'=SUM(E6:E'.($total-7).')');
                $event->sheet->setCellValue('F'.$footer_start,'=SUM(F6:F'.($total-7).')');
                $event->sheet->setCellValue('G'.$footer_start,'=SUM(G6:G'.($total-7).')');
                $event->sheet->getStyle('A'.$footer_start.':H'.$footer_start)->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A'.$footer_start.':H'.$footer_start)->applyFromArray($footerStyle);

                $next_footer_start = $footer_start + 2;
                $event->sheet->getStyle('E'.($next_footer_start).':E'.($next_footer_start+1))
                ->getNumberFormat()->setFormatCode('0.00%;[Red]-0.00%');
                $event->sheet->setCellValue('B'.$next_footer_start,'Percentage');
                $event->sheet->setCellValue('C'.$next_footer_start,'Inventories that doesn\'t have a quantity difference');
                $event->sheet->setCellValue('C'.($next_footer_start+1),'Inventories that have a quantity difference');
                $event->sheet->setCellValue('E'.($next_footer_start+1),'=G'.$footer_start.'/E'.$footer_start);
                $event->sheet->setCellValue('E'.($next_footer_start),'=1-E'.($next_footer_start+1));
                $event->sheet->getStyle('E'.($next_footer_start).':E'.($next_footer_start+1))->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A'.($next_footer_start).':E'.($next_footer_start+1))->applyFromArray($footerStyle);
            },
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $temp =SnapshotDetail::where('snapshot_id', $this->id)->get();
        $coll = Collection::make();
        foreach ($temp as $idx => $sd) {
            $coll->push([
                "no" => $idx+1, 
                "material_number" => $sd->material->code,
                "material_desc" => $sd->material->description,
                "unit" => $sd->material->uom->unit,
                "quantity" => $sd->quantity,
                "count" => $sd->count,
                "adjusted_stock" => $sd->adjusted_stock != 0 ? abs($sd->adjusted_stock) : 0,
                "remark" => $sd->adjusted_stock > 0 ? "+" : $sd->adjusted_stock < 0 ? "-" : "",
            ]);
        }
        return $coll;
    }

    public function headings(): array
    {
        return [
            'No',
            'Item No.',
            'Item Description',
            'Unit',
            'System',
            'Actual',
            'Difference',
            'Remarks'
        ];
    }
}
