#!/bin/bash
str="leo" 
echo "hello world !"
for skill in Ada coffe; 
do
	echo "I am good at ${skill} script;"
done
echo `expr index "$str" eo`

arr=(arrr1 arr2 arr3)

echo ${arr[0]}
echo ${arr[@]}
echo ${#arr[@]}
echo ${#arr[0]}
