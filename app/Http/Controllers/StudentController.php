<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('program')->get();
        $programs = Program::all(); 
        $transactions = Payment::all();

        return view('students', compact('students', 'programs','transactions'));
    }

    public function addUser(Request $request){
        $validated = $request->validate([
            'student_number' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'program_id' => 'required|exists:program,id',
        ]);
    
        Student::create([
            'student_number' => $validated['student_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'program_id' => $validated['program_id'],
        ]);
    
        return redirect()->back()->with('success', 'Student added successfully!');
    }

    public function scan(Request $request)
        {
            $barcode = $request->input('barcode');
            $student = Student::where('student_number', $barcode)->first();
            $studentName = Student::where('last_name', $barcode)->first();

            if ($student || $studentName) {
                return view('payment', compact('student'))
                    ->with('success', 'Student barcode scanned successfully.');
            } else {
                return redirect()->back()->with('error', 'Student not found.');
            }
        }
    public function deleteStudent(Student $student){
        $student->delete(); 
        return redirect('/students');
    }
    public function search(Request $request)
    {
        $query = Student::with(['program', 'payments']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('student_number', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhereHas('program', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $students = $query->latest()->paginate(10);
        $programs = Program::all();

        return view('students', compact('students', 'programs'));
    }
}
