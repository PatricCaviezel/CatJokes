<!DOCTYPE html>
<html>

<!Author 1: Jon Landa <jonlanda06@gmail.com>
  <!Author 2: Patric Caviezel <patric.caviezel@gmail.com>
    <!Author 3: Luc Hauser <luc.hauser@bluewin.ch>

      <head>
        <title>CatJokes</title>
        <style>
          .container {
            height: 500px;
            position: relative;
            border: 0px solid green;
          }

          .container2 {
            height: 500px;
            position: relative;
            border: 0px solid green;
          }

          .vertical-center {
            margin: 0;
            position: absolute;
            top: 70%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
          }

          .vertical-center-canvas {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 30%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
          }

          .button-size {
            width: 50px;
            height: 50px;
          }
        </style>
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
            $max_size = 500;
            if ($image[1] > $image) {
                return $img_data;
            }
        }
        $image = get_img_data();

        function joke()
        {
            $url = "https://v2.jokeapi.dev/joke/Any?type=twopart?format=json";

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
                $joke = $response['setup'] . PHP_EOL . "  " . $response['delivery'] . PHP_EOL;
                return $joke;
            } else {
                echo 'error ' . $code;
            }
        }
        ?>
      </head>
      <body style="background-color:rgb(229, 170, 112);">
        <div class="container">
          <div class="vertical-center">
            <buttond class="button-size" onclick="location.reload ();"
              style="background-color:rgb(0, 0, 0); color:rgb(255, 255, 255); border: 2px solid rgb(0, 0, 0);">
              Refresh
            </buttond>
          </div>
        </div>
        <img src="<?php echo $image[0]; ?>">
        <?php
        print joke();
        ?>
      </body>

</html>
