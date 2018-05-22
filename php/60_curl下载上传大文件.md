- 程序意图
```
0. mysql导出csv文件
1. php读取csv文件中的内容
2. 根据csv下载对应文件
3. 使用ffmpeg系统命令转成wav文件 - php system方法
4. 上传ffmpeg转出来的wav文件，并把返回结果写到csv数组中
5. 写进csv文件中。
```
```
<?php

function parseData($filename)
{
    $fp = fopen($filename, "r");
    $title = fgetcsv($fp);
    while(!feof($fp)) {
        $data[] = fgetcsv($fp);// 一行数据,分隔符,的数组
    }
    fclose($fp);
    return $data;
}
function saveCsv($filename, $data)
{
	$fp = fopen($filename, "w");
	fputcsv($fp, array('id', 'mp4url', 'code', 'fileId'));
	foreach ($data as $line) {
		fputcsv($fp, $line);
	}
	fclose($fp);
}
function mp4FileNameFromUrl($mp4url)
{
	$parseData = parse_url($mp4url);
	return str_replace("/", "_", trim($parseData['path'], '/'));
}
function wavFileNameFromUrl($mp4url)
{
	$mp4FileName = mp4FileNameFromUrl($mp4url);
	return rtrim($mp4FileName, 'mp4') . 'wav';
}
function newFileName($oldCourseCsv)
{
	return str_replace("course", "course_result", $oldCourseCsv);
}

$oldCourseCsv = "./course.csv";
$course_data = parseData($oldCourseCsv);
$newCourseCsvFileName = newFileName($oldCourseCsv);
$post_url = "http://speech.ths8.com:6011/SpeechDictation/file/uploadFile.do";
$post_data = array(
	"appId" => "",
	"appKey" => "",
	"userId" => "173408538",
	//要上传的本地文件地址
);
foreach ($course_data as $key => $course) {
	$id = $course[0];
	$mp4url = $course[1];
	$wFile = mp4FileNameFromUrl($mp4url);
	$fp =  fopen($wFile, 'w+');#下载文件名称
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $mp4url);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_exec ($ch);
	curl_close ($ch);
	fclose($fp);

	$wavFile = wavFileNameFromUrl($mp4url);
	$command = "/usr/local/ffmpeg/bin/ffmpeg -i $wFile -ar 16000 -acodec pcm_s16le -ac 1 $wavFile";
	system($command, $return_var);
	$mp4File = __DIR__ . '/' . $wFile;
	$curlFile = __DIR__ . '/' . $wavFile;
	// 转码成功，上传文件
	if (0 == $return_var) {
		$post_data['file'] = new CURLFile($curlFile);
		$postch = curl_init();
		curl_setopt($postch , CURLOPT_URL , $post_url);
		curl_setopt($postch , CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($postch , CURLOPT_POST, 1);
		curl_setopt($postch , CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($postch , CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($postch);
		curl_close($postch);
		$resultData = json_decode($output, true);
		if (1 == $resultData['code']) {
			$course_data[$key]['code'] = 1;
			$course_data[$key]['fileId'] = $resultData['data']['fileId'];
		} else {
			$course_data[$key]['code'] = $resultData['code'];
			$course_data[$key]['fileId'] = '';
		}
	} else {
		$course_data[$key]['code'] = -4;// 转码失败
		$course_data[$key]['fileId'] = '';
	}
	// 删除文件
	unlink($mp4File);
	unlink($curlFile);
}

// 转码结果写入csv文件
saveCsv($newCourseCsvFileName, $course_data);
```
