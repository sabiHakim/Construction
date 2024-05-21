<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
<table border="1">
    <thead>
    <tr>
        <th >code_travaux</th>
        <th >nomtravaux</th>
        <th >designation</th>
        <th >qte</th>
        <th >pu</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $dev)
        <tr>
            <td>{{$dev->code_travaux}}</td>
            <td>{{$dev->nomtravaux}}</td>
            <td>{{$dev->designation}}</td>
            <td>{{$dev->qte}}</td>
            <td>{{number_format($dev->pu, 0, ',', ' ')}} AR</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>


