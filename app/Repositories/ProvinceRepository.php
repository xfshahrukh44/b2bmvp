<?php

namespace App\Repositories;

use App\Exceptions\Province\AllProvinceException;
use App\Exceptions\Province\CreateProvinceException;
use App\Exceptions\Province\UpdateProvinceException;
use App\Exceptions\Province\DeleteProvinceException;
use App\Models\Province;

abstract class ProvinceRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Province $province)
    {
        $this->model = $province;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $province = $this->model->create($data);
            
            return [
                'province' => $this->find($province->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find province',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'province' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteProvinceException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find province',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'province' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateProvinceException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $province = $this->model::with('cities')->find($id);
            if(!$province)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find province',
                ];
            }
            return [
                'success' => true,
                'province' => $province,
            ];
        }
        catch (\Exception $exception) {

        }
    }

    public function find_by_slug($slug)
    {
        try 
        {
            $province = $this->model::where('slug', $slug)->first();
            if(!$province)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find province',
                ];
            }
            return [
                'success' => true,
                'province' => $province,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::all();
        }
        catch (\Exception $exception) {
            throw new AllProvinceException($exception->getMessage());
        }
    }
    
    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllProvinceException($exception->getMessage());
        }
    }

    public function search_provinces($query, $pagination)
    {
        $provinces = new Province;

        // name
        if(isset($query['name'])){
            $provinces = $provinces->where('first_name', 'LIKE', '%'. $query['name'].'%')->orWhere('last_name', 'LIKE', '%'. $query['name'].'%');
        }

        // company_name
        if(isset($query['company_name'])){
            $provinces = $provinces->where('company_name', 'LIKE', '%'. $query['company_name'].'%');
        }

        // order_by
        if(isset($query['order_by'])){
            $provinces = $provinces->orderBy('created_at', $query['order_by']);
        }

        return $provinces->paginate($pagination);
    }
}