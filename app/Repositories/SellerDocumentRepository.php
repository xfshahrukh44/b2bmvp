<?php

namespace App\Repositories;

use App\Exceptions\SellerDocument\AllSellerDocumentException;
use App\Exceptions\SellerDocument\CreateSellerDocumentException;
use App\Exceptions\SellerDocument\UpdateSellerDocumentException;
use App\Exceptions\SellerDocument\DeleteSellerDocumentException;
use App\Models\SellerDocument;

abstract class SellerDocumentRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(SellerDocument $seller_document)
    {
        $this->model = $seller_document;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $seller_document = $this->model->create($data);
            
            return [
                'seller_document' => $this->find($seller_document->id)
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
                    'message' => 'Could`nt find seller_document',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'seller_document' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteSellerDocumentException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller_document',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'seller_document' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateSellerDocumentException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $seller_document = $this->model::find($id);
            if(!$seller_document)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller_document',
                ];
            }
            return [
                'success' => true,
                'seller_document' => $seller_document,
            ];
        }
        catch (\Exception $exception) {

        }
    }

    public function find_by_slug($slug)
    {
        try 
        {
            $seller_document = $this->model::where('slug', $slug)->first();
            if(!$seller_document)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find seller_document',
                ];
            }
            return [
                'success' => true,
                'seller_document' => $seller_document,
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
            throw new AllSellerDocumentException($exception->getMessage());
        }
    }
    
    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllSellerDocumentException($exception->getMessage());
        }
    }

    public function search_seller_documents($query, $pagination)
    {
        $seller_documents = new SellerDocument;

        // first_name
        if(isset($query['first_name'])){
            $seller_documents =$seller_documents->where('first_name', 'LIKE', '%'. $query['first_name'].'%');
        }

        // last_name
        if(isset($query['last_name'])){
            $seller_documents =$seller_documents->where('last_name', 'LIKE', '%'. $query['last_name'].'%');
        }

        // company_name
        if(isset($query['company_name'])){
            $seller_documents =$seller_documents->where('company_name', 'LIKE', '%'. $query['company_name'].'%');
        }

        // order_by
        if(isset($query['order_by'])){
            $seller_documents =$seller_documents->orderBy('created_at', $query['order_by']);
        }

        return $seller_documents->paginate($pagination);
    }
}