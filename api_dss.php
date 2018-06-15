<?php   header("Content-type: text/xml;charset=window-1251");header('Access-Control-Allow-Origin: *'); header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS'); header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        header('Content-Type:text/html;charset=UTF-8'); mb_internal_encoding('UTF-8'); mb_http_output('UTF-8'); mb_http_input('UTF-8'); mb_regex_encoding('UTF-8'); 
        /*ini_set('soap.wsdl_cache_enabled', 0);ini_set('soap.wsdl_cache_ttl', 900);ini_set('default_socket_timeout', 15);
        $soap_params = ['soap_version' => SOAP_1_2,'trace' => 1, 'exceptions'     => true,    'verifypeer' => false,'verifyhost' => false,'cache_wsdl'=> WSDL_CACHE_NONE,'encoding'=>'UTF-8','connection_timeout'=>15000,'style'=>SOAP_RPC,'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',   //   "urn:xmethods-delayed-quotes",  // Пространство имен SOAP-метода 
                            "soapaction" => "urn:xmethods-delayed-quotes#getQuote",  // HTTP-заголовок SOAPAction  для SOAP-метода 
                            "use"      => SOAP_ENCODED,"location" => $url];*/
//echo 'POST: '; var_dump($_POST); echo '<br>GET: '; var_dump($_GET); echo '<hr>';die; 
$classmap = array('ArrayOfKeyValueOfSignatureParamsstring1Iy7z97I'=>'ArrayOfKeyValueOfSignatureParamsstring1Iy7z97I'
    ,'KeyValueOfSignatureParamsstring1Iy7z97I'=>'KeyValueOfSignatureParamsstring1Iy7z97I'
    ,'DSSPreSignResponse'=>'DSSPreSignResponse'
    ,'DssFault'=>'DssFault'
    ,'DSSLitePolicy'=>'DSSLitePolicy'
    ,'ArrayOfSignatureType'=>'ArrayOfSignatureType'
    ,'ArrayOfTspService'=>'ArrayOfTspService'
    ,'TspService'=>'TspService'
    ,'PreSignArgs'=>'PreSignArgs'
    ,'PostSignArgs'=>'PostSignArgs'
    ,'EnhanceSignatureArgs'=>'EnhanceSignatureArgs'
    ,'PreSignDocument'=>'PreSignDocument'
    ,'PreSignDocumentResponse'=>'PreSignDocumentResponse'
    ,'PostSignDocument'=>'PostSignDocument'
    ,'PostSignDocumentResponse'=>'PostSignDocumentResponse'
    ,'EnhanceSignature'=>'EnhanceSignature'
    ,'EnhanceSignatureResponse'=>'EnhanceSignatureResponse'
    ,'GetPolicy'=>'GetPolicy'
    ,'GetPolicyResponse'=>'GetPolicyResponse'
    ,'PreSignDocumentRest'=>'PreSignDocumentRest'
    ,'PreSignDocumentRestResponse'=>'PreSignDocumentRestResponse'
    ,'PostSignDocumentRest'=>'PostSignDocumentRest'
    ,'PostSignDocumentRestResponse'=>'PostSignDocumentRestResponse'
    ,'EnhanceSignatureRest'=>'EnhanceSignatureRest'
    ,'EnhanceSignatureRestResponse'=>'EnhanceSignatureRestResponse'
    ,'GetPolicyRest'=>'GetPolicyRest'
    ,'GetPolicyRestResponse'=>'GetPolicyRestResponse',
    'VerifyCertificate'=>'VerifyCertificate',
    'VerifyCertificateResponse'=>'VerifyCertificateResponse'
    );
    class DSSPreSignResponse{ var $HashValue; /*base64Binary*/ var $СacheObjectId; /*string*/} 
    class PreSignDocumentResponse{ var $PreSignDocumentResult; /*DSSPreSignResponse*/ }
    class PostSignDocumentResponse{ var $PostSignDocumentResult;/*base64Binary*/  } 
    class VerifyCertificateResponse{ var $VerifyCertificateResult;/*base64Binary*/  }  
/* */


