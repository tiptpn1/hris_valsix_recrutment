<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use KDatabase;
use ProsesDokumen;

class ProcessSinkronisasi implements ShouldQueue
{
    protected $JOBS_ID;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct($JOBS_ID)
    {
        $this->JOBS_ID       = $JOBS_ID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $JOB_ID     = $this->JOBS_ID;

        $prosesDokumen = new ProsesDokumen();
        $STATUS_RESULT = $prosesDokumen->sap();

        $sql = " call proc_generate_master_sap() ";
        $hasil = KDatabase::exec($sql);
        {
            $sql = " insert into log_api (url, response) values('".$sql."', 'sukses')";
            KDatabase::exec($sql);
        }
        
        $sql = "UPDATE jobs_log SET 
                    STATUS        = 'SUCCESS',
                    STATUS_RESULT = '$STATUS_RESULT',
                    UPDATED_BY    = 'JOBS',
                    UPDATED_DATE  = CURRENT_TIMESTAMP
                WHERE JOBS_LOG_ID = '$JOB_ID' ";
        KDatabase::exec($sql);

    }
}
