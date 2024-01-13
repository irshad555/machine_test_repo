<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{
      
    /**
     * all
     *
     * @param  mixed $params
     * @return void
     */
    public function all($params)
    {
        $query = DB::table('employees')
      ->select(
          'employees.id',
          'employees.first_name',
          'employees.last_name',
          'employees.email',
          'employees.phone',
          'employees.created_at',
      );
      if (Arr::has($params, 'q')) {
          $query->where(function ($query) use ($params) {
              $query->orWhere("employees.first_name", 'LIKE', "%{$params['q']}%");
              $query->orWhere("employees.last_name", 'LIKE', "%{$params['q']}%");
              $query->orWhere("employees.email", 'LIKE', "%{$params['q']}%");
          });
      }

      return $query->get();
    }
    
    /**
     * save
     *
     * @param  mixed $request
     * @return void
     */
    public function save($request)
    {
       $employee = new Employee();
       $employee->first_name = $request->first_name;
       $employee->last_name = $request->last_name;
       $employee->email = $request->email;
       $employee->phone = $request->phone;
       $employee->company_id = $request->company_id;
       $employee->created_by = Auth::user()->id;
        DB::transaction(function () use ($employee) {
         $employee->save();
        });
        return $employee;
    }    
    /**
     * get
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        $employee = Employee::findOrFail($id);
        return $employee;
    }    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update($request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;
        $employee->updated_by = Auth::user()->id;
         DB::transaction(function () use ($employee) {
          $employee->save();
         });
         return $employee;
    }
       
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        DB::transaction(function () use ($employee) {
            $employee->delete();
        });
    }


   
}
