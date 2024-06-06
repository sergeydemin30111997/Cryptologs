<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Charges extends Model
{
    use HasFactory;
    public function getNameUser() {
        return User::find($this->user_id)->name_telegram;
    }
}