$a = json_decode($_POST['selected_sert']);
$thumbprint  = $a->thumbprint;
$subjectName = $a->subjectName;
$issuerName  = $a->issuerName;
$validFrom   = preg_split('/ /',$a->validFrom)[0];
$validTo     = preg_split('/ /',$a->validTo)[0]; 
$name        = $a->name;
$label       = $a->label;
/*echo "thumbprint =>$thumbprint
    subjectName=>$subjectName
    issuerName =>$issuerName 
    validFrom  =>$validFrom  
    validTo    =>$validTo    
    name       =>$name       
    label      =>$label";

    thumbprint =>4B6EF3934B373724AA818A6F8EA36FF400273EBC
    subjectName=>CN=STRONGGgg
    issuerName =>CN=CRYPTO-PRO Test Center 2, O=CRYPTO-PRO LLC, L=Moscow, C=RU, E=support@cryptopro.ru 
    validFrom  =>22.05.2018 08:50:06  
    validTo    =>22.08.2018 09:00:06    
    name       =>STRONGGgg       
    label      =>STRONGGgg (до 22.08.2018 09:00:06)
    die;*/

//exec("convert -size 230x130 -background lightblue -font verdana.ttf -pointsize 25 \\\-gravity NorthWest caption:\"The quick red foxjumped over thelazy brown dog.\" \\\-flatten caption4.jpg");

$img_stamp      = base64_encode(file_get_contents('./gerb_RF.png', 1));  
$thumbprint     = $thumbprint; // ='4B6EF3934B373724AA818A6F8EA36FF400273EBC';
$komuVydan      = $name;
$kemVydan       =  $issuerName;//'CN=CRYPTO-PRO Test Center 2, O=CRYPTO-PRO LLC';
$deystvitelen   = "c $validFrom по $validTo";

/*если с общепринятыми бумажными форматами и их размерами народ знаком (А4 — это лист 297×210 мм), то с переводом их в пиксели возникают сложности. 
Количество пикселей для листа А4 зависит от параметра DPI, который вы применяете: 
при dpi=75, А4 имеет 877×620 px. при dpi=150, А4 имеет 1754×1240 px.*/
 
//А4 =>>> width:595pt; height:  842pt;// точно в ПТ ? -> х-з..
//А4 =>>> width:793px; height: 1123px; 
/*
var pt = 1; 
var px = (4/3)*pt ///1.(3) 
var em = pt/12 ////0.08(3) 
var percent = pt*100/12 ///8.(3)

!!!! ! !  !  ! ==>> A4 =>> 595x842 <= .PDF <==== ! ! ! ! ! 

А4 — 297×210 мм:
297*0,3528 = 104,7816 pt
210*0,3528 = 74,08800 pt
=> real A4 in PoinTs: 104,7816 pt x 74,08800 pt
=> real A4 in PiXels: 139.709 px x 98.784 px
*/
/*Параметры шаблонов подписи.
-- Размеры.
Размеры всех элементов в представлении подписи и в шаблоне указываются в единицах
измерения – типографских пунктах Adobe (points). 1 пункт = 1/72 дюйма = 0,3528 мм.
-- Система координат.
Положение представления подписи на странице задаётся в системе координат PDF документа.
Точка с координатами (0, 0) соответствует левому нижнему углу страницы
*/

