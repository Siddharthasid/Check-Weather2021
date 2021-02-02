<?php

//initializing this data with blank.
$status = "";

$msg = "";

$city = "";

if(isset($_POST['submit'])){
    $city = $_POST['city'];

$url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=faf9d778970d216acfed437c3ffabdc3";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$result = json_decode($result, true);

if($result['cod'] == 200){
$status = "yes";
}else{
    $msg = $result['message'];
}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <div class="form">
        <form style="width:100%;" method="POST">
            <input type="text" class="text" placeholder="Enter city name" name="city" value="<?php echo $city; ?>">
            <input type="submit" value="Submit" class="submit" name="submit">
            <?php echo "<h1 style='color:white;'><b>$msg<b></h1>"; ?>
        </form>
    </div>
    <?php if($status == "yes"){ ?>
    <article class="widget mt-3">
        <div class="weatherIcon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon']; ?>.png">
        </div>
        <div class="weatherInfo">
            <div class="temperature m-3">
                <span><?php echo round($result['main']['temp']-273.15)."°C"; ?></span>
            </div>
            <div class="description mr45  mr-3">
                <div class="weatherCondition"><?php echo $result['weather'][0]['main'] ?></div>
                <div class="place"><?php echo $result['name'] ?></div>
            </div>
            <div class="description">
                <div class="weatherCondition">Wind</div>
                <div class="place"><?php echo $result['wind']['speed'] ?></div>
            </div>
        </div>
        <div class="date dt">
            <?php echo date('d M',$result['dt']); ?>

        </div>
    </article>
    <?php } ?>
</body>

</html>