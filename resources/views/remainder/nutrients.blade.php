<html>

<body>
<p>Dear Admin ,</p>
<p>Below customers have Nutrients Day in next 3 days . So ,Nutrients has to be supplied to below customers ,ignore if alreaady sent</p>


<div  class="card border-white" style="margin-top: 10px;">
    <table class="table responsive" width="100%">   
    <thead>
        <tr>
        <th style="text-align: start">User Name</th>
        <th style="text-align: start">Mobile</th>
        <th style="text-align: start">Address</th>
        <th style="text-align: start">Crop</th>
        <th style="text-align: start">Planted On</th>
    </tr>
    </thead>

    <tbody>
        @foreach($nutrients as $key=>$value)
        <tr>
            <td>{{$value['username']}}</td>
            <td>{{$value['mobile']}}</td>
            <td>{{$value['address']}}</td>
            <td>{{$value['crop']}} </td>
            <td>{{$value['planted_date']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

   <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>
</body>

</html>
