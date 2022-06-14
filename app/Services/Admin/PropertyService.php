<?php
namespace App\Services\Admin;

use App\Http\Resources\Admin\PropertyCollection;
use App\Lib\ResponseTemplate;
use App\Models\PropertyType;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\Facades\DB;

class PropertyService extends ResponseTemplate
{
    protected $propertyRepository;
    protected $productRepository;
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->productRepository = new ProductRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'productProperties')
        {
            $properties = $this->propertyRepository->getByProduct($search);
            $this->setData(new PropertyCollection($properties));
        }
        elseif($flag == 'all')
        {
            $properties = $this->propertyRepository->all();
            $this->setData(new PropertyResource($properties));
        }
        elseif($flag == 'types') {
            $propertyTypes = PropertyType::all();
            $this->setData($propertyTypes);
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
        if ($request->product_id) {
            $this->propertyRepository->find($id)->product
                ->update(['count_property' => DB::raw('count_property-1')]);
            $this->productRepository->find($request->product_id)
                ->update(['count_property' => DB::raw('count_property+1')]);
        }
       $this->propertyRepository->update($request->all(),$id);
       $property = $this->propertyRepository->find($id);
       return $this->index('productProperties',$property->product_id);
    }

    public function store($request)
    {

      $property = $this->propertyRepository->create($request->all());
       $this->productRepository->find($request->product_id)
            ->update(['count_property' => DB::raw('count_property+1')]);
      return $this->index('productProperties',$property->product_id);
    }
    
    public function delete($id)
    {

      $property = $this->propertyRepository->find($id);
       $this->productRepository->find($property->product_id)
            ->update(['count_property' => DB::raw('count_property-1')]);
      $property->delete();
      return $this->index('productProperties',$property->product_id);
    }
}
