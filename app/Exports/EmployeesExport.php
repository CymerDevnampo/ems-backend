<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $userRoleId = Auth::user()->role_id;

        if ($userRoleId === 1) {
            $employees = Employee::with(['user.role', 'employeeDetails.position', 'createdBy'])->get();
        } else {
            $employees = Employee::with(['user.role', 'employeeDetails.position', 'createdBy'])
                ->where('created_by', Auth::user()->id)
                ->get();
        }

        return $employees->map(function ($emp) {
            $roleName = $emp->user->role_id ? Role::find($emp->user->role_id)->name : '';

            $positionName = '';
            if (isset($emp->employeeDetails[0])) {
                $positionName = $emp->employeeDetails[0]->position ? Position::find($emp->employeeDetails[0]->position)->name : '';
            }

            return [
                'Employee Number' => $emp->employee_number ?? '',
                'Role' => $roleName ?? '',
                'Created By' => $emp->createdBy->name ?? '',
                'Name' => $emp->user->name ?? '',
                'Email' => $emp->user->email ?? '',
                'Address' => $emp->address ?? '',
                'Birthday' => $emp->birthday,
                'Age' => $emp->age ?? '',
                'Department' => $emp->employeeDetails[0]->department ?? '',
                'Position' => $positionName ?? '',
                'Company' => $emp->employeeDetails[0]->company ?? '',
                'SSS' => $emp->employeeDetails[0]->sss ?? '',
                'TIN' => $emp->employeeDetails[0]->tin ?? '',
                'Philhealth' => $emp->employeeDetails[0]->philhealth ?? '',
                'HDMF' => $emp->employeeDetails[0]->hdmf ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee Number',
            'Role',
            'Created By',
            'Name',
            'Email',
            'Address',
            'Birthday',
            'Age',
            'Department',
            'Position',
            'Company',
            'SSS',
            'TIN',
            'Philhealth',
            'HDMF',
        ];
    }

}
