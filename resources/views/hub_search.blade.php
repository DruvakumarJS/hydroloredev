@extends('layouts.app')

@section('content')


<div class="container-body">
    <div class="row justify-content-center">
 
        <div>
            <h2 class="head-h1">Hub</h2>
            <label class="date"> {{date('d M ,Y')}} </label>  

             <h3 class="card head-h1" style="float: right;margin-right: 10px; background: blue;  color: white;">HUB ID : {{$hubid}} </h3>   
        </div>



     <div class="card-body" style="background-color:white; margin: 20px;">
     	

     	@foreach($userdetails as $key=>$value)

     	<div>
     		<label class="header-lab">User Name : </label>
     		<label>{{$value->firstname}}</label>
         
     		<label class="header-lab" style="margin-left:30px" >Contact No : </label>
     		<label>{{$value->mobile}}</label>

     		<label class="header-lab" style="margin-left:30px">Registered On : </label>
     		<label>{{$value->created_at}}</label>
     	</div>
     	
     	<div>
     		
     		<label class="header-lab">No. of PODS : </label>
     		<label>{{sizeof($Pod_details)}}</label>

     		<label class="header-lab" style="margin-left:30px" >Address : </label>
     		<label>{{$value->address}}</label>
     	</div>
     </div>
    
     
     @endforeach


     <div >
            
            @foreach($Pod_details as $key => $value)
           
          

            <div class="card">
            	 <label class="card-header">{{$value->pod_id}}</label>
             
                <div class="row">

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->AB_T1))
                          <div><span>{{$value->AB_T1}} </span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <h3>AB-T1</h3>
                          <label>Ambient Temperature Sensor – 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                         @if(isset($value->AB_H1))
                          <div><span>{{$value->AB_H1}}</span><label> %RH</label></div>
                          @else
                          <div><span>0</span><label>%RH</label></div>
                          @endif
                          <h3>AB-H1</h3>
                          <label>Ambient Humidity Sensor – 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->POD_T1))
                          <div><span>{{$value->POD_T1}}</span><label> &#176;C</label></div>
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <h3>POD-T1</h3>
                          <label>POD/BB Temperature Sensor – 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->POD_H1))
                          <div><span>{{$value->POD_H1}}</span><label> %RH</label></div>
                          @else
                          <div><span>0</span><label> %RH</label></div>
                          @endif
                          <h3>POD-H1</h3>
                          <label>POD/BB Humidity Sensor – 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress" style="background-color:black;">
                          <div class="barOverflow">
                            <div class=""></div>
                          </div>
                          @if(isset($value->TDS_V1))
                         <div ><span class="head-h1" style="color:white;">{{$value->TDS_V1}}</span><label class="head-h1"> mA</label></div>
                          @else
                          <div><span>0</span><label> mg/L</label></div>
                          @endif
                          <h3 style="color:blue;">TDS-V1</h3>
                          <label style="color:white;">Total Dissolved Salt Sensor Value</label>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->NUT_T1))
                          <div><span>{{$value->NUT_T1}}</span><label> &#176;C</label></div>
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <h3>NUT-T1</h3>
                          <label>Nutrient Solution Temperature Sensor Value – 1</label>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress" style="background-color:black;">
                          <div class="barOverflow">
                            <div class=""></div>
                          </div>
                          @if(isset($value->NP_I1))
                          <div><span class="head-h1" style="color:white;">{{$value->NP_I1}}</span><label class="head-h1"> mA</label></div>
                          @else
                          <div><span>0</span><label> mA</label></div>
                          @endif
                          <h3 style="color:blue;">NP-I1</h3>
                          <label style="color:white;">Current (consumed) – Nutrient Pump 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->SV_I1))
                          <div><span>{{$value->SV_I1}}</span><label> mA</label></div>
                          @else
                          <div><span>0</span><label> mA</label></div>
                          @endif
                          <h3>SV-I1</h3>
                          <label>Current (consumed) – Solenoid Valve 1</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($value->BAT_V1))
                          <div><span>{{$value->BAT_V1}}</span><label> %</label></div>
                          @else
                          <div><span>0</span><label> %</label></div>
                          @endif
                          <h3>BAT-V1</h3>
                          <label>Battery percentage</label>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-2" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->WL1L == "ON" ? 'checked' : ''@endphp  disabled><span class="slider round" ></span></label>
                          
                          <h3>WL1L</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->WL2L == "ON" ? 'checked' : ''@endphp disabled><span class="slider round"></span></label>
                          
                          <h3>WL2L</h3>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-1" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->RL1 == "ON" ? 'checked' : ''@endphp disabled><span class="slider round"></span></label>
                          
                          <h3>RL1</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-1" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->RL2 == "ON" ? 'checked' : ''@endphp disabled><span class="slider round"></span></label>
                          
                          <h3>RL2</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-1" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->RL3 == "ON" ? 'checked' : ''@endphp disabled><span class="slider round"></span></label>
                          
                          <h3>RL3</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-1" >
                        <div class="card">

                        	<label class="switch">
                          <input type="checkbox" @php echo $value->RL8 == "ON" ? 'checked' : ''@endphp disabled><span class="slider round"></span></label>
                          
                          <h3>RL8</h3>

                        </div>
                    </div>
           
        </div>


    </div>



    @endforeach



</div>

      
</div>

</div>

<style type="text/css">
    .column1 {
  float: left;
  width: 25%;
  padding: 0 10px;
}
    .progress{
  position: relative;
  margin: 4px;
/*  float:left;*/
  height: 180px;
  width: 100%;
  text-align: center;
}
.barOverflow{ /* Wraps the rotating .bar */
  position: !important;
  overflow: hidden; /* Comment this line to understand the trick */
  width: 90px; height: 45px; /* Half circle (overflow) */
  margin-bottom: -14px; /* bring the numbers up */
  margin-left: 90px;

}
.bar{
  position: relative;
  top: 0; left: 0;
  width: 90px; height: 90px; /* full circle! */
  border-radius: 50%;
  box-sizing: border-box;
  border: 10px solid #eee;     /* half gray, */
  border-bottom-color: #0cf;  /* half azure */
  border-right-color: #0bf;
}
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
      } else {
          content.style.display = "block";
      }
  });
  }

</script>

<script>
    $(document).ready(function(){
      
      $(".progress").each(function(){

        var $bar = $(this).find(".bar");
              var $val = $(this).find("span");
              var perc = parseInt( $val.text(), 10);

              $({p:0}).animate({p:perc}, {
                duration: 3000,
                easing: "swing",
                step: function(p) {
                  $bar.css({
                transform: "rotate("+ (45+(p*1.8)) +"deg)", // 100%=180° so: ° = % * 1.8
                // 45 is to add the needed rotation to have the green borders at the bottom
            });
                  $val.text(p|0);
                  }
        });
      });
  });

    
</script>



  


@endsection
