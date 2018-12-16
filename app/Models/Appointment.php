<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;

class Appointment extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'appointments';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['process_id', 'user_id', 'vet_id_1', 'date_1', 'vet_id_2', 'date_2', 'amount_males', 'amount_females', 'amount_other', 'notes', 'status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function addTreatment()
    {
        $disabled = $this->status == 'approving';
        $btn_color = $this->getTreatmentsCountValue() ? 'btn-primary' : 'btn-warning';

        return '
        <a class="btn btn-xs ' . $btn_color . ' ' . ($disabled ? 'disabled' : '') . '" href="/admin/treatment/create?appointment=' . $this->id . '" title="' . __('Add treatment') . '">
        <i class="fa fa-plus"></i> ' . ucfirst(__('treatment')) . '
        </a>';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function process()
    {
        return $this->belongsTo('App\Models\Process', 'process_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function vet1()
    {
        return $this->belongsTo('App\Models\Vet', 'vet_id_1');
    }

    public function vet2()
    {
        return $this->belongsTo('App\Models\Vet', 'vet_id_2');
    }

    public function treatments()
    {
        return $this->hasMany('App\Models\Treatment', 'appointment_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getProcessLinkAttribute()
    {
        return $this->getLink($this->process, true, '');
    }

    public function getUserLinkAttribute()
    {
        return $this->getLink($this->user, is('admin'));
    }

    public function getVet1LinkAttribute()
    {
        return $this->getLink($this->vet1, is('admin', 'vet'));
    }

    public function getVet2LinkAttribute()
    {
        return $this->getLink($this->vet2, is('admin', 'vet'));
    }

    public function getAnimalsValue()
    {
        $result = '';
        if ($this->amount_males && $this->amount_females) {
            $result .= $this->amount_males . ' / ' . $this->amount_females;
            if ($this->amount_other) {
                $result .= ' | ' . $this->amount_other;
            }

        } else if ($this->amount_other) {
            $result = $this->amount_other;
        } else {
            $result = '-';
        }

        return $result;
    }

    public function getTreatmentsCountValue()
    {
        return data_get_first($this, 'treatments', 'treatments_count', 0);
    }

    public function getDetailAttribute()
    {
        return "{$this->id} - {$this->process->name} ({$this->process->id}) - {$this->user->name} ({$this->date_1} / {$this->date_2})";
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function toArray()
    {
        $data = parent::toArray();

        $data['detail'] = $this->detail;

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($appointment) {
            if (!is('admin') && $appointment->status != 'approving') {
                abort(403);
            }
        });
    }
}