//$document = base64_encode(file_get_contents('./example.pdf', 1));     //$document 		=	'data:application/pdf;base64,JVBERi0xLjQKJcKlwrEKCgoKMSAwIG9iagogIDw8IC9UeXBlIC9DYXRhbG9nCiAgICAgL1BhZ2VzIDIgMCBSCiAgPj4KZW5kb2JqCgoyIDAgb2JqCiAgPDwgL1R5cGUgL1BhZ2VzCiAgICAgL0tpZHMgWzMgMCBSXQogICAgIC9Db3VudCAxCiAgICAgL01lZGlhQm94IFswIDAgMzAwIDE0NF0KICA+PgplbmRvYmoKCjMgMCBvYmoKICA8PCAgL1R5cGUgL1BhZ2UKICAgICAgL1BhcmVudCAyIDAgUgogICAgICAvUmVzb3VyY2VzCiAgICAgICA8PCAvRm9udAogICAgICAgICAgIDw8IC9GMQogICAgICAgICAgICAgICA8PCAvVHlwZSAvRm9udAogICAgICAgICAgICAgICAgICAvU3VidHlwZSAvVHlwZTEKICAgICAgICAgICAgICAgICAgL0Jhc2VGb250IC9UaW1lcy1Sb21hbgogICAgICAgICAgICAgICA+PgogICAgICAgICAgID4+CiAgICAgICA+PgogICAgICAvQ29udGVudHMgNCAwIFIKICA+PgplbmRvYmoKCjQgMCBvYmoKICA8PCAvTGVuZ3RoIDU1ID4+CnN0cmVhbQogIEJUCiAgICAvRjEgMTggVGYKICAgIDAgMCBUZAogICAgKEhlbGxvIFdvcmxkKSBUagogIEVUCmVuZHN0cmVhbQplbmRvYmoKCnhyZWYKMCA1CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwMDAxOCAwMDAwMCBuIAowMDAwMDAwMDc3IDAwMDAwIG4gCjAwMDAwMDAxNzggMDAwMDAgbiAKMDAwMDAwMDQ1NyAwMDAwMCBuIAp0cmFpbGVyCiAgPDwgIC9Sb290IDEgMCBSCiAgICAgIC9TaXplIDUKICA+PgpzdGFydHhyZWYKNTY1CiUlRU9GCg==';
$path = 'C:\\inetpub\\wwwroot\\crypto-pro\\example'; 
$rawCertificate	=	'MIIDTTCCAvygAwIBAgITEgAo/xmgmogykwRyHAAAACj/GTAIBgYqhQMCAgMwfzEjMCEGCSqGSIb3DQEJARYUc3VwcG9ydEBjcnlwdG9wcm8ucnUxCzAJBgNVBAYTAlJVMQ8wDQYDVQQHEwZNb3Njb3cxFzAVBgNVBAoTDkNSWVBUTy1QUk8gTExDMSEwHwYDVQQDExhDUllQVE8tUFJPIFRlc3QgQ2VudGVyIDIwHhcNMTgwNTIyMDU1MDA2WhcNMTgwODIyMDYwMDA2WjAUMRIwEAYDVQQDDAlTVFJPTkdHZ2cwgaowIQYIKoUDBwEBAQIwFQYJKoUDBwECAQIBBggqhQMHAQECAwOBhAAEgYC6r8fqmZVixavsbN5jwzJwDC99v+ULJsqrvckJio2BDx9kXXtX/K78isuQcC2eTxkL78Hth01j4F3MPuWszokQw1UCO3u+pxB6ixbU0e6EB9FV5FniFqyj7sfVykR2jGJlG96GN1zio5ySBUuoNjOauArA2Pi8wuM3wtO/Ie2q6aOCAXAwggFsMA4GA1UdDwEB/wQEAwIE8DATBgNVHSUEDDAKBggrBgEFBQcDAjAdBgNVHQ4EFgQUJPtZJdx2r7uH7CSlxg3csra0fPkwHwYDVR0jBBgwFoAUFTF8sI0a3mbXFZxJUpcXJLkBeoMwWQYDVR0fBFIwUDBOoEygSoZIaHR0cDovL3Rlc3RjYS5jcnlwdG9wcm8ucnUvQ2VydEVucm9sbC9DUllQVE8tUFJPJTIwVGVzdCUyMENlbnRlciUyMDIuY3JsMIGpBggrBgEFBQcBAQSBnDCBmTBhBggrBgEFBQcwAoZVaHR0cDovL3Rlc3RjYS5jcnlwdG9wcm8ucnUvQ2VydEVucm9sbC90ZXN0LWNhLTIwMTRfQ1JZUFRPLVBSTyUyMFRlc3QlMjBDZW50ZXIlMjAyLmNydDA0BggrBgEFBQcwAYYoaHR0cDovL3Rlc3RjYS5jcnlwdG9wcm8ucnUvb2NzcC9vY3NwLnNyZjAIBgYqhQMCAgMDQQB+Ty/WjMuVPiNsy1liF5tYHW4sJvIiM8Nhl0iKX0HWl2jCUKHSqiM+2QuP28dnuETGLPdDKWDlV/5teoyS7/F9';

