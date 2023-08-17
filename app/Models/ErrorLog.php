<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ErrorLog extends Model {


    protected $casts = [
        'request_data' => 'array',
    ];


    protected $fillable = [
        'method',
        'path',
        'request_data',
        'response_data',
        'created_at',
        'updated_at'
    ];

    /*
     * create log table if not exists
     */
    public function createTable() {
        $table = 'error-log-'.date('Ymd');
        if (!Schema::hasTable($table)) {
            Schema::create($table, function($table){
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('method', 12)->default('');
                $table->string('path', 1024)->default('');
                $table->string('request_data', 1024)->default('');
                $table->longText('response_data');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return  'error-log-'.date('Ymd');
    }
}


