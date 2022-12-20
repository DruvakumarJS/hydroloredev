
@php
$subject=$ticket->subject;

$params=explode("," , $subject);



@endphp
<html>
<body>
<h3>Hydrolore HUB and Critical Parameter details </h3><br/>
<h2>HUBID : {{$ticket->hub_id}}</h2>
<h2>PODID : {{$ticket->pod_id}}</h2>
<h2>Customer Name : {{$ticket->user_name}}</h2>
<h2>Mobile Number : {{$ticket->user_mobile}}</h2>
<h2>Location : {{$ticket->user_location}}</h2>

<h2>Critical Parameters and it's current value</h2>

 @foreach($params as $key => $val) 
<h2>{{$val}}</h2>
 @endforeach






    <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>
</body>

</html>