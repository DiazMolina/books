<?php
/**
 * Rest con uso de scraping a una pagina web de peliculas para obtener la data
 * necesaria para realizar un webservices en formato JSON.
 */
session_start();
include 'simple_html_dom.php';
$op = $_REQUEST['op'];
switch ($op) {
  
  case 3:{
    /**
     * Variables Usadas:
     * - $i: Variable cont array
     * - $movies: Array donde se almacena todos los array
     * - $html0: Recibe los div de la url
     * - $cant: Nos permite especificar que queremos pruebas insensibles a mayúsculas y minúsculas del valor del selector.
     * - $html: Recibe los div de la url por cada vuelta
     * - $article: Selecciona div del html url
     * - $movie: Arrary donde se almacena por cada vuelta
     */
    $i=1;
    $movies = [];
    $html0 = file_get_html('http://allcalidad.com/');
    $cant = 15;
    for ($i = 1; $i <= $cant; $i ++) {
      $html = file_get_html('http://allcalidad.com/page/'.$i.'/');
      $article = $html->find("article");
      foreach ($article as $item) {
        $movie = [];
        $movie['url'] = $item->find("a", 0)->href;
        $movie['title'] = trim($item->find("a", 0)->plaintext);
        $movie['gender1'] = $item->find("a", 2)->plaintext;
        $movie['gender2'] = $item->find("a", 3)->plaintext;
        $movie['image'] = $item->find("img", 0)->src;
        $movie['lenguage'] = $item->find("span", 0)->plaintext;
        $movie['calification'] = $item->find("span", 1)->plaintext;
        $movie['year'] = $item->find("span", 2)->plaintext;
        $movie['duration'] = $item->find("span", 3)->plaintext;
        $movies[] = $movie;
      }
    }


/**
     * Variables Usadas:
     * - $mineria: alamcena el jsn encode de $movies
     * - $firebas: es la url de firebase realtime
     * - $ch: inicia el curl
     * - $curl_setopt($ch,CURLOPT_URL,$firebas):se enviamos la url a ejectar.
     * - $curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);: iniciamos la transferencia
     * - $curl_setopt($ch,CURLOPT_POST,1);:transferims mediante post
     * - $curl_setopt($ch,CURLOPT_POSTFIELDS,$mineria);: adjuntaos la variable mineria que cntiene el json 
     * - curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));: el header es opcional
     * * - $response = curl_exec($ch);;:ejecutamos el curl
     * * - $curl_errno($ch);: verificamos si hay algun error
     */
   $mineria =json_encode($movies);
  
$firebas = "https://lista-af4cf.firebaseio.com/prespuesto.json";




$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$firebas);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$mineria);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));
$response = curl_exec($ch);
if (curl_errno($ch)) {
        echo 'Error:' .curl_errno($ch);
        # code...
}else {
        echo "ya inserto";
    }
    break;
  }
  // rapidvideo
  
 
}

 
  
?>