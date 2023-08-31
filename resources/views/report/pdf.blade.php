<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                background-color: #70C171;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;
                background-color: #f2f2f2;
                color: black;
                text-align: center;
                line-height: 35px;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>

           Hydrolore - Crop Production Report
        </header>

        <footer>
           <label style="font-size: 17px;">Hydrolore</label> 
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main >
            <div>
                <label style="font-weight: bolder;">{{$value->crop_name}}</label>
            </div>
          <div><label>User Name : </label> <label style="font-weight: bold;">{{$value->user_name}}</label></div>
          <div><label>Mobile Number : </label> <label style="font-weight: bold;">{{$value->mobile}}</label></div>
          <div><label>Email ID : </label> <label style="font-weight: bold;">{{$value->email}}</label></div>
          <div><label>Crop Category : </label> <label style="font-weight: bold;">{{$value->category}}</label></div>
          <div><label>Crop Name : </label> <label style="font-weight: bold;">{{$value->crop_name}}</label></div>
          <div><label>Crop Duration : </label> <label style="font-weight: bold;">{{$value->duration}} days</label></div>
          <div><label>Channels used : </label> <label style="font-weight: bold;">{{$value->channel}}/3 of a Channel</label></div>
          <div><label>Seeds Planted : </label> <label style="font-weight: bold;">{{$value->seeds_quantity}}</label></div>
          <div><label>Planted Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['planted_date']))}}</label></div>
          <div><label>Pruning Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['pruning_date']))}}</label></div>
          <div><label>Staking Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['staking_date']))}}</label></div>
          <div><label>Nutrition Addition Date : </label > <label style="font-weight: bold;">{{date("d M Y", strtotime($value['nutrition_date']))}}</label></div>
          <div><label>Spray 1 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray1_date']))}}</label></div>
          <div><label>Spray 2 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray2_date']))}}</label></div>
          <div><label>Spray 3 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray3_date']))}}</label></div>
          <div><label>Nutritions Used : </label> <label style="font-weight: bold;">{{$value->nutritions}}</label></div>
          <div><label>Pesticides Used : </label> <label style="font-weight: bold;">{{$value->pesticides}}</label></div>
          <div><label>Avg Ambian Temperature : </label> <label style="font-weight: bold;">{{$value->avg_ab}}</label><span> &#176;C</span></div>
          <div><label>Avg POD Temperature : </label> <label style="font-weight: bold;">{{$value->avg_pod}}</label><span> &#176;C</span></div>
          <div><label>Avg TDS Value : </label> <label style="font-weight: bold;">{{$value->avg_tds}}</label><span> mg/L</span></div>
          <div><label>Avg pH value : </label> <label style="font-weight: bold;">{{$value->avg_ph}}</label></div>
          <div><label>Avg Nutrition Temperature : </label> <label style="font-weight: bold;">{{$value->avg_nut}}</label><span> &#176;C</span></div>
          <div><label>Harvesting Ddate : </label> <label style="font-weight: bold;">{{$value->harvesting_date}}</label></div>
          <div><label>Expected Yield Quantitiy : </label> <label style="font-weight: bold;">{{$value->expected_quantitiy}}kg</label></div>
          <div><label>Produced Quantity : </label> <label style="font-weight: bold;">{{$value->actual_quantity}}kg</label></div>
          <div><label>Grade 1 Yield : </label> <label style="font-weight: bold;">{{$value->grade1}}kg</label></div>
          <div><label>Grade 2 Yield : </label> <label style="font-weight: bold;">{{$value->grade2}}kg</label></div>
          <div><label>Grade 3 Yield : </label> <label style="font-weight: bold;">{{$value->grade3}}kg</label></div>
          <div><label>Status : </label> <label style="font-weight: bold;">{{$value->status}}</label></div>
          <div><label>Comments : </label> <label style="font-weight: bold;">{{$value->comments}}</label></div>
          <div><label>Harvest Completion Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['created_at']))}}</label></div>
                        
        </main>
    </body>
</html>