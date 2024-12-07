<!-- order/receipt.php -->
<div class="receipt">
    <h3 class="text-center">Order Receipt</h3>
    <p><strong>Order ID:</strong> <?=$order->id?></p>
    <p><strong>Customer Name:</strong> <?=$order->customer_name?></p>
    <p><strong>Table Number:</strong> <?=$order->table_number?></p>
    <p><strong>Order Date:</strong> <?=$order->created_at?></p>

    <hr>

    <h4>Items:</h4>
    <ul>
        <?php $sub_total = 0;foreach ($order_detail as $item): ?>

        <li><?=$item->product_name?> - <?=$item->quantity?> x <?=number_format($item->product_price, 0)?></li>
        <?php $sub_total += $item->product_price * $item->quantity;endforeach;?>
    </ul>

    <hr>

    <p><strong>Total:</strong> Rp.<?=number_format($sub_total, 0)?></p>
</div>