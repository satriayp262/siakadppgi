<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    protected $table = 'request_logs';
    protected $fillable = ['method', 'url', 'ip', 'input', 'status_code'];
}
