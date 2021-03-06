<?php
include 'config.php';
include 'pay.php';
header ( "content-type:text/html;charset=utf-8" );

$params =array_merge(array('merchno'=>MERCHNO),$_POST) ;
$params['merchname']=strtoupper(unicode_encode($params['merchname']));
$params['buytime']=strtoupper(unicode_encode($params['buytime']));
$params['product']=strtoupper(unicode_encode($params['product']));
$params['productdesc']=strtoupper(unicode_encode($params['productdesc']));

$pay=new Pay();

$url_str=$pay->create_url($params);
$sign=$pay->data_signature($url_str);
$url='https://cashier.gomepay.com?'.$url_str.'&dstbdatasign='.$sign;
$res=$pay->FORM_POST($url);

die;

//将内容进行UNICODE编码，编码后的内容格式：\u56fe\u7247 （原始：图片）
function unicode_encode($name)
{
	$name = iconv('UTF-8', 'UCS-2', $name);
	$len = strlen($name);
	$str = '';
	for ($i = 0; $i < $len - 1; $i = $i + 2)
	{
		$c = $name[$i];
		$c2 = $name[$i + 1];
		if (ord($c) > 0)
		{    // 两个字节的文字
			$str .= base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
		}
		else
		{
			$str .= $c2;
		}
	}
	return $str;
}

