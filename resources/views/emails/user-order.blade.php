<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}}</title>
</head>

<style>
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }
    }

    /* general styling */
    body {
        font-family: "Open Sans", sans-serif;
        line-height: 1.25;
    }
</style>
<body>
<p style="margin-bottom: 20px">We going to contact you within 10 minutes. The sales team is going to contact you soon.</p>
<table>
    <caption>Your order details</caption>
    <thead>
    <tr>
        <th scope="col">Order id</th>
        <th scope="col">Product</th>
        <th scope="col"></th>
        <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td data-label="Order id" >{{$order->order_id}}</td>
        <td data-label="Product">{{ $order->product->name  }}</td>
        <td>
            <ul style="list-style: none; margin: 0; padding: 0">
                @foreach ($order->order_products as $single_order_product)
                    <li style="margin-bottom: 15px;"><div>{{ $single_order_product->variant->status  }}({{ $single_order_product->qty }})</div><div>SKU: {{ $order->product->sku }} € {{ $single_order_product->amount }}</div></li>
                @endforeach
            </ul>
        </td>
        <td data-label="Total: ">€ {{ $order->total_price }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
