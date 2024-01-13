<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyRepository implements CompanyRepositoryInterface
{
      
    /**
     * all
     *
     * @param  mixed $params
     * @return void
     */
    public function all($params)
    {
      $query = DB::table('companies')
      ->select(
          'companies.id',
          'companies.name',
          'companies.email',
          'companies.website',
          'companies.created_at',
      );
      if (Arr::has($params, 'q')) {
          $query->where(function ($query) use ($params) {
              $query->orWhere("companies.name", 'LIKE', "%{$params['q']}%");
              $query->orWhere("companies.email", 'LIKE', "%{$params['q']}%");
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
      $company = new Company();
      $company->name = $request->name;
      $company->email = $request->email;
      $company->website = $request->website;
      $company->logo = $request->logo;
      $company->ext = $request->ext;
      $company->size = $request->size;
      $company->token = $request->token;
      $company->url = $request->url;
      $company->thumbnail_url = $request->thumbnail_url;
      $company->created_by = Auth::user()->id;
      DB::transaction(function () use ($company) {
        $company->save();
        if ($company->url) {
        // saveFile("app/temp/$company->id/logos/{$company->url}", $company->url, $company->thumbnail_url);
        }
    });

      
    return $company;

    }
    public function get($id)
    {
      $company = Company::findOrFail($id);
      return $company;
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
      $company = Company::findOrFail($id);
      $company->name = $request->name;
      $company->email = $request->email;
      $company->website = $request->website;
      $company->logo = $request->logo;
      $company->ext = $request->ext;
      $company->size = $request->size;
      $company->token = $request->token;
      $company->url = $request->url;
      $company->thumbnail_url = $request->thumbnail_url;
      $company->updated_by = Auth::user()->id;
      DB::transaction(function () use ($company) {
        $company->save();
      });
      return $company;
    }
       
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
      $company = Company::findOrFail($id);
      DB::transaction(function () use ($company) {
        $company->delete();
      });
    }


   
}
