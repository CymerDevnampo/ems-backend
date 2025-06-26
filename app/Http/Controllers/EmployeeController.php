<?php

namespace App\Http\Controllers;

use App\Mail\SendCredentials;
use App\Models\EmployeeDetails;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function getEmployee()
    {
        $employee = Employee::with('user', 'employeeDetails', 'createdBy')->where('created_by', Auth::user()->id)->paginate(10);

        $employee->getCollection()->transform(function ($emp) {
            $emp->encrypted_id = encrypt($emp->id);
            return $emp;
        });
        
        return response()->json($employee);
    }

    public function storeEmployee(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'address' => 'required|string',
            'birthday' => 'required|string',
            'age' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'company' => 'required|string',
            'sss' => 'required|string',
            'tin' => 'required|string',
            'philhealth' => 'required|string',
            'hdmf' => 'required|string',
        ]);

        $randomPassword = Str::random(10);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($randomPassword);
        $user->save();

        $yearMonth = now()->format('Ym');
        $lastEmployee = Employee::where('employee_number', 'like', $yearMonth . '%')
            ->orderBy('employee_number', 'desc')
            ->first();

        $nextIncrement = $lastEmployee
            ? ((int) substr($lastEmployee->employee_number, 6)) + 1
            : 1;

        $employeeNumber = $yearMonth . str_pad($nextIncrement, 4, '0', STR_PAD_LEFT);

        $employee = new Employee();
        $employee->created_by = Auth::user()->id;
        $employee->user_id = $user->id;
        $employee->employee_number = $employeeNumber;
        $employee->address = $request->address;
        $employee->birthday = $request->birthday;
        $employee->age = $request->age;
        $employee->save();

        $employeeDetails = new EmployeeDetails();
        $employeeDetails->employee_id = $employee->id;
        $employeeDetails->department = $request->department;
        $employeeDetails->position = $request->position;
        $employeeDetails->company = $request->company;
        $employeeDetails->sss = $request->sss;
        $employeeDetails->tin = $request->tin;
        $employeeDetails->philhealth = $request->philhealth;
        $employeeDetails->hdmf = $request->hdmf;
        $employeeDetails->save();

        // Mail::to($user->email)->send(new SendCredentials($user->email, $randomPassword));

        return response()->json(['message' => 'Employee added successfully.'], 200);
    }

    public function editEmployee($id)
    {
        // dd($id);

        $decryptID = decrypt($id);
        $employee = Employee::with('user', 'employeeDetails')->find($decryptID);
        return response()->json($employee);
    }

    public function updateEmployee(Request $request, $id)
    {
        $decryptID = decrypt($id);
        $employee = Employee::with('user', 'employeeDetails', 'createdBy')->findOrFail($decryptID);

        // dd($decryptID); 

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $employee->user->id,
            'address' => 'required|string',
            'birthday' => 'required|string',
            'age' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'company' => 'required|string',
            'sss' => 'required|string',
            'tin' => 'required|string',
            'philhealth' => 'required|string',
            'hdmf' => 'required|string',
        ]);

        $user = $employee->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $employee->address = $request->address;
        $employee->birthday = $request->birthday;
        $employee->age = $request->age;
        $employee->save();

        $details = $employee->employeeDetails()->first();
        $details->department = $request->department;
        $details->position = $request->position;
        $details->company = $request->company;
        $details->sss = $request->sss;
        $details->tin = $request->tin;
        $details->philhealth = $request->philhealth;
        $details->hdmf = $request->hdmf;
        $details->save();

        return response()->json(['message' => 'Employee updated successfully']);
    }


}
