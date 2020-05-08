<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->get('data');

        if (empty($data)) {
            abort(500, 'Wrong data');
        }
        if (empty($data['phone'])) {
            abort(404, 'Please enter phone');
        }
        if (empty($data['address'])) {
            abort(404, 'Please enter address');
        }
        if (!Auth::check() && empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            abort(404, 'Please enter email');
        }
        if (empty($data['items'])) {
            abort(404, 'There is no pizza in order');
        }

        if (!Auth::check()) {
            $userId = User::where('email', $data['email'])->value('id') ?? null;
        } else {
            $userId = Auth::user()->id;
        }

        $toTime = Carbon::now();
        if ($data['byTime'] && $data['deliveryTime']) {
            $startDay = Carbon::create(null, null, null);
            list($hours, $minutes) = explode(':', $data['deliveryTime']);
            $deliveryTime = $hours * 3600 + $minutes * 60;

            if (Carbon::now()->timestamp + 3600 > $startDay->timestamp + intval($deliveryTime)) {
                $yesterdayTime = $startDay->add(1, 'day')->timestamp;
                $toTime = Carbon::createFromTimestamp($yesterdayTime + intval($deliveryTime));
            }
        }

        $note = $data['note'];
        if (!$userId) {
            $info = '';
            if (!empty($data['firstName'])) {
                $info .= 'First Name: ' . $data['firstName'] . "\n";
            }
            if (!empty($data['lastName'])) {
                $info .= 'Last Name: ' . $data['lastName'] . "\n";
            }
            $info .= 'Email: ' . $data['email'] . "\n";
            $note = $info . $note;
        }

        $order = new Order();
        $order->total = $data['total'];
        $order->discount_total = $data['discountValue'];
        $order->state = Order::STATUS_NEW;
        $order->phone = $data['phone'];
        $order->address = $data['address'];
        $order->to_time = $toTime;
        $order->note = $note;
        $order->delivery_type = $data['deliveryType'];
        $order->currency = 'Euro';
        $order->user_id = $userId;
        $order->save();

        foreach ($data['items'] as $item) {
            if (!empty($item) && isset($item['id'])) {
                DB::table('order_pizzas')->insert([
                    [
                        'order_id' => $order->id,
                        'pizza_id' => $item['id'],
                        'base' => $item['base'],
                        'count' => $item['count']
                    ],
                ]);
            }
        }

        return response()->json('ok');
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            abort(500, 'Wrong data');
        } else {
            $userId = Auth::user()->id;
        }

        $orders = Order::where('user_id', $userId)->get();
        if ($orders->count()) {
            return OrderResource::collection($orders);
        }
        return response()->json(['data' => null]);
    }
}
