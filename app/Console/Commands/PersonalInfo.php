<?php
namespace App\Console\Commands;

class PersonalInfo
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate automatic appointment times';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle($id = 0)
    {
      $found = 0;
      $json = json_decode('{"ERROR": "NOT FOUND"}');
      $url = 'https://api.hacienda.go.cr/fe/ae?identificacion='.$id;
      
      //$url = 'https://apis.gometa.org/cedulas/'.$id;

      //$url = 'https://apis.gometa.org/status/';

      //return $url;

      $curl = curl_init();
      
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Android 10; Mobile; rv:125.0) Gecko/125.0 Firefox/129.0.2', 
        CURLOPT_SSLVERSION => '6'  
      ));
      
      // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, CURLOPT_HTTPGET);
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($curl, CURLOPT_HEADER, false);
      // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
      // curl_setopt($curl, CURLOPT_HTTP_VERSION, 0);
      // curl_setopt($curl, CURLOPT_HEADER, CURL_HTTP_VERSION_2_0);
      // curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Android 10; Mobile; rv:125.0) Gecko/125.0 Firefox/129.0.2');
      // curl_setopt($curl, CURLOPT_SSLVERSION, '6');

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      
      if($err) {
        return json_decode('{"error": "ERROR"}');
      }

    $data = json_decode($response, TRUE);
    
    if(isset($data['nombre']) && $data['nombre'] != '' && $data['tipoIdentificacion'] == '01'){
    
      $list=explode(' ',$data['nombre']);
      $sizeof=sizeof($list);    
      $row=array();    
    
      if($sizeof>3){
	      $ultim=$sizeof-1;
	      $max=$sizeof-2;
	      $nombre='';
	      for($i=0;$i<$max;$i++){
		      if($i!=0){
			      $nombre=$nombre.' ';
		      }
		      $nombre.=$list[$i];
	      }
	      $row['NOMBRE']=$nombre;
	      $row['APELLIDO1']=$list[$ultim-1];
	      $row['APELLIDO2']=$list[$ultim];
      }else if($sizeof==3){
	      $row['NOMBRE']=$list[0];
	      $row['APELLIDO1']=$list[1];
	      $row['APELLIDO2']=$list[2];
      }

      $json = json_decode(json_encode($row));
      $found = 1;     
    }else{ 
      $err = 'ERROR';
    }
    if(!$found){
      $err = 'NOT FOUND';
    }

    return $json;
    }
}