$verifyingCert = VerifyCertificate($rawCertificate)["msg"]["Result"]; //проверка сертификата на валидность!
if($verifyingCert) echo_end_die(["stat"=>0,"msg"=>"The certificate is wrong!"]); // поправить на продакшене!
sleep(1);
$url            =   'https://ssd.marinet.ru/ssd/LiteService.svc?wsdl'; 
$fixX=236;//189; размер печати
$fixY=99;//100  

$example_doc = "$path/example.pdf";

if($_GET['stampGen']==1) { //PREVIEW doc SIGN:
    $RectLowerLeftX = 1;
    $RectLowerLeftY = 1;
    $template = getStamp ($img_stamp, $thumbprint, $komuVydan, $kemVydan, $deystvitelen, $RectLowerLeftX, $RectLowerLeftY,$fixX,$fixY);
    if($_GET['action']=='sign') {
            $doc_name = "stamp_white_templ";
            if( $_GET['stage'] == 1 ) {
                exec('convert -size '.($fixX+2).'x'.($fixY+2)." xc:white $path/$doc_name.pdf"); // создаем белый PDF  189x100   
                $document = base64_encode(file_get_contents("$path/$doc_name.pdf", 1));         // читаем его из диска;
                $a = stage1($url, $rawCertificate, $template, $classmap, $document);            // подписываем его;
                echo_end_die([
                    "stat"           =>  $a["stat"], 
                    "HashValue"      =>  $a["HashValue"], 
                    "СacheObjectId"  =>  $a["СacheObjectId"] 
                    ]);

            } elseif ( $_GET['stage'] == 2 ) {
                $document = base64_encode(file_get_contents("$path/$doc_name.pdf", 1));
                $a = stage2($url, $rawCertificate, $template, $classmap, $document   ); 
                    $document = $a["base64Binary"];
                    $docName_stage2 = $doc_name."_stage2";
                    base64save($document, "$path/$docName_stage2.pdf"); //base64  .pdf  -> .pdf
                    //pdf -> transparent PNG:
                    exec("convert -density 200 -alpha remove -alpha off +antialias -transparent white $path/$docName_stage2.pdf -transparent white $path/$docName_stage2.png");
                    $base64Binary = base64_encode(file_get_contents("$path/$docName_stage2.png"));                    
                    exec("convert -density 200 $example_doc"."[0] $example_doc.jpg");
                    $doc_prev = base64_encode(file_get_contents("$example_doc.jpg"));  
                    echo $base64Binary."[BREAK]".$doc_prev; die;   //stamp_img
            } else { throw_err('Stage required!');}
    }    else    {     throw_err('Unknown stampGen-action!');     } 

        
}else{

    $x = json_decode($_POST['pechat_pos'])->x;
    $y = json_decode($_POST['pechat_pos'])->y;
 
    $RectLowerLeftX = $x;//правый край max -> 595 //дроби не любит ПДФ !онли целое!
    $RectLowerLeftY = $y; //верхний край max-> 842 //дроби не любит ПДФ  !онли целое!

    $template = getStamp ($img_stamp, $thumbprint, $komuVydan, $kemVydan, $deystvitelen, $RectLowerLeftX, $RectLowerLeftY,$fixX,$fixY);

    // SIGN:
    $document = base64_encode(file_get_contents($example_doc , 1));
    if($_GET['action']=='sign')  {
        if(    $_GET['stage']==1){ echo_end_die(stage1($url, $rawCertificate, $template, $classmap, $document));}
        elseif($_GET['stage']==2){ echo_end_die(stage2($url, $rawCertificate, $template, $classmap, $document));}
        else  { throw_err('Stage required!');   }
    } else {    throw_err('Unknown action!');   } 
}
 
