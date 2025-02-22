<?php

namespace App\Http\Controllers\Front;

use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Products\Requests\EvaluatedRequest;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    use ProductTransformable;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $list = $this->productRepo->searchProduct(request()->input('q'));

        $products = $list->where('status', 1)->map(function (Product $item) {
            return $this->transformProduct($item);
        });

        return view('front.products.product-search', [
            'products' => $this->productRepo->paginateArrayResults($products->all(), 10)
        ]);
    }

    /**
     * Get the product
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);
        $product = $this->transformProduct($product);
        $images = $product->images()->get();
        $category = $product->categories()->first();
        $productAttributes = $product->attributes;
        $evaluation = $product -> evaluations() -> latest() -> limit(10) -> get();
        $evaluation = $evaluation -> map(function($item){
            $item['evaluatStar'] = $this -> evaluatToStar($item['evaluat']);
            return $item;
        });

        return view('front.products.product', compact(
            'product',
            'images',
            'productAttributes',
            'category',
            'evaluation'
        ));
    }

    public function evaluatToStar($ev)
    {
        $stars = "";
        for($i = 0; $i < $ev; $i++)
        {
            $stars .= "★";
        }
        for($i = 0; $i < 5 -$ev; $i++)
        {
            $stars .= "☆";
        }
        return $stars;
    }
}
