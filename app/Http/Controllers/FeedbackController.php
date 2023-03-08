<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Feedback_Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function store(string $historyId, string $productId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback' => 'required|string',
            'rating' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'failed to send feedback',
                $validator->errors()->first(),
                422
            );
        }

        $feedback = new Feedback();
        $feedback->product_id = $productId;
        $feedback->feedback = $request->feedback;
        $feedback->rating = $request->rating;
        $feedback->save();

        Feedback_Order::firstorCreate([
            'order_id' => $historyId,
            'feedback_id' => $feedback->id,
        ], [
            'order_id' => $historyId,
            'feedback_id' => $feedback->id,
            'username' => auth()->user()->username,
        ]);

        return $this->success(
            'feedback sent',
            [
                'username' => auth()->user()->username,
                'productId' => $productId,
                'feedback' => $feedback,
            ],
            201
        );
    }
}