function getStamp ( $img_stamp, $thumbprint='4B6EF3934B373724AA818A6F8EA36FF400273EBC',
                    $komuVydan='Иванов Иван Иванович', $kemVydan='УЦ Минкомсвязи', 
                    $deystvitelen='с 12.12.2017 по 12.12.2018', 
                    $RectLowerLeftX=33, 
                    $RectLowerLeftY=22,
                    $fixX=215, $fixY=110){

    function space($e=1) {return '{"Text":" ","Font": {"FontSize":'.$e.'} },';}
    if(strlen($kemVydan)>45){ $spaceDesc = space(1);}
    else{$spaceDesc = space(3);}



    $fontSertDesc  = '"Font": { "FontSize": 8, "FontFamily": "times", "FontStyle": 0, "FontColor": {"Red": 0,"Green": 0,"Blue": 0}}';
        $stamp = '{
        "Content": [ 
            {"Text": "ДОКУМЕНТ ПОДПИСАН",
             "Margin": 65,
             "Font": {
                "FontSize": 9,
                "FontFamily": "times",
                "FontStyle": 1,
                "FontColor": {"Red": 0,"Green": 0,"Blue": 0}
                }
            },
            {"Text": "ЭЛЕКТРОННОЙ ПОДПИСЬЮ",
                "Margin": 55,
                "Font": {
                    "FontSize": 9,
                    "FontFamily": "times",
                    "FontStyle": 1,
                    "FontColor": {"Red": 0,"Green": 0,"Blue": 0}
                }
            },
            {"Text":" ","Font": {"FontSize":2}},
            {"Text": "СВЕДЕНИЯ О СЕРТИФИКАТЕ ЭП",
                "Margin": 53,
                "Font": {
                    "FontSize": 8,
                    "FontFamily": "times",
                    "FontStyle": 5,
                    "FontColor": {"Red": 0,"Green": 0,"Blue": 0}
                }
            },
            '.space(5).'
            {"Text": "Сертификат: '.$thumbprint.'",      '.$fontSertDesc.'},    '.$spaceDesc.'
           {"Text": "Кому выдан: '.$komuVydan.'",       '.$fontSertDesc.'},    '.$spaceDesc.'
           '//{"Text": "Кем выдан: '.$kemVydan.'",         '.$fontSertDesc.'},    '.$spaceDesc.'
           // {"Text": "Действителен: '.$deystvitelen.'",  '.$fontSertDesc.'}
        .'
        ],            
        "TemplateId": 2,
        "Icon": {
            "Image": "'.$img_stamp.'",
            "LowerLeftX": 15,
            "LowerLeftY": 52,
            "Scale": 15
        },
        "Rect": {
            "LowerLeftX": '.$RectLowerLeftX.',
            "LowerLeftY": '.$RectLowerLeftY.',
            "UpperRightX": '.($RectLowerLeftX+$fixX).',
            "UpperRightY": '.($RectLowerLeftY+$fixY).',
            "BorderRadius": 7,
            "BorderWeight": 2,
            "BorderColor": {
                "Red": 0,
                "Green": 0,
                "Blue": 0
            },
            "BackgroundColor": null,
            "ContentMargin": 6
        },
        "Page": 1
    }';
    return base64_encode($stamp); 
}
 
// сохраняем ПДФ из БЕЙС64  на диск!
function base64save($document, $savePath){
    $source = fopen($document, 'r');  //$randName = uniqid();
    $destination = fopen($savePath, 'w');
    stream_copy_to_stream($source, $destination); 
}
/*var_dump($output);
fclose($source);    fclose($destination);
echo "<br><img class='bordered' src='data:image/jpg;base64,".base64_encode(file_get_contents("$path\\$randName.jpg"))."'/>";
echo '<style>.bordered { border: 2px black dashed}</style>';
unlink("$path\\$randName.pdf"); unlink("$path\\$randName.jpg");
die;  
 */ 
