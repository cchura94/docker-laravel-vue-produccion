<table>
    <thead>
    <tr >
        <th style="background-color: green;">NOMBRE</th>
        <th>PRECIO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productos as $prod)
        <tr>
            <td>{{ $prod->nombre }}</td>
            <td>{{ $prod->precio }}</td>
        </tr>
    @endforeach
    </tbody>
</table>