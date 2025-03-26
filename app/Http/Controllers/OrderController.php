<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        $products = Products::all();
        $user = User::all();

        return view('orders.create')->with([
            'products' => $products,
            'users' => $user,
        ]);
    }
  
    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'comment' => 'nullable|string',
            'print_check' => 'boolean',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);
        return DB::transaction(function () use ($validated) {
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'date' => $validated['date'],
                'comment' => $validated['comment'] ?? null,
                'print_check' => $validated['print_check'] ?? false,
                'total' => 0,
            ]);

            $total = 0;
            foreach ($validated['products'] as $item) {
                $itemTotal = $item['quantity'] * $item['price'];
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $itemTotal,
                ]);
                $total += $itemTotal;
            }

            $order->update(['total' => $total]);

            return response()->json(['message' => 'Order created successfully!', 'order_id' => $order->id]);
        });
    }
    public function getOrders(Request $request)
    {

        if ($request->ajax()) {
             $data = Order::with('user');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return $row->user ? $row->user->name : 'N/A'; // Foydalanuvchi ismini olish
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">
                    <a  class="dropdown-item show"  href="javascript:void(0)" data-id="' . $row->id . '"><i class="bi bi-eye"></i></a></li>
                </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function SelectProductOrders()
    {
        $order = Order::with('user')->find(1);
        // dd($order->user->name);
        $orders=Order::all();
        $orderItems=OrderItem::all();
        return view('orders.selectProductOrder')->with([
            'orders'=>$orders,
            'orderItems'=>$orderItems,
        ]);
    }

    public function show( $id){
        // $data=OrderItem::with('product')->findOrFail($id);
        $data= OrderItem::with('product')->where('order_id', $id)->get();
        // $data=collect([$data1]);
        // dd($data);

        return response()->json($data);


    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json($order);
    }
}
