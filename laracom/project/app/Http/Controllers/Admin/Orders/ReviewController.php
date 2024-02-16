<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop\Products\Evaluations;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;

class ReviewController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */

    private $customerRepo;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
    ){
        $this -> customerRepo = $customerRepository;
        $this -> middleware(['permission:update-order,guard:employee'], ['oniy' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responce|\Illuminate\Contracts\View\View
     */

    public function index()
    {
        $reviews = Evaluations::all();

        $reviews = $reviews -> map(function ($item){
            $item['customer_name'] = $this -> customerRepo -> findCustomerById($item['customer_id']) -> name;
            return $item;
        });

        return view('admin.reviews.list', ['reviews' => $reviews]);
    }
}
