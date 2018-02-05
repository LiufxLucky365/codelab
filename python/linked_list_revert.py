# coding=utf-8

import random, copy

def main():

    # 生成单链表
    linkedNode = {'val': 0, 'next': ''}
    linkedHead = {'val': 0, 'next': ''}
    linkedBottom = linkedHead

    for i in range(1, 11):
        newLinkedNode = copy.copy(linkedNode)
        newLinkedNode['val'] = i
        linkedBottom['next'] = newLinkedNode
        linkedBottom = newLinkedNode
    print(linkedHead)

    print("\n---- reverse ----\n")
    reverseLinkedList(linkedHead)
    print(linkedHead)

# 翻转链表
def reverseLinkedList (linkedHead):
    nextNode = ''
    prevNode = ''
    curNode = linkedHead
    originHead = linkedHead

    while curNode['next'] != '':
        nextNode = curNode['next']
        curNode['next'] = prevNode
        linkedHead = curNode
        prevNode = curNode
        curNode = nextNode

    # 最后一个节点接入
    curNode['next'] = prevNode
    linkedHead = curNode

    originHead['next'] = linkedHead

if __name__ == '__main__':
    main()