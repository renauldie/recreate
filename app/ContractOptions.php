<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractOptions extends Model
{
    protected $table = 'contract_options';

    protected $fillable = [
        'rank_percentage', 'contract'
    ];
}
