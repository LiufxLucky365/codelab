# coding=utf-8
 
import os, sys, copy

# 对输入文件排序
def main (unsortFile):
    f = open(unsortFile, 'r')
    unsortList = []
    for line in f.readlines():
        unsortList.append(int(line.strip())) # 把末尾的'\n'删掉
    print(unsortList)

    # 保留原始对象
    sortList = copy.copy(unsortList)

    bubbleSort(sortList)
    print(sortList)


# 冒泡排序
def bubbleSort (unsortList):
    i = 0
    j = len(unsortList) - 1

    while i < j:
        for start in range (i, j):  # range from i to j, exclude j
            if unsortList[start] > unsortList[start + 1]:
                temp = unsortList[start]
                unsortList[start] = unsortList[start + 1]
                unsortList[start + 1] = temp
        i = i + 1
        j = j - 1
    return


if __name__ == "__main__":
    unsortFile = sys.argv[1]
    main(unsortFile)
