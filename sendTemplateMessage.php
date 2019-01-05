<?php
include_once '../common/check.php';

$appid = '你自己的appid';
$appsecret = '你自己的secret';

function getHttpArray($url, $post_data)
{
//	echo $url;
//	echo $post_data;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //没有这个会自动输出，不用print_r();也会在后面多个1

	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

	$output = curl_exec($ch);

	var_dump($output);
	curl_close($ch);
	$out = json_decode($output);

	return $out;
}

function getAccessToken($appid, $appsecret)
{

	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	$res = file_get_contents($url);
	$output = json_decode($res, true);

	$accessToken = $output['access_token'];
	return $accessToken;
}




$sql = "select * from accessToken where appid = '{$appid}'";
$stmt = $pdo->query($sql);
if ($stmt->rowCount() > 0) {        //有accesstoken
	$a = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($a['Time'] < time()) {        //超过有效时间 重新获取并更新数据库
		$accesstoken = getAccessToken($appid, $appsecret);
		$time = time() + 7000;
		$sql3 = "update accessToken set Time = '{$time}',AccessToken = '{$accesstoken}' where appid = '{$appid}'";
		$stmt3 = $pdo->exec($sql3);
		if ($stmt3 > 0) {
			$accessToken = $accesstoken;
			echo "失效重新获取更新成功";
		} else {
			echo "失效重新获取更新失败";
		}
	} else {        //未超过有效时间 直接返回
		$accessToken = $a['AccessToken'];
		echo "没有失效";
	}
} else {        //无accesstoken
	$time = time() + 7000;    //100分钟后的时间戳
	$accesstoken = getAccessToken($appid, $appsecret);        //获取accesstoken
	$sql2 = "insert into accessToken(appid,appsecret,AccessToken,Time)values ('{$appid}','{$appsecret}','{$accesstoken}','{$time}')";
	$stmt2 = $pdo->exec($sql2);
	if ($stmt2 > 0) {
		$accessToken = $accesstoken;
		echo "无accesstoken且获取插入成功";
	} else {
		echo "无accesstoken且获取插入失败";
	}
}


//echo $accessToken;

$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$accessToken}";


$sql = "select msg.* from msg where msg.Status = 0 order by id limit 100";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
	$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $r) {
		if ($r['Status'] == 0) {
			$sql = "update msg set Status = 1 where id = {$r['id']}";
			$stmt = $pdo->exec($sql);
			$sql2 = "SELECT FormId FROM formId where Status = 1 and openid = '{$r['touser']}' order by AddTime limit 1";
			$stmt2 = $pdo->query($sql2);
			if ($stmt2->rowCount() > 0) {
				$res2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$form_id = $res2['FormId'];
			} else {
				$form_id = '';
			}
			if ($r['Type'] == 'remind') {
				$data = <<<END
{
  "touser": "{$r['touser']}",
  "template_id": "{$r['template_id']}",
  "page": "{$r['page']}",
  "form_id": "{$form_id}",
  "data": {
      "keyword1": {
          "value": "{$r['keyword1']}"
      },
      "keyword2": {
          "value": "{$r['keyword2']}"
      },
      "keyword3": {
          "value": "{$r['keyword3']}"
      },
      "keyword4": {
          "value": "{$r['keyword4']}"
      }
  }
}
END;
			} elseif ($r['Type'] == 'Presult') {
				$data = <<<END
{
  "touser": "{$r['touser']}",
  "template_id": "{$r['template_id']}",
  "page": "{$r['page']}",
  "form_id": "{$form_id}",
  "data": {
      "keyword1": {
          "value": "{$r['keyword1']}"
      },
      "keyword2": {
          "value": "{$r['keyword2']}"
      },
      "keyword3": {
          "value": "{$r['keyword3']}"
      }
  }
}
END;
			} else {
				$data = <<<END
{
  "touser": "{$r['touser']}",
  "template_id": "{$r['template_id']}",
  "page": "{$r['page']}",
  "form_id": "{$form_id}",
  "data": {
      "keyword1": {
          "value": "{$r['keyword1']}"
      },
      "keyword2": {
          "value": "{$r['keyword2']}"
      }
  }
}
END;
			}


			$sql3 = "update formId set Status = '0' where FormId = '{$form_id}' and Status = '1'";
			$stmt3 = $pdo->exec($sql3);
			if ($stmt3) {

			} else {
				$sql = "update msg set Status = '-1' where id = {$r['id']}";
				$stmt = $pdo->exec($sql);
			}
			$result = getHttpArray($url, $data);
		}
	}

} else {
	$result = '没有成功';
}

echo $result;