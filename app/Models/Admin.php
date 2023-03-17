<?php

namespace App\Models;
use App\Concerns\HasRole;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User
{
    use HasFactory,HasApiTokens,Notifiable,HasRole;
    protected $guarded=[];
   
    
}
