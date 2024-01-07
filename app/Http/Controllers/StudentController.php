<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Rayon;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index( Request $request)
    {
        $student = Student::all();
        $rayon = Rayon::all();
        $rombel = Rombel::all();

        return view('admin.students.index', compact('student'));
    }

    public function student()
    {
        $rayon = Rayon::where('user_id', Auth::user()->id)->first();
        $student = Student::where('rayon_id', $rayon->id)->get();
        $rombel = Rombel::all();

        return view('ps.student', compact('student', 'rayon'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
            'rombel_id' => 'required',
            'rayon_id' => 'required',
        ]);

        Student::create($request->all());

        return redirect()->route('admin.student.home')->with('success', 'Berhasil menambah data siswa');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student, $id)
    {
        $student = Student::find($id);

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
            'rombel_id' => 'required',
            'rayon_id' => 'required',
        ]);

        Student::where('id', $id)->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
        ]);

        return redirect()->route('admin.student.home')->with('success', 'Berhasil mengubah data siswa');
    }

    public function destroy($id)
    {
        Student::where('id', $id)->delete();
        
        return redirect()->route('admin.student.home')->with('success', 'Berhasil menghapus data siswa');
    }
}
