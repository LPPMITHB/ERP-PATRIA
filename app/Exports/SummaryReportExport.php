<?php

namespace App\Exports;

use App\Models\Bom;
use App\Models\Project;
use App\Models\WBS;
use App\Models\QualityControlTask;
use App\Models\QualityControlTaskDetail;
use App\Models\QualityControlType;
use App\Models\QualityControlTypeDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class SummaryReportExport implements WithEvents
{
    use Exportable, RegistersEventListeners;

    public function registerEvents(): array
    {
        $project = Project::find($this->id);
        $wbss = $project->wbss->pluck('id')->toArray();
        $modelQcTasks = QualityControlTask::whereIn('wbs_id',$wbss)->with('wbs','qualityControlTaskDetails','qualityControlType.qualityControlTypeDetails')->get();

        $wbss = WBS::where('project_id', $this->id)->with('qualityControlTask')->get();

        return [
            // Handle by a closure.
            AfterSheet::class => function(AfterSheet $event) use($modelQcTasks, $wbss, $project){
                $total_data = $wbss->count();

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
                $event->sheet->setCellValue('A1','QC TASK SUMMARY REPORT '.$project->name);
                $event->sheet->getStyle('A1')->applyFromArray($titleStyle);
                $event->sheet->getStyle('A1')->getAlignment()->setVertical('center');                
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                //Make Header
                $event->sheet->insertNewRowBefore(5,1);
                $event->sheet->mergeCells('A4:A5');

                $first_column = "B";
                $last_column = "";
                foreach ($modelQcTasks as $qc_task) {
                    $column = $first_column;

                    $qc_type = $qc_task->qualityControlType;
                    $qc_type_details = $qc_task->qualityControlType->qualityControlTypeDetails;

                    $event->sheet->setCellValue($column.'4',$qc_type->name." - ".$qc_type->description);

                    foreach ($qc_type_details as $qc_type_detail) {
                        $event->sheet->setCellValue($column.'5',$qc_type_detail->name." - ".$qc_type_detail->task_description);
                        $event->sheet->getColumnDimension($column)->setWidth(15);
                        $last_column = $column;
                        $column++;
                    }

                    $event->sheet->mergeCells($first_column.'4:'.$last_column.'4');
                    $first_column = $column;
                }

                // MERGE HEADER
                $event->sheet->mergeCells('A1:'.$last_column.'3');

                // Style Header
                $event->sheet->getStyle('A4:'.$last_column.'5')->getAlignment()->setVertical('center');
                $event->sheet->getStyle('A4:'.$last_column.'5')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A4:'.$last_column.'5')->applyFromArray($headerStyle);

                //Fill Data
                $active_row = 6;
                foreach ($wbss as $wbs) {
                    $event->sheet->setCellValue('A'.$active_row,$wbs->number." - ".$wbs->description);
                    $active_column = "B";
                    foreach ($modelQcTasks as $qc_task) {
                        if($qc_task->wbs_id == $wbs->id){
                            foreach ($qc_task->qualityControlTaskDetails as $qc_task_detail) {
                                $event->sheet->setCellValue($active_column.''.$active_row,$qc_task_detail->status_first);
                                $event->sheet->getStyle($active_column.''.$active_row)->getAlignment()->setVertical('center');
                                $event->sheet->getStyle($active_column.''.$active_row)->getAlignment()->setHorizontal('center');
                                $active_column++;
                            }
                        }else{
                            foreach ($qc_task->qualityControlTaskDetails as $qc_task_detail) {
                                $event->sheet->setCellValue($active_column.''.$active_row,"-");
                                $event->sheet->getStyle($active_column.''.$active_row)->getAlignment()->setVertical('center');
                                $event->sheet->getStyle($active_column.''.$active_row)->getAlignment()->setHorizontal('center');
                                $active_column++;
                            }
                        }
                    }
                    $active_row++;
                }

                $event->sheet->getColumnDimension('A')->setAutoSize(true);

                // $total = 5+$total_data+7;
                $total = 5+$total_data;
                //For Data
                $event->sheet->styleCells(
                    'A1:'.$last_column."".$total,
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => 'thin',
                            ],
                        ]
                    ]
                );

                // $footer_start = $total-5;
                // //Footer
                // $event->sheet->setCellValue('A'.$footer_start,'T O T A L');
                // $event->sheet->setCellValue('A'.($footer_start+1),'OK');
                // $event->sheet->setCellValue('A'.($footer_start+2),'NOT OK');

                // $total_start = "B";
                // foreach ($modelQcTasks as $qc_task) {
                //     foreach ($qc_task->qualityControlTaskDetails as $qc_task_detail) {
                //         // dd('=COUNTIF('.$total_start.'6:'.$total_start."".($total-7).'; "OK")');
                //         $event->sheet->setCellValue($total_start.''.($footer_start+1),'=COUNTIF('.$total_start.'6:'.$total_start.''.($total-7).'; \"OK\")');
                //         $total_start++;
                //     }
                //     }
                // // $event->sheet->setCellValue('E'.$footer_start,'=SUM(E6:E'.($total-7).')');
                // // $event->sheet->setCellValue('F'.$footer_start,'=SUM(F6:F'.($total-7).')');
                // // $event->sheet->setCellValue('G'.$footer_start,'=SUM(G6:G'.($total-7).')');
                // $event->sheet->getStyle('A'.$footer_start.':H'.($footer_start+2))->getAlignment()->setHorizontal('center');
                // $event->sheet->getStyle('A'.$footer_start.':H'.($footer_start+2))->applyFromArray($footerStyle);

                // $next_footer_start = $footer_start + 2;
                // $event->sheet->getStyle('E'.($next_footer_start).':E'.($next_footer_start+1))
                // ->getNumberFormat()->setFormatCode('0.00%;[Red]-0.00%');
                // $event->sheet->setCellValue('B'.$next_footer_start,'Percentage');
                // $event->sheet->setCellValue('C'.$next_footer_start,'Inventories that doesn\'t have a quantity difference');
                // $event->sheet->setCellValue('C'.($next_footer_start+1),'Inventories that have a quantity difference');
                // $event->sheet->setCellValue('E'.($next_footer_start+1),'=G'.$footer_start.'/E'.$footer_start);
                // $event->sheet->setCellValue('E'.($next_footer_start),'=1-E'.($next_footer_start+1));
                // $event->sheet->getStyle('E'.($next_footer_start).':E'.($next_footer_start+1))->getAlignment()->setHorizontal('center');
                // $event->sheet->getStyle('A'.($next_footer_start).':E'.($next_footer_start+1))->applyFromArray($footerStyle);
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

    // public function collection()
    // {
    //     // $temp =SnapshotDetail::where('snapshot_id', $this->id)->get();
    //     $coll = Collection::make();
    //     // foreach ($temp as $idx => $sd) {
    //     //     $coll->push([
    //     //         "no" => $idx+1, 
    //     //         "material_number" => $sd->material->code,
    //     //         "material_desc" => $sd->material->description,
    //     //         "unit" => $sd->material->uom->unit,
    //     //         "quantity" => $sd->quantity,
    //     //         "count" => $sd->count,
    //     //         "adjusted_stock" => $sd->adjusted_stock != 0 ? abs($sd->adjusted_stock) : 0,
    //     //         "remark" => $sd->adjusted_stock > 0 ? "+" : $sd->adjusted_stock < 0 ? "-" : "",
    //     //     ]);
    //     // }
    //     return $coll;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'No',
    //         'Item No.',
    //         'Item Description',
    //         'Unit',
    //         'System',
    //         'Actual',
    //         'Difference',
    //         'Remarks'
    //     ];
    // }
}
