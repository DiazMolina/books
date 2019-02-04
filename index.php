<?php
session_start();
include 'simple_html_dom.php';
            $movies = [];
            $html0 = file_get_html('https://www.mundoprimaria.com/cuentos-infantiles-cortos/cuentos-para-dormir');
            for ($i = 116; $i <= 118; $i++) {
                $linkmovie = $html0->find(".galleta-grid-wrapper a", $i)->href;
                $html = file_get_html($linkmovie);
                $article = $html->find("div[id=content]");
                foreach ($article as $item) {
                    $movie = [];
                    $movie['title'] = $item->find("div div h1", 0)->plaintext;
                    $movie['autor'] = "CRISTINA RODRÍGUEZ LOMBA";
                    $movie['imagen'] = $item->find("div div p img", 0)->src;
                    $movie['resumen'] = trim(str_replace($item->find("div div h1", 0)->plaintext, '', $item->find("div div", 0)->plaintext));
                    $movies[] = $movie;
                }
            }

            print json_encode($movies);



?>