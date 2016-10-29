<?php
    $weather = "";
    $error = "";

    if (array_key_exists("city", $_GET)) {

        $city = str_replace(' ', '', $_GET["city"]);

        $file_headers = @get_headers("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");

        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {

            $error = "That city could not be found.";

        } else {

            $forecast = file_get_contents("http://www.weather-forecast.com/locations/".$city."/forecasts/latest");

            $parseForecastOne = explode('<span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecast);

            if (sizeof($parseForecastOne) > 1) {

                $parseForecastTwo = explode('</span></span></span></p>', $parseForecastOne[1]);

                if (sizeof($parseForecastTwo) > 1) {

                    $weather = $parseForecastTwo[0];

                } else {

                    $error = "That city could not be found.";

                }

            } else {

                $error = "That city could not be found.";
            }

        }

    }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Weather Scraper</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" media="screen" title="no title">
  </head>

  <body>

    <div class="container" id="main">
        <h1>What's The Weather?</h1>
        <form>
          <div class="form-group">
            <label for="city">Enter the name of a city.</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="e.g, New York, London, Tokyo" value="<?php echo $_GET['city'];?>">
          </div>
          <button type="submit" class="btn">Get Weather!</button>
        </form>
        <div id="weather">
            <?php
                if ($weather) {
                    echo
                    '<div class="card">
                      <div class="card-header">'.
                        $_GET["city"].'
                      </div>
                      <div class="card-block">
                        <blockquote class="card-blockquote">
                          <p>'.$weather.'</p>
                        </blockquote>
                      </div>
                    </div>';
                } else if ($error && $city) {
                    echo
                    '<div class="alert alert-danger" role="alert">
                      '.$error.'
                    </div>';
                }
             ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
  </body>
</html>
