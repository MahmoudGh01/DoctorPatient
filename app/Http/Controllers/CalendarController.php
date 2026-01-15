<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Return appointments formatted for FullCalendar.
     */
    public function appointments(Request $request)
    {
        $cabinetId = $request->query('cabinet_id'); // ?cabinet_id=123

        $query = Appointment::select('id', 'datetime', 'cabinet_id');

        if ($cabinetId) {
            $query->where('cabinet_id', $cabinetId);
        }

        return $query->get()->map(function ($a) {
            return [
                'id'    => $a->id,
                'title' => 'Booked',
                'start' => $a->datetime,
                'color' => '#ef4444',
            ];
        });
    }
}
