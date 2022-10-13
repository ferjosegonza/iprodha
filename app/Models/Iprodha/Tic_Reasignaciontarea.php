<?php

namespace App\Models\Iprodha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tic_Reasignaciontarea extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    protected $table = 'iprodha.tic_reasignaciontarea';
    protected $primaryKey = ['idtarea', 'idtarea_vieja'];
    public $incrementing = false;

    protected $fillable = [ 
        'idtarea',    'idtarea_vieja',
        'fecha'
    ];

    // public function getTicket()
    // {
    //     return $this->hasMany(Ticket::class,'idtarea','idtarea');
    // }

    // public function getTicketActual()
    // {
    //     return $this->belongsTo(Ticket::class,'idtarea','idtarea');
    // }

    // public function getTicketAnterior(){
    //     return $this->belongsTo(Ticket::class, 'idtarea_vieja' , 'idtarea');
    // }
    public function getTicket()
    {
        return $this->hasOne(Tic_Tarea::class,'idtarea','idtarea');
    }

    public function getTicketViejo()
    {
        return $this->hasOne(Tic_Tarea::class,'idtarea_vieja','idtarea');
    }
}