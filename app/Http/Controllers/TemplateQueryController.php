<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
const MAX_CHUNK_ROWS = 2500;

class TemplateQueryController implements FromArray, WithTitle, WithHeadings, WithMapping, WithEvents, WithColumnFormatting
{

    protected $rows;
    private $title;
    private $heading;
    private $map;
    private $columnFormat;
    private $colorFormat;

    public function __construct(array $rows, array $map, array $heading, string $title, array $columnFormat=array(), array $colorFormat=array())
    {
        
        set_time_limit(3000); //3000 seconds = 50 minutes
        ini_set('memory_limit', -1);
        $this->title  = $title;
        $this->rows = $rows;
        $this->heading = $heading;
        $this->map = $map;
        $this->columnFormat = $columnFormat;
        $this->colorFormat = $colorFormat;
    }

    /**
     * @return Builder
     */

    public function map($row): array
    {
        $arrMap = array();
        foreach($this->map as $column)
        {
            $arrMap[] = $row[strtolower($column)];
        }

        return $arrMap;
    }
    public function headings(): array
    {
        return $this->heading;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function columnFormats(): array
    {
        return $this->columnFormat;
        // [
        //     'B' => NumberFormat::FORMAT_TEXT,
        //     'C' => NumberFormat::FORMAT_TEXT,
        //     'D' => NumberFormat::FORMAT_TEXT,
        //     'E' => NumberFormat::FORMAT_TEXT,
        //     'F' => NumberFormat::FORMAT_TEXT,
        //     'G' => NumberFormat::FORMAT_TEXT,
        // ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }



    public function registerEvents(): array
    {
        

       


        return [
            // Handle by a closure.
            BeforeImport::class => function(BeforeImport $event) {
                $creator = $event->reader->getProperties()->getCreator();
            },
			
		   
            AfterSheet::class => function(AfterSheet $event) {

                $alphabet = range('A', 'Z');
                
                $jumlahKolom = count($this->heading);
                $jumlahKolom = $jumlahKolom - 1;
                $alphabetAkhir = $alphabet[$jumlahKolom];

                $arrStyle = ['fillType' => 'solid', 'bold' =>  true,'rotation' => 0, 'color' => ['rgb' => 'D9D9D9'], 'align' => 'center'];

                $event->sheet->getStyle('A1:'.$alphabetAkhir.'1')->getFill()->applyFromArray($arrStyle);
                $event->sheet->getDelegate()->getStyle('A1:'.$alphabetAkhir.'1')->getFont()->setBold(true);

                foreach($this->colorFormat as $key => $value)
                {
                    $arrStyle = ['fillType' => 'solid', 'bold' =>  true,'rotation' => 0, 'color' => ['rgb' => $value], 'align' => 'center'];
                    $event->sheet->getStyle($key.'1:'.$key.'1')->getFill()->applyFromArray($arrStyle);
                }
                
                for($i=0;$i<=$jumlahKolom;$i++)
                {
                    $alphabetAutoSize = $alphabet[$i];
                    $event->sheet->getColumnDimension($alphabetAutoSize)->setAutoSize(true) ;
                }

            },
            
                        
        ];
    }
    
    public static function afterSheet(AfterSheet $event) 
    {





    }
}