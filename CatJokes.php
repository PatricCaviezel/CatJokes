<!DOCTYPE html>
<html>

  <head>
    <!Author 1: Jon Landa <jonlanda06@gmail.com>
    <!Author 2: Patric Caviezel <patric.caviezel@gmail.com>
    <!Author 3: Luc Hauser <luc.hauser@bluewin.ch>

    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3468/3468377.png">
    <link rel="stylesheet" href="Styles.css">
    <meta name="viewport" content="width=device-width,height=device-heigt, initial-scale=1.0">
      <title>
        CatJokes
      </title>
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
            if (count($img_data) > 3) {
                unset($img_data[0]);
                $fixed_array = [];
                foreach ($img_data as $elem) {
                    array_push($fixed_array, $elem);
                }
                $img_data = $fixed_array;
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

        function fact()
        {
            $url = "https://uselessfacts.jsph.pl/random.json?language=en";

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
            } else {
                echo 'error ' . $code;
            }

            return $response['text'] . PHP_EOL . "Source: " . $response['source'];
        }
        ?>

  </head>
  <body class="rainbow">
    <center>
      <p class="fontcool">
        <i>
          CatJokes
        </i>
      </p>
    </center>
    <div id="background-log">
      <div class="button-login">
        <center>
          <button onClick="window.location.reload();" class="refresh">
            refresh
          </button>
        </center>
      </div>
    </div>
      <center>
        <img src="<?php echo $img_url; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
      </center>
      <center>
        <h1>
          After this purrfect image, here's a random fact.
        </h2>
        <p class="size">
          <?php
            print fact();
            ?>
        </p>
      </center>
      <center>
        <h1>
          in case you didn't like the fact, here's a joke ;).
        </h2>
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
  <a href="https://github.com/PatricCaviezel/CatJokes"><img src="https://icdn.enterinit.com/wp-content/uploads/2017/05/26081202/github-logo.png" alt="Git Hub Link"  style="width:96px;height:48px;"></a>
  </footer>
</html>
