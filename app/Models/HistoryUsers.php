<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryUsers extends Model
{
    use HasFactory;
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'history_users';
}
