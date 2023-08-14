<html>
<body>

<h1>Dear {{$user->firstname}}{{$user->lastname}},</h1> 
<p>Welcome to Hydrolore. We’re so happy to be a part of your Hydroponics farming journey.</p>
<p>
With the completion of the POD set up at your home, the next step in the journey gets more exciting.
To make things easier for you, we have a simple guide for you to look at to better maintain your crops.
Of course, we are only a call away if there are any concerns you have and we will be more than happy
to assist you.</p>


<p>Please reffer this email to login to Hydrolore Dashboard</p>
<br></br>
<h3>dashboard link : {{$url}}/</h3><br></br>
<h3>Password for Hydrolore Dashboard : {{$password}}</h3><br></br>

<h3>Details of your POD</h3>
<h3>HUBID : {{$user->hub_id}}</h3>

<p><i>To growing healthy nutritious food</i></p>


   <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>
</body>

</html>
