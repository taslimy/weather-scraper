<?php

    function curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
        
    }

    if ($_GET['city']) {
        
        $city = str_replace(' ', '', $_GET['city']);
        
        $forecastPage = curl("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small">$fahrenheit<span class="read-more-content"> <span class="phrase">', $forecastPage);
        
        $secondPageArray = explode ('</span></span></span>', $pageArray[1]);
        
        $weather = $secondPageArray[0];
        
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <title>Weather Scraper</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Raleway:300,400,500" rel="stylesheet">
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

    <body style="overflow: hidden;">

        <div class="container">

            <h1>What's the Weather?</h1>

            <form>
                <div class="form-group">
                    <label for="city">Enter the name of a city.</label>
                    <input type="text" class="form-control" id="city" name="city" aria-describedby="city" placeholder="E.g. New York, Tokyo" value="<?php echo $_GET['city']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>

            <div id="weather">

                <?php 
            
            if($weather) {
                
                echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
                
            } else {
                
                if ($city !="") {
                    
                    echo '<div class="alert alert-danger" role="alert">Sorry, that city could not be found.</div>';
                }
            }
          
          ?>

            </div>

        </div>




        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </body>

    </html>
