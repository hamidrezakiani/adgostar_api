<?php
namespace App\Services\Executer;

use App\Http\Resources\Executer\CategoryResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;

class CategoryService extends ResponseTemplate
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'parents')
        {
            $categories = $this->categoryRepository->showParents('readyParticipation');
            $this->setData(new CategoryResource($categories));
        }
        elseif($flag == 'subCats')
        {
            $categories = $this->categoryRepository->showSubCats($search, 'readyParticipation');
            $this->setData(new CategoryResource($categories));
        }
        else
        {
            $this->setStatus(403);
            return $this->response();
        }
        return $this->response();
    }
}
