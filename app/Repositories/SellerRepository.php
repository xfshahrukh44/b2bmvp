<?php

namespace App\Repositories;

use App\Exceptions\Seller\AllSellerException;
use App\Exceptions\Seller\CreateSellerException;
use App\Exceptions\Seller\UpdateSellerException;
use App\Exceptions\Seller\DeleteSellerException;
use App\Models\Seller;

abstract class SellerRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Seller $seller)
    {
        $this->model = $seller;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $seller = $this->model->create($data);
            
            return [
                'seller' => $this->find($seller->id)
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
                    'message' => 'Could`nt find seller',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'seller' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteSellerException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'seller' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateSellerException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $seller = $this->model::find($id);
            if(!$seller)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller',
                ];
            }
            return [
                'success' => true,
                'seller' => $seller,
            ];
        }
        catch (\Exception $exception) {

        }
    }

    public function find_by_slug($slug)
    {
        try 
        {
            $seller = $this->model::where('slug', $slug)->first();
            if(!$seller)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller',
                ];
            }
            return [
                'success' => true,
                'seller' => $seller,
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
            throw new AllSellerException($exception->getMessage());
        }
    }
    
    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllSellerException($exception->getMessage());
        }
    }
}