//exec("convert  inline:data:application/pdf;base64,$document $path\\pdf_doc.jpg  2>&1", $output); var_dump($output);
//die;

    /*
array(8) {
     [0]=> string(68) "PreSignDocumentResponse PreSignDocument(PreSignDocument $parameters)" 
     [1]=> string(71) "PostSignDocumentResponse PostSignDocument(PostSignDocument $parameters)" 
     [2]=> string(71) "EnhanceSignatureResponse EnhanceSignature(EnhanceSignature $parameters)" 
     [3]=> string(50) "GetPolicyResponse GetPolicy(GetPolicy $parameters)" 
     [4]=> string(68) "PreSignDocumentResponse PreSignDocument(PreSignDocument $parameters)" 
     [5]=> string(71) "PostSignDocumentResponse PostSignDocument(PostSignDocument $parameters)" 
     [6]=> string(71) "EnhanceSignatureResponse EnhanceSignature(EnhanceSignature $parameters)" 
     [7]=> string(50) "GetPolicyResponse GetPolicy(GetPolicy $parameters)" }
*/

function throw_err($msg){echo json_encode(["stat"=>0,"msg"=>$msg]);die;}
function echo_end_die($data){echo json_encode($data); die;}
function VerifyCertificate($rawCertificate){
    try {           $urlVerify = 'http://ssd.marinet.ru/ssd_verif/service.svc?wsdl';
                    $soap_service = new SoapClient ( $urlVerify, ['cache_wsdl'     => WSDL_CACHE_NONE] );
                    $res = $soap_service->VerifyCertificate( ['certificate'=>$rawCertificate] ); 
                    $Message               = $res->VerifyCertificateResult->Message;
                    $Result                = $res->VerifyCertificateResult->Result;
                    //$SignerCertificate   = $res->VerifyCertificateResult->SignerCertificate;
                    $SignerCertificateInfo = $res->VerifyCertificateResult->SignerCertificateInfo;
                    return ["stat" => 1, "msg"=>["Message"=>$Message,"Result"=>$Result,/*"SignerCertificate" => $SignerCertificate,*/"SignerCertificateInfo" => $SignerCertificateInfo ] ];
                    /*echo "Message >>  ";           print($Message);
                    echo 'Result >> ';                var_dump($Result);
                    echo 'SignerCertificate >> ';     var_dump($SignerCertificate);
                    echo 'SignerCertificateInfo >> '; var_dump($SignerCertificateInfo);*/
                   // echo json_encode($data); 
    } catch(Exception $e) {return ['stat' => 0, 'msg' => 'Err => VerifyCertificate(); __getLastRequest()=>'.$soap_service->__getLastRequest().'<br><br> getMessage()=>'.$e->getMessage().';<br><br> ALL ERROR=>'.$e];}
} /*test:*/ //$verif = VerifyCertificate($urlVerify, $rawCertificate); echo json_encode($verif["Result"]); /*true|false*/ die;

