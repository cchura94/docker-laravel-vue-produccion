<style>
    .container{
        width: 80%;
        margin: 0 auto;
    }
    .header{
        text-align: center;
        margin: 0 auto;
    }
    .info{
        margin-bottom: 20px;
    }
    .info p {
        margin: 5px 0;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .table th {
        background-color: #f3f3f3;
    }
</style>
<div class="container">
    <div class="header">
        <h1>Recibo de Pedido</h1>
    </div>
    <div class="info">
        <p><strong>ID Pedido: </strong>{{ $pedido->id }}</p>
        <p><strong>Fecha de Pedido: </strong>{{ $pedido->fecha_pedido }}</p>
        <p><strong>CLIENTE: </strong>{{ $pedido->cliente->razon_social }}</p>
        <p><strong>Correo Cliente: </strong>{{ $pedido->cliente->correo }}</p>
        <p><strong>Vendedor: </strong>{{ $pedido->user?$pedido->user->name:'' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Codigo producto</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>cantidad</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ number_format($producto->precio, 2) }}</td>
                <td>{{ $producto->pivot->cantidad }}</td>
                <td>{{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>