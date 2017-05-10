<?php

    // This is how we access the GET variable of city in our form.
    if ($_GET['city']) {

        $city = str_replace(' ', '', $_GET['city']);
        
        // using the curl function as an alternative to file_get_contents which isn't setup on our server
        function curl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        } 
        
        // Creating our forecastPage variable and setting it equal to contents of the forecast we want to scrape
        $forecastPage = curl("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        // creating an array that uses the explode function. This gets rid of everythign in the HTML before what we want. Before is [0] and after is [1]
        $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);
        
        
        // second explode starts at the three </span> tags, and uses the part we want from the first explode which is [1] item. Now the forecast piece should be in the [0] item before the </span> tags.
        $secondPageArray = explode('</span></span></span>', $pageArray[1]);
        


        $weather = $secondPageArray[0];
        
        
        // ##metric to imperial##
        $weather = preg_replace_callback(
                '([0-9]+&deg;C)', // searches for anything that matches celcius 
                function ($matches) {            
                    return ((str_replace('&deg;C','',$matches[0])*1.8)+32).'&deg;F'; // do the math conversion for Celsius to Fahrenheit 
                },
            
                $weather
            );
        
        $weather = preg_replace_callback(
                '([0-9]+mm)', // look for the mm metric unit to replace.
                function ($matches3) {  // looks for any metric that matches.        
                    return ((str_replace('mm','',$matches3[0])*.04)).'in'; // converts the mm to inches
                },
            
                $weather
            );
        
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      
      <!--Google Fonts-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Raleway:400,500" rel="stylesheet">
      
      <title>Weather Scraper</title>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      
      <style type="text/css">
          
          html { 
           background: url(wallhaven-149777.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
          height: 100%;
            }
          
          body {
             font-family: 'Raleway', sans-serif;
             font-weight: 300;
             color: #fff;
             height: 100%;
             background: none;
              
          }
          
          .container {
              
              text-align: center;
              margin-top: 100px;

              
          }
          
          input {
              
              margin: 20px 0;
          }
          
          #weather {
              
              margin-top: 25px;
              
          }
      
            
          /* ##Media Queries## */
          
          /* Small Devices */
          @media (min-width: 768px) {
            
            .container{
                
                max-width: 576px;
                
            }
          
          }
        /* Medium Devices */
        @media (min-width: 992px) {
            
            .container{
                
                max-width: 576px;
                
            }
          
          }
        /* Desktop */
        @media (min-width: 1200px) {
            
            .container{
                
                max-width: 576px;
                
            }
          
          }
      

      </style>
  </head>
  <body>
      
      <div class="container">
        
        <h1>What's the Weather?</h1>
          
          
        <form>
          <div class="form-group">
            <label for="city">Enter the name of a city.</label>
              
            <!-- Add php in the value attribute of the input field to display the GET variable after submit -->  
            <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="Eg. New York, Tokyo" value = "<?php echo $_GET['city']; ?>">
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
          
        <div id="weather"><?php 
            
                if ($weather) {
                    
                    echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
                    
                } else {
                    
                     if ($city != ""){
                    
                    echo '<div class="alert alert-danger" role="alert">Sorry, that city could not be found.</div>';
                         }
                    
                }
            
                
            
            
            ?></div>
          

      </div>


    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
