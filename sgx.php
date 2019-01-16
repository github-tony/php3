<?php

$url = 'http://www.sgx.com/JsonRead/JsonstData?qryId=RStock&timeout=30&%20noCache=1547045465';
//$url = 'http://localhost/mynote/data/sgxdata.txt';
$content = get_fcontent($url);
$i = stripos($content, '[{ID:');
$sub_str = substr($content, $i) ;
//print_r($sub_str);
$content = $sub_str;

//{ID:9,N:'Accrelist',SIP:'',NC:'5RJ',R:'',I:'',M:'t',LT:0.003,C:0.000,VL:250.500,BV:17348.500,B:'0.003',S:'0.004',SV:24891.700,O:0.003,H:0.003,L:0.003,V:751.500,SC:'4',PV:0.003,PTD:'20190104',BL:'100',EX:'',EJ:'',CLO:'',P:0.000,P_:'X',V_:''}
$ss = "{ID:132,N:'China Sunsine',SIP:'',NC:'CH8',R:'',I:'',M:'',LT:1.350,C:0.060,VL:1366.700,BV:133.300,B:'1.340',S:'1.350',SV:127.000,O:1.310,H:1.350,L:1.280,V:1799078.000,SC:'2',PV:1.290,PTD:'20190109',BL:'100',EX:'',EJ:'',CLO:'',P:4.651,P_:'',V_:''}";
$ss = "{ID:216,N:'Fujian Zhenyun',SIP:'',NC:'5KT',R:'',I:'SUSP',M:'t',LT:0,C:0,VL:0.000,BV:0,B:'',S:'',SV:0,O:0,H:0,L:0,V:0.000,SC:'2',PV:0.149,PTD:'20141210',BL:'100',EX:'',EJ:'',CLO:'',P:0,P_:'',V_:''}";
$stock_code = "CH8";

$arr_code = ['CH8', 'C6L', 'BKV', 'P15', 'G92', 'P74', '5KT']; //;
//$arr_code = array('P74');

$html = <<<EOT
    <html>
    <head>
        <title>Stock List</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>Stock List</div>
  
           <table border="1">
            <tr>
                <th>Short Name</th>
                <th>Code</th>
                <th>Last</th>
                <th>Chng</th>
                <th>Chng %</th>
                <th>Vol(00s)</th>
                <th>Bid</th>
                <th>Ask</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
            </tr>
EOT;

foreach ($arr_code as &$value) {
    $stock_code = $value;
//    $ss = "{ID:133,N:'China Sunsine',SIP:'',NC:'CH8',R:'',I:'',M:'',LT:1.300,C:-0.030,VL:417.600,BV:24.200,B:'1.300',S:'1.310',SV:71.500,O:1.330,H:1.350,L:1.290,V:548983.000,SC:'2',PV:1.330,PTD:'20190111',BL:'100',EX:'',EJ:'',CLO:'',P:-2.256,P_:'',V_:''";
//    {ID:538,N:'SIA',SIP:'',NC:'C6L',R:'',I:'',M:'',LT:9.720,C:0.020,VL:283.100,BV:1.100,B:'9.710',S:'9.720',SV:11.600,O:9.760,H:9.780,L:9.710,V:2758563.000,SC:'7',PV:9.700,PTD:'20190115',BL:'100',EX:'',EJ:'',CLO:'',P:0.206,P_:'',V_:''}
//{ID:217,N:'Fujian Zhenyun',SIP:'',NC:'5KT',R:'',I:'SUSP',M:'t',LT:0,C:0,VL:0.000,BV:0,B:'',S:'',SV:0,O:0,H:0,L:0,V:0.000,SC:'2',PV:0.149,PTD:'20141210',BL:'100',EX:'',EJ:'',CLO:'',P:0,P_:'',V_:''}

    $pattern = "/{ID:\d+,N:'(?<N>[a-zA-Z0-9\s]+)',SIP:(?<SIP>'\w*'),NC:'" . $stock_code . "',R:'\w*',I:'[A-Za-z]*',M:'\w*',LT:(?<LT>\d+(\.\d+)?),C:(?<C>(-?\d+)(\.\d+)?),VL:(\d+(\.\d+)?),BV:(\d+(\.\d+)?),B:'(?<B>\d*(\.\d+)?)',"
            . "S:'(?<S>\d*(\.\d+)?)',SV:(?<SV>\d+(\.\d+)?),O:(?<O>\d+(\.\d+)?),H:(?<H>\d+(\.\d+)?),L:(?<L>\d+(\.\d+)?),V:(?<V>(\d+)\.(\d+)),SC:'(\d+)',PV:(\d+)\.(\d+),PTD:'(\d+)',BL:'(\d+)',EX:'\w*',EJ:'\w*',CLO:'\w*',P:(?<P>(-?\d+)(\.\d+)?),P_:'\w*',V_:''}/U"; //

    preg_match($pattern, $content, $matches);


//    print_r($matches[0]);
//    continue;
    $ss2 = <<<EOT
            <tr>
                <td>{$matches['N']}</td>
                <td>{$stock_code}</td>
                <td align="right">{$matches['LT']}</td>
                <td align="right">{$matches['C']}</td>
                <td align="right">{$matches['P']}</td>
                 <td align="right">{$matches['V']}</td>
                  <td align="right">{$matches['B']}</td>
                <td align="right">{$matches['S']}</td>
                <td align="right">{$matches['O']}</td>
                <td align="right">{$matches['H']}</td>
                <td align="right">{$matches['L']}</td>
            </tr>
EOT;
    $html = $html . $ss2;
}
$html = $html . " </table>  </body></html>";
print_r($html);

//$sub_str = substr($content, $i);
//echo $content;


function get_fcontent($url, $timeout = 5) {
    $url = str_replace("&amp;", "&", urldecode(trim($url)));
    //$cookie = tempnam("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}
