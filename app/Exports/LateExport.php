<?php

namespace App\Exports;

use App\Models\Late;
use App\Models\Rayon;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LateExport implements FromCollection, WithHeadings ,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::all();

        if ($users['role'] == 'admin') {
            $lates = Late::with('student')->get();

            $students = $lates->groupBy('student_id')->map(function ($late) {
                return [
                    'student' => $late->first()->student,
                    'total_lates' => $late->count()
                ];
            });
            return $students;
        } else {
            $lates = Late::with('student')->get();

            $rayon = Rayon::where('user_id', Auth::user()->id)->first();
            $student = Student::whereHas('late')->withCount('late')->where('rayon_id', $rayon->id)->get();

            $students = $lates->groupBy('student_id')->map(function ($late) {
                return [
                    'student' => $late->first()->student,
                    'total_lates' => $late->count()
                ];
            });
            return $students;
        }
        
       
    }

    public function headings(): array
    {
        return [
            "Nis", "Nama", "Rombel", "Rayon", "Total Keterlambatan"
        ];
    }

    public function map($item): array
    {
        return [
            $item['student']->nis,
            $item['student']->name,
            $item['student']->rombel->rombel,
            $item['student']->rayon->rayon,
            $item['total_lates'],
        ];
    }
}
