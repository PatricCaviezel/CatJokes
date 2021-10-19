<!DOCTYPE html>
<html>

      <head>
<!Author 1: Jon Landa <jonlanda06@gmail.com>
<!Author 2: Patric Caviezel <patric.caviezel@gmail.com>
<!Author 3: Luc Hauser <luc.hauser@bluewin.ch>

<link rel="stylesheet" href="Styles.css">

<meta name="viewport" content="width=device-width,height=device-heigt, initial-scale=1.0">
        <title>CatJokes</title>

        <?php
        function get_img_data()
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.thecatapi.com/v1/images/search?format=json',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'x-api-key: cb5be23a-5f4f-4eb1-83af-a4844fe8ff69'
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);
            $counter = 0;
            $img_data = [];
            foreach ($data[0] as $elem) {
                $counter++;
                if ($counter > 2) {
                    array_push($img_data, $elem);
                }
            }
            $max_size = 600;
            if ($max_size < $img_data[1]) {
                $img_data[1] = ($img_data[1] / $img_data[1]) * $max_size;
                $img_data[2] = ($img_data[2] / $img_data[2]) * $max_size;
            }
            if ($max_size < $img_data[2]) {
                $img_data[1] = ($img_data[1] / $img_data[1]) * $max_size;
                $img_data[2] = ($img_data[2] / $img_data[2]) * $max_size;
            }
            return $img_data;
        }
        $image = get_img_data();
        $img_url = $image[0];
        $width = $image[1];
        $height = $image[2];
        function joke()
        {
            $url = "https://v2.jokeapi.dev/joke/Any?type=twopart";

            $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            );


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($code == 200) {
                $response = json_decode($response, true);
                $joke = $response['setup'] . "\n" . "  " . $response['delivery'] . "\n";
                return $joke;
            } else {
                echo 'error ' . $code;
            }
        }
        ?>

      </head>
      <body class="rainbow">
      <center>
      <p style="font-size:70px;">CatJokes</p>
      </center>
      <div id="background-log">
  <div class="button-login">
    <center>
    <button onClick="window.location.reload();" class="refresh" style="font-size: 40px">refresh</button>
      </center>
  </div>
</div>
      <center>
        <img src="<?php echo $img_url; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
      </center>
        <center>
          <p class="size">
        <?php
        print joke();
        ?>
        </p>
        </center>
      </body>
      <footer>
        <center>
        <h4 style="color:red">Sometimes there is an error. Just refresh to fix it</h4>
        </center>
      </footer>

</html>
