- 将文件夹下的文件批量转化
```
@echo off
for /f %%I in ('dir input\*.flv /B') do (
	echo %%~nI
	ffmpeg -i input\%%~nI.flv -vcodec copy -acodec copy -f mp4 input\%%~nI.mp4
	ffmpeg -i input\%%~nI.mp4 -c copy -movflags faststart output\%%~nI_moov.mp4
	del input\%%~nI.mp4
)
pause
```

- 将文件夹下的文件批量转化
```
@echo off
for /f %%I in ('dir input\*.flv /B') do (
	echo %%~nI
	ffmpeg -i input\%%~nI.flv -vcodec copy -acodec copy -f mp4 input\%%~nI.mp4
	ffmpeg -i input\%%~nI.mp4 -vcodec copy -acodec copy -f flv output\%%~nI_transfer.flv
	del input\%%~nI.mp4
)
pause
```
