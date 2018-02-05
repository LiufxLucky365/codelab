# coding=utf-8
 
import os, sys, copy

# 设置递归深度为一百万 
sys.setrecursionlimit(1000000)

# 对输入文件排序
def main (unsortFile):
    f = open(unsortFile, 'r')
    unsortList = []
    for line in f.readlines():
        unsortList.append(int(line.strip())) # 把末尾的'\n'删掉
    print(unsortList)

    # 保留原始对象
    sortList = copy.copy(unsortList)

    quickSort(sortList)
    print(sortList)

# 快排
def quickSort(unsortList):
    start = 0
    end = len(unsortList) - 1
    quickSortSplit(start, end, unsortList)

def quickSortSplit(start, end, unsortList):
    if start >= end:
        return

    # 利用list完成交换
    splitPos = start
    insertCount = 0
    splitPosVal = unsortList[splitPos]
    tempList = [splitPosVal]
    for i in range(start + 1, end + 1):
        if unsortList[i] < splitPosVal:
            tempList.insert(0, unsortList[i])
            insertCount += 1
        else:
            tempList.append(unsortList[i])
    splitPos = start + insertCount

    # 将list写回待排序数组
    j = 0
    for i in range(start, end + 1):
        unsortList[i] = tempList[j]
        j += 1

    # 递归
    quickSortSplit(start, splitPos - 1, unsortList)
    quickSortSplit(splitPos + 1, end, unsortList)

if __name__ == '__main__':
    unsortFile = sys.argv[1]
    main(unsortFile)