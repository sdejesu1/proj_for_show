#ifndef MERGESORT_H
#define MERGESORT_H

#include "printVec.h"

template<typename Comparable>
void mergeSortRec(vector<Comparable> &vec, int startIndex, int endIndex, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    // Recursive base case
    if (startIndex >= endIndex) {
        return;
    }

    // Recursive calls for the left and right halves
    int centerIndex = (startIndex + endIndex) / 2;
    mergeSortRec(vec, startIndex, centerIndex, totalReads, totalWrites);
    mergeSortRec(vec, centerIndex + 1, endIndex, totalReads, totalWrites);

    // Merge
    vector<Comparable> temp;
    int leftIndex = startIndex;
    int rightIndex = centerIndex + 1;
    // While leftIndex and rightIndex are in bounds of their half
    while (leftIndex <= centerIndex && rightIndex <= endIndex) {
        if (vec[leftIndex] <= vec[rightIndex]) { // two reads
            reads += 2;
            temp.push_back(vec[leftIndex]); // read and write
            reads += 1;
            writes += 1;
            ++leftIndex;
        } else {
            temp.push_back(vec[rightIndex]); // read and write
            reads += 1;
            writes += 1;
            ++rightIndex;
        }
    }
    // Now one of the halves is empty and the other half has at least one element left to copy into temp
    while (leftIndex <= centerIndex) {
        temp.push_back(vec[leftIndex]); // read and write
        reads += 1;
        writes += 1;
        ++leftIndex;
    }
    while (rightIndex <= endIndex) {
        temp.push_back(vec[rightIndex]); // read and write
        reads += 1;
        writes += 1;
        ++rightIndex;
    }
    // Now everything between startIndex and endIndex is copied into temp
    // Copy everything from temp back into vec
    for (int i = 0; i < temp.size(); ++i) {
        vec[i + startIndex] = temp[i]; // read and write
        reads += 1;
        writes += 1;
    }

    totalReads += reads;
    totalWrites += writes;
    //printVec(vec);
}

template<typename Comparable>
void mergeSort(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    mergeSortRec(vec, 0, vec.size() - 1, totalReads, totalWrites);
}

#endif
