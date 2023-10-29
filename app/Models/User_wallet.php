<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_wallet extends Model
{
    use HasFactory;
   protected $table='User_wallets';
    protected $fillable = [
         'user_id',
        'type',
        'amount',
        'reference_id',
        'status'];
}
