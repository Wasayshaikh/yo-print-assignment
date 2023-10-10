<?php

namespace App\Jobs;

use App\Models\Products;
use App\Models\Uploads;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSVFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $header;
    public $data;
    public $id;
    public function __construct($data, $header,$id)
    {
        $this->data = $data;
        $this->header = $header;
        $this->id = $id;
        Uploads::updateOrCreate(
            ['id' =>  $this->id ],[
                'status' =>'processing'
            ]
        );
        event(new \App\Events\FileUploadEvent('processing'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         
        foreach ($this->data as $item) {
            $item_csv_data = array_combine($this->header,$item);
            Products::updateOrCreate(
                ['UNIQUE_KEY' => $item_csv_data['UNIQUE_KEY']],$item_csv_data);
        };

        $this->status();
        
    }

    public function status(){
        Uploads::updateOrCreate(
            ['id' =>  5 ],[
                'status' =>'Completed'
            ]
        );
        event(new \App\Events\FileUploadEvent('Completed'));
    }
}

