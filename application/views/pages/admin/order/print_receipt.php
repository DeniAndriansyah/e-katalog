<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Receipt</title>
    <style>
    /* Set the width to 80mm for thermal printing */
    body {
        width: 80mm;
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    .receipt {
        padding: 10px;
    }

    .receipt h3 {
        text-align: center;
        margin: 0;
        padding: 5px 0;
        font-size: 16px;
    }

    .receipt p {
        margin: 2px 0;
    }

    .receipt hr {
        border: 0;
        border-top: 1px dashed #000;
        margin: 10px 0;
    }

    .receipt ul {
        list-style: none;
        padding: 0;
    }

    .receipt ul li {
        margin: 2px 0;
    }

    .receipt .total {
        text-align: right;
        font-weight: bold;
    }

    /* Hide all elements that are not part of the receipt when printing */
    @media print {
        body {
            margin: 0;
        }
    }
    </style>
</head>

<body>
    <div class="receipt">
        <h3>Order Receipt</h3>
        <p><strong>Order ID:</strong> <?=$order->id?></p>
        <p><strong>Customer Name:</strong> <?=$order->customer_name?></p>
        <p><strong>Table Number:</strong> <?=$order->table_number?></p>
        <p><strong>Order Date:</strong> <?=$order->created_at?></p>

        <hr>

        <h4>Items:</h4>
        <ul>
            <?php foreach ($order_detail as $item): ?>
            <li>
                <?=$item->product_name?> - <?=$item->quantity?> x <?=number_format($item->product_price, 0)?>
            </li>
            <?php endforeach;?>
        </ul>

        <hr>

        <p class="total"><strong>Total:</strong> Rp.<?=number_format($order->total, 0)?></p>
        <p class="total"><strong>Amount Paid:</strong> Rp.<?=number_format($order->amount_paid, 0)?></p>
        <p class="total"><strong>Change:</strong> Rp.<?=number_format($order->change, 0)?></p>
    </div>

    <script>
    // Automatically trigger the print dialog
    window.onload = function() {
        window.print();
    }
    </script>
</body>

</html>