<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';

    const RATE_TYPE_HOURS = 'hours';
    const RATE_TYPE_MONTH = 'month';
    const WORKING_HOURS_COUNT = '8'; // number of working hours

    protected $fillable = [
        'full_name', 'birthday', 'department_id', 'position_id', 'rate_type', 'rate'
    ];

    public static $rules = [
        'full_name' => 'required|unique:employes|max:255',
        'birthday' => 'required|date_format:Y-m-d',
        'department_id' => 'required|integer',
        'position_id' => 'required|integer',
        'rate_type' => 'required',
        'rate' => 'required',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function getRateType()
    {
        return [
            'hours' => 'Почасовая оплата',
            'month' => 'Месячная ставка'
        ][$this->rate_type];
    }

    public function getBirthday()
    {
        $date = strtotime($this->birthday);

        return date('d.m.Y', $date);
    }

    public function getSalary()
    {
        if ($this->rate_type == self::RATE_TYPE_HOURS) {
            return $this->rate * self::WORKING_HOURS_COUNT * $this->countDays(date('Y'), date('m'), [0,6]);
        }

        return $this->rate;
    }

    private function countDays($year, $month, $ignore)
    {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);

        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }

        return $count;
    }

}
