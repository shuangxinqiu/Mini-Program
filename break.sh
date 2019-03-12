#!/bin/bash
while :
do
	echo -n "输入1到4之间的数字"
	read Num
	case $Num in
		1|2|3|4) echo "你输入的数字为：$Num"
		;;
		*) echo "你输入的数字不是1到4之间的数字！游戏结束"
			break
		;;
	esac
done
