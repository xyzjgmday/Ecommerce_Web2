<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Auth;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cart = session()->get('cart');
        if($cart) {
            return view('admin.orders.create');
        } else {
            return redirect('/')->with('succes', 'Anda harus belanja terlebih dahulu');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->validate($request, [
        'shipping_address' => 'required',
        'zip_code' => 'required'
    ]);

    // Get Total Price
    $cart = session()->get('cart');
    $total_price = 0;

    if (!empty($cart) && is_array($cart)) {
        foreach ($cart as $id => $product) {
            // Pastikan $product memiliki kunci 'price' dan 'quantity'
            if (isset($product['price']) && isset($product['quantity'])) {
                $total_price += $product['price'] * $product['quantity'];
            }
        }
    }

    // Pastikan total_price lebih dari 0 sebelum menyimpan order
    if ($total_price > 0) {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 'Pending';
        $order->shipping_address = $request->input('shipping_address');
        $order->zip_code = $request->input('zip_code');
        $order->total_price = $total_price;
        $order->save();

        // Hapus session 'cart'
        session()->forget('cart');

        return redirect('admin/orders/' . $order->id)->with('success', 'Order berhasil disimpan');
    } else {
        // Jika total_price tidak lebih dari 0, kembali ke halaman sebelumnya
        return redirect()->back()->with('error', 'Tidak ada barang dalam keranjang belanja.');
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if ($order) {
            return view('admin.orders.show', compact('order'));
        } else {
            return redirect('admin/orders')->with('errors', 'Order tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
