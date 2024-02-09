<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Products\Evaluations;
use App\Shop\Products\Requests\EvaluatedRequest;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param EvaluatedRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function store(EvaluatedRequest $request)
    {
        $productId = $request -> input('product');
        $customerId = auth() -> user() -> getAuthIdentifier();
        $evaluat = $request -> input('evaluat');
        $comment = $request -> input('comment');
        $data = [

            'product_id' => $productId,
            'customer_id' => $customerId,
            'evaluat' => $evaluat,
            'comment' => $comment
        ];

        Evaluations::create($data);

        session() -> flash('success' , '評価とコメントの登録が完了しました');

        return back();
    }
}
