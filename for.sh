#!/bin/bash
#一行格式
for loop in 1 2 3 4 5;do echo "value is $loop";done;

for str in 'this is a string'
do
	echo $str;
done

int=1
while(( $int<=5 ))
do 
	echo $int
	let "int++"
done

#echo '按下ctrl+D退出'
#echo -n '输入你最喜欢的网址：'
#while read Film
#do 
#	echo "是的！$Film 是一个好网站"
#done

a=0
until [ ! $a -lt 10 ]
do
	echo $a
	let "a++"
done

for (( i=1;i<3;i++ ))
do
	echo "$i 次"
done
