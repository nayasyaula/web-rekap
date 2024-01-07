<?php

namespace App\Http\Controllers;

use App\Models\Late;
use App\Models\Rayon;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginAuth(Request $request) 
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);

        if (Auth::attempt($user)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
            } elseif (Auth::user()->role == 'ps') {
                return redirect()->route('pembimbing.dashboard')->with('success', 'Login berhasil');
            }
        } else {
            return redirect()->back()->with('failed', 'Login gagal, Silahkan coba lagi');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah Logout');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {    
       $users = User::all();
       return view('admin.users.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:3', 
            'role' => 'required',
        ]);

        $emailPrefix = substr($request->email, 0, 3);
        $namePrefix = substr($request->name, 0, 3);
        $password = $emailPrefix . $namePrefix;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.home')->with('success', 'Berhasil menambahkan data User!');

       
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|min:3',
            'role' => 'required',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        User::where('id', $id)->update($userData);

        return redirect()->route('admin.user.home')->with('success', 'Berhasil mengubah data user!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data user!');
    }

    public function dashboardAdmin(Request $request)
    {
        return view('admin.home');
    }

    public function dashboardPs(Request $request)
    {
        $rayon = Rayon::where('user_id', Auth::user()->id)->first();
        $student = Student::where('rayon_id', $rayon->id)->count();

        $today = now()->format('Y-m-d');
        $totalLateStudents = Late::whereHas('student', function ($query) use ($rayon) {
            $query->where('rayon_id', $rayon->id);
        })
            ->whereDate('date_time_late', $today)
            ->count();

        return view('ps.dashboard', compact('student', 'rayon', 'totalLateStudents', 'today'));
    }
}
