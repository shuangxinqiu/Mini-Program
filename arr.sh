#!/bin/bash
echo "shell 传递单数实例"
echo "\$0执行的文件名：$0";
echo "\$#参数的个数：$#";
echo "\$$脚本运行的当前ID号：$$";
echo "\$1第一个参数: $1";
echo "\$2第二个参数：$2";
echo "\$*一个字符串显示所有参数：$*";
echo "\$@显示所有参数用引号：$@";
echo "-- \$@ 演示";
for i in "$@"; do
	echo $i;
done

echo "-- \$* 演示";
for i in "$*"; do
	echo $i;
done
