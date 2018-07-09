<?php 

// MASS ALEXA RANK 
// CODED BY AKEMI403
// 9 July 2018

print "
  ___   _   __ ________  ________  ___ _____  _____ 
 / _ \ | | / /|  ___|  \/  |_   _|/   |  _  ||____ |
/ /_\ \| |/ / | |__ | .  . | | | / /| | |/' |    / /
|  _  ||    \ |  __|| |\/| | | |/ /_| |  /| |    \ \
| | | || |\  \| |___| |  | |_| |\___  \ |_/ /.___/ /
\_| |_/\_| \_/\____/\_|  |_/\___/   |_/\___/ \____/                                        			
                 MASS ALEXA CHECK 
";

echo "Masukan Filenya : ";
$url = trim(fgets(STDIN));

if(empty($url)){
	die("GA BOLEH KOSONG :( \n");
}

$file = fopen("$url", "r");
$size = filesize($url);
$baca = fread($file, $size);
fclose($file);

$hmm = explode("\n", $baca);

 print "+--------------------------------+\n";
 print "         MASS ALEXA CHECK         \n";
 print "+--------------------------------+\n";
foreach ($hmm as $hmms) {
	// in case scheme relative URI is passed, e.g., //www.google.com/
$hmms = trim($hmms, '/');

// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $hmms)) {
    $hmms = 'http://' . $hmms;
}
$urlParts = parse_url($hmms);

// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.alexa.com/siteinfo/$domain");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$exec = curl_exec($curl);
curl_close($curl);

preg_match_all("/<a href='(.*?)' title='(.*?)'>(.*?)<\/a>/", $exec, $hasil);

preg_match_all('/<strong class="(.*?)">\n(.*?)<\/strong>/', $exec, $hasil2);

preg_match_all('/<strong class="(.* ?)">\n(.* ?)>\n(.*?)<\/strong>/', $exec, $hasil3);

 print "Domain       : $domain \n";
 print "Country      : ".$hasil[3][0]."\n";
 print "Local Rank   :\033[1;31m ".$hasil2[2][0]."\033[0m \n";
 print "Global Rank  : \033[1;33m".$hasil3[3][0]."\033[0m \n";
 print "+--------------------------------+\n";

}