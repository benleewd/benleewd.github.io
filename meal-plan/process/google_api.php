<?php 
   class GoogleApi{

        private $apikey;

        public function __construct(){
            $this->apikey = "AIzaSyA5XSnQyi3HjT0K2M-Yl9K8J1e8accBevM";
        }

        
        public function getPlacesFromText(String $q)
        {
            $q1 = explode(" ", $q);
            $query = join("+", $q1);

            $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . $query . "&key=" . $this->apikey;

            try{
                $content = file_get_contents($url);
                if ($content == FALSE) {
                    return "Invalid query or no data found";
                } else {
                    return json_decode($content);
                }
                
            } catch (Exception $e){
                return "Invalid query or no data found";
            }
        }

        public function getApiKey()
        {
            return $this->apikey;
        }


    }
?>