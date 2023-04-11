
<p>您单号为: {{ $order->order_no }} 的订单已经发货</p>

<h4>其中包含的商品为：</h4>

<ul>
    @foreach ($order->details()->with('goods')->get() as $details)
        <li>{{ $details->goods->title }}, 单价为: {{ $details->price }}, 数量为: {{ $details->number }} </li>
    @endforeach
</ul>

<h5>总付款：{{ $order->amount }} </h5>


