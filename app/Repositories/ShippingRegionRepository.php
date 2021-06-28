<?php

namespace App\Repositories;

use App\Exceptions\ShippingRegion\AllShippingRegionException;
use App\Exceptions\ShippingRegion\CreateShippingRegionException;
use App\Exceptions\ShippingRegion\UpdateShippingRegionException;
use App\Exceptions\ShippingRegion\DeleteShippingRegionException;
use App\Models\ShippingRegion;

abstract class ShippingRegionRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(ShippingRegion $shipping_region)
    {
        $this->model = $shipping_region;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $shipping_region = $this->model->create($data);
            
            return [
                'shipping_region' => $this->find($shipping_region->id)
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
                    'message' => 'Could`nt find shipping_region',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'shipping_region' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteShippingRegionException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find shipping_region',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'shipping_region' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateShippingRegionException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $shipping_region = $this->model::find($id);
            if(!$shipping_region)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find shipping_region',
                ];
            }
            return [
                'success' => true,
                'shipping_region' => $shipping_region,
            ];
        }
        catch (\Exception $exception) {

        }
    }

    public function find_by_slug($slug)
    {
        try 
        {
            $shipping_region = $this->model::where('slug', $slug)->first();
            if(!$shipping_region)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find shipping_region',
                ];
            }
            return [
                'success' => true,
                'shipping_region' => $shipping_region,
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
            throw new AllShippingRegionException($exception->getMessage());
        }
    }
    
    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllShippingRegionException($exception->getMessage());
        }
    }
}