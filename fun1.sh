#!/bin/bash
#函数返回值再调用该函数后通过 $? 来获得
#注意：所有函数在使用前必须定义。这意味着必须将函数放在脚本开始部分，直至shell解析器首次发现它时，彩可以使用。使用函数仅使用其函数名即可。
demoFun(){
	echo 'this is my demoFun function'
}

funWithReturn(){
	echo "这个函数会对输入的两个数字进行相加运算"
	echo '输入第一个数字：'
	read a
	echo '输入第二个数字：'
	read b
	echo "两个数字分别为 $a 和 $b"
	return $(($a+$b))
}

#在shell中，调用函数时可以向其传递参数。在函数体内部，通过$n 的形式来获取参数的值。例如，$1表示第一个参数， $2表示第二个参数。。。
funWithParam(){
	echo "第一个参数：$1 "
	echo "第二个参数：$2 "
	echo "第十一个参数：${11} "
	echo "第十个参数：${10} "
	echo "参数总数：$# "
	echo "作为一个字符串输出所以参数： $@ "
}

echo '----demoFun begin----'
demoFun
echo '----demoFun end----'


echo '----funWithReturn begin----'
funWithReturn
echo "输入的两个数字的和为 $? "
echo '----funWithReturn end----'

echo '----funWithParam begin----'
funWithParam 1 2 3 4 5 6 7 8 9 10 11
echo '----funWithParam end'
