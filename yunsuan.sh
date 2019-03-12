#!/bin/bash
a=10
b=20
str="abd"


echo `expr $a + $b`;
echo `expr $a - $b`;
echo `expr $a \* $b`;
echo `expr $a / $b`;
echo `expr $a % $b`;
if [ $a == $b ]
then
	echo 'a = b';
fi

if [ $a != $b ]
then
	echo 'a!=b';
fi


if [ $a -eq $b ]
then
	echo "$a -eq $b : a等于b";
else
	echo "$a -eq $b : a不等于b";
fi

if [ $a -ne $b ]
then
	echo "$a -ne $b : a不等于b";
else 
	echo "$a -ne $b : a等于b";
fi

if [ $a -gt $b ] 
then 
	echo "$a -gt $b : a大于b";
else
	echo "$a -gt $b : a不大于b";
fi 

if [ $a -lt $b ]
then 
	echo "$a -lt $b : a小于b";
else 
	echo "$a -lt $b : a不小于b";
fi

if [ $a -ge $b ]
then
	echo "$a -ge $b : a大于等于b";
else 
	echo "$a -ge $b ：a小于b";
fi

if [ $a -le $b ] 
then
	echo "$a -le $b : a小于等于b";
else 
	echo "$a -le $b : a大于b";
fi

if [ $a -lt 100 -a $b -gt 15 ]
then
	echo "$a 小于 100 且 $b 大于 15 ： 返回true";
else
	echo "$a 小于 100 且 $b 大于15 ： 返回false";
fi

if [ $a -lt 100 -o $b -gt 100 ]
then
	echo "$a 小于100 或 $b 大于 100 ： 返回true";
else
	echo "$a 小于 100 或 $b 大于 100 ： 返回false";
fi

if [ -z $str ]
then
	echo "-z $str : 字符串长度为0";
else
	echo "-z $str : 字符串长度不为0";
fi

if [ -n "$str" ]
then 
	echo "-n $str : 字符串长度不为0";
else
	echo "-n $str : 字符串长度为0";
fi

if [ $str ]
then 
	echo "$str : 字符串不为空";
else
	echo "$str : 字符串为空";
fi
