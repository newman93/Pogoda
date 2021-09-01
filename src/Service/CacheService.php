<?php 
    namespace App\Service;

    class CacheService {
        public function clearCache() {
            $fileW = fopen(realpath('../src/Cache/tmp.txt'), "w+");

            if ($file = fopen(realpath('../src/Cache/temperature.txt'), "r+")) {
                $i = 0;
                while (!feof($file)) {
                    if ($i != 0) {
                        $line = fgets($file);
                        $lineA = explode(';', $line);
        
                        if (is_array($lineA) && count($lineA) == 4) {
                            if (strtotime($lineA[3]) <= strtotime((new \DateTime())->modify("-1 minutes")->format('Y-m-d H:i:s'))) {
                                $line = '';
                            }

                            if ($line != '') {
                                fwrite($fileW, $line);
                            }
                        }
                    }
                    ++$i;
                }
                fclose($file);
            }

            $fileT = fopen(realpath('../src/Cache/temperature.txt'), "w+");

            if ($file = fopen(realpath('../src/Cache/tmp.txt'), "r")) {
                $i = 0;
                while (!feof($file)) {
                    if ($i != 0) {
                        $line = fgets($file);
                        fwrite($fileT, $line.PHP_EOL);
                    } else {
                        fwrite($fileT, '##miasto;kraj;temepartura;timestamp'.PHP_EOL);        
                    }
                    ++$i;
                }
                fclose($file);
            }
        }

        public function getDataIfExist($data) {
            $temperature = '';

            if ($file = fopen(realpath('../src/Cache/temperature.txt'), "r")) {
                $i = 0;
                while (!feof($file)) {
                    if ($i != 0) {
                        $line = fgets($file);
                        $lineA = explode(';', $line);
                        if (is_array($lineA) && count($lineA) == 4) {
                            if (strtolower($lineA[0]) == strtolower($data->getCity()) 
                                && strtolower($lineA[1]) == strtolower($data->getCountry())) {
                                $temperature = $lineA[2];            
                            }
                        }    
                    }
                    ++$i;
                }
                fclose($file);
            }
            
            return $temperature;
        }
    }