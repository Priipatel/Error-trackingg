<?php

namespace Errorlog\errortrack\Models;

use Illuminate\Database\Eloquent\Model;

class LogResponse extends Model
{
    protected $table = 'response';

	protected $fillable = [
		 'route_name', 'method', 'request', 'response', 'environment', 'project_name',
          ];
}