function stage1($url, $rawCertificate, $template, $classmap, $document){
    if ( strlen($_POST['cert_base64']) > 30 && strlen($_POST['cert_base64']) < 3000 ) {  
        try {    
            $soap_service = new SoapClient( $url, array("classmap"=>$classmap,"trace" => true,"exceptions" => true) );  $soap_service->__setSoapHeaders();
            $res = new PreSignDocumentResponse(); 
            $ns1 = 'http://dss.cryptopro.ru/services/2016/01/';
            $ns2 = "http://schemas.microsoft.com/2003/10/Serialization/Arrays";
            $parm = array(); 
            $parm[] = new SoapVar($document,        XSD_STRING, null, null, 'document',         $ns1 );
            $parm[] = new SoapVar('PDF',            XSD_STRING, null, null, 'signatureType',    $ns1 );
            $parm[] = new SoapVar($rawCertificate,  XSD_STRING, null, null, 'rawCertificate',   $ns1 );  

            $parmKey = array();
            $parmKey[] = new SoapVar('PDFFormat', XSD_STRING, null, null, 'Key',  $ns2 );                    
            $parmKey[] = new SoapVar('CMS', XSD_STRING,       null, null, 'Value',$ns2); 

            $parmKeyValueOfSignatureParamsstring1Iy7z97I = array();
            $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT, null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                    
        
            $parmKey = array();
            $parmKey[] = new SoapVar('PdfSignatureTemplateId', XSD_STRING,  null, null, 'Key', $ns2 );                    
            $parmKey[] = new SoapVar(2, XSD_STRING,  null, null, 'Value', $ns2 );                    
            $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT,  null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                      
        
            $parmKey = array();
            $parmKey[] = new SoapVar('PdfSignatureAppearance', XSD_STRING,  null, null, 'Key', $ns2 );                    
            $parmKey[] = new SoapVar($template, XSD_STRING,  null, null, 'Value', $ns2 );                    
            $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT, null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                      
    
            $parm[] = new SoapVar($parmKeyValueOfSignatureParamsstring1Iy7z97I, SOAP_ENC_OBJECT,  null, null, 'signatureParams' , $ns1);
            $res = $soap_service->PreSignDocument( new SoapVar($parm, 301) );

            $HashValue      = base64_encode($res->PreSignDocumentResult->HashValue);
            $СacheObjectId  = $res->PreSignDocumentResult->СacheObjectId;
            return [ "stat" => 1, "HashValue" => $HashValue, "СacheObjectId" => $СacheObjectId ];
        } catch (Exception $e) {throw_err('Err:__getLastRequest()=>'.$soap_service->__getLastRequest().'getMessage()=>'.$e->getMessage().'; ALL ERROR=>'.$e); }
    } else { throw_err('Cert is corupt!'); }
}

 
function stage2($url, $rawCertificate, $template, $classmap, $document){
    $signedHashValue=  $_POST['hashValue']; $cacheObjectId  =  $_POST['cacheObjectId'];    $signatureValue =  $_POST['createdSign'];   
    try {
        $soap_service = new SoapClient( $url, array("classmap"=>$classmap,"trace" => true,"exceptions" => true) ); $soap_service->__setSoapHeaders();
        $post = new PostSignDocumentResponse();
        $ns1 = 'http://dss.cryptopro.ru/services/2016/01/';
        $ns2 = "http://schemas.microsoft.com/2003/10/Serialization/Arrays";
        $parm = array(); 
        $parm[] = new SoapVar($cacheObjectId,  XSD_STRING, null, null, 'cacheObjectId', $ns1 );
        $parm[] = new SoapVar($signedHashValue,XSD_STRING, null, null, 'signedHashValue', $ns1 );
        $parm[] = new SoapVar($signatureValue, XSD_STRING, null, null, 'signatureValue', $ns1 );
        $parm[] = new SoapVar('PDF',           XSD_STRING, null, null, 'signatureType', $ns1 );

        $parmKey = array();
        $parmKey[] = new SoapVar('PDFFormat', XSD_STRING, null, null, 'Key',  $ns2 );                    
        $parmKey[] = new SoapVar('CMS', XSD_STRING, null, null, 'Value',$ns2);
        
        $parmKeyValueOfSignatureParamsstring1Iy7z97I = array();
        $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT, null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                    
      
        $parmKey = array();
        $parmKey[] = new SoapVar('PdfSignatureTemplateId', XSD_STRING, null, null, 'Key', $ns2 );                    
        $parmKey[] = new SoapVar(2, XSD_STRING, null, null, 'Value', $ns2 );                    
        $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT, null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                      
       
        $parmKey = array();
        $parmKey[] = new SoapVar('PdfSignatureAppearance', XSD_STRING, null, null, 'Key', $ns2 );                    
        $parmKey[] = new SoapVar($template, XSD_STRING, null, null, 'Value', $ns2 );                    
        $parmKeyValueOfSignatureParamsstring1Iy7z97I[] = new SoapVar($parmKey, SOAP_ENC_OBJECT, null, null, 'KeyValueOfSignatureParamsstring1Iy7z97I', $ns2);                      
    
        $parm[] = new SoapVar($parmKeyValueOfSignatureParamsstring1Iy7z97I, SOAP_ENC_OBJECT, null, null, 'signatureParams' , $ns1);
        $post = $soap_service->PostSignDocument( new SoapVar($parm, 301) );
        $base64Binary      = $post->PostSignDocumentResult;  
        return ["stat" => 1, "base64Binary" => 'data:application/pdf;base64,'.base64_encode($base64Binary)];
    } catch (Exception $e) { throw_err('Err:__getLastRequest()=>'.$soap_service->__getLastRequest().'; getMessage()=>'.$e->getMessage().'; ALL ERROR=>'.$e); }
 }

 
?>