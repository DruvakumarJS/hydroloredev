<html>

<body>
<p>Dear Admin ,</p>
<p>Please check the below stocks which expires in 15 days</p>


<div  class="card border-white" style="margin-top: 10px;">
    <table class="table responsive" width="100%">   
    <thead>
        <tr>
        <th style="text-align: start">Category</th>
        <th style="text-align: start">Product</th>
        <th style="text-align: start">Brand</th>
        <th style="text-align: start">Available Qty</th>
        <th style="text-align: start">Expiry Date</th>
    </tr>
    </thead>

    <tbody>
        @foreach($expiry as $key=>$value)
        <tr>
            <td>{{$value['category']}}</td>
            <td>{{$value['product']}}</td>
            <td>{{$value['brand']}}</td>
            <td>{{$value['weight']}} {{$value['measurement']}}</td>
            <td>{{$value['expire']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

   <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>
</body>

</html>
