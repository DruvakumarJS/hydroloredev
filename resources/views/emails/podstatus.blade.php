<html>
<body>

<h3>Dear admin,</h3> 
<p>Below PODs / devices are not responding from past 6 hours.</p>

<div class="row">
	@foreach($data as $key=>$value)
		<div class="col-md-4">
			<div class="card" style="margin: 20px;border-color: black;border-width: 1px;">
				<div class="card card-header">POD ID : {{$value['POD_ID']}}</div>
				<label>HUB ID : {{$value['HUB_ID']}}</label>
				<div>
					<label>last response time : {{$value['last_entry']}}</label>
				</div>
				<div>
					<label>UserName : {{$value['user']['firstname']}} {{$value['user']['lastname']}}</label>
				</div>
				<div>
					<label>Mobile : {{$value['user']['mobile']}} </label>
				</div>
				<div>
					<label>date of install : {{$value['installation_date']}} </label>
				</div>
				<label>------------------------------</label>
				
			</div>
		</div>
	@endforeach
</div>

   <br>&nbsp;<br><br>Thank you   , <br> <b> Team Hydrolore  </b>
</body>

</html>
