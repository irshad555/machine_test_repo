<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\MainController;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyDetailsResource;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;

class CompanyController extends MainController
{
    private $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        parent::__construct();
        $this->companyRepository = $companyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->companyRepository->all($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $companyRepository= $this->companyRepository->save($request);
        return response()->json(['id' => $companyRepository->id, 'message' => Lang::get('messages.create_success')], 201);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CompanyDetailsResource($this->companyRepository->get($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $companyRepository= $this->companyRepository->update($request,$id);
        return response()->json(['id' => $companyRepository->id, 'message' => Lang::get('messages.update_success')], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->companyRepository->delete($id);
        return response()->json(['message' => Lang::get('messages.delete_success')], 200);
    }
}
