<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNotification extends Model
{
    protected $table = 'detail_notifications';
    Protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'id_notification', 'status']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

}
