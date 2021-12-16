<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class FormController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);
        // dd($request->all());

        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();

        return response()->json([
            'message' => 'Student added successfully.',
            'data' => $student
        ], 200);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        // dd($student);

        return response()->json([
            'message' => 'success',
            'data' => $student
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $student = Student::find($id)->delete();
        // dd($student);

        return response()->json([
            'message' => 'Student deleted successfully',
            'data' => $student
        ], 200);
    }
}
