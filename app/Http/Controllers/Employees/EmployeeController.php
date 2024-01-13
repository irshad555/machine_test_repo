<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\MainController;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeDetailsResource;
use Illuminate\Http\Request;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Lang;

class EmployeeController extends MainController
{

    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        parent::__construct();
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->employeeRepository->all($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employeeRepository= $this->employeeRepository->save($request);
        return response()->json(['id' => $employeeRepository->id, 'message' => Lang::get('messages.create_success')], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EmployeeDetailsResource($this->employeeRepository->get($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employeeRepository= $this->employeeRepository->update($request,$id);
        return response()->json(['id' => $employeeRepository->id, 'message' => Lang::get('messages.update_success')], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->employeeRepository->delete($id);
        return response()->json(['message' => Lang::get('messages.delete_success')], 200);
    }
}
