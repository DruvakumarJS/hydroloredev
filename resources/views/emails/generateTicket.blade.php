@php

$array=explode('$', $problems);

@endphp

<html>
<body>

<h1>Dear {{ $user->firstname }} {{ $user->lastname}}, </h1> 
<br></br>
<p>We have received your request for</p><br>
 @foreach($array as $key => $val) 
<p>* {{$val}}</p>
 @endforeach
<br></br>
<p> and a ticket has been registered with number {{$sr_no}}.</p>
<br></br>

   <p>Please give us a maximum of 24 hours and we will get back to you at the earliest.<br>
   Ticket number is <b>{{$sr_no}}</b>.
</p>
<br></br>
 <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>

</body>

</html>


<!-- <html>
<body>

<h1>Dear {{ $user->firstname }} {{ $user->lastname}}, </h1> <br> Your ticket has been created. Ticket number is {{ $sr_no }}.
   <br>&nbsp;<br><br>Regards, <br> <b> Hydrolore </b>
</body>

</html> -->