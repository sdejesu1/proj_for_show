#ifndef SORTING_SELECTIONSORT_H
#define SORTING_SELECTIONSORT_H

#include "printVec.h"

template<typename Comparable>
void selectionSort(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    // ints reads and writes added
    int reads = 0;
    int writes = 0;
    int swapIndex, i, minIndex;
    Comparable temp;
    for (swapIndex = 0; swapIndex < vec.size()-1; ++swapIndex) {
        // Loop through vector starting at swapIndex and keep track of min
        minIndex = swapIndex;
        for (i = swapIndex+1; i < vec.size(); ++i) {
            if (vec[i] < vec[minIndex]) { // two reads
                reads += 2;
                // We have a new minimum
                minIndex = i;
            }
        }
        // Swap min value into swapIndex spot in vector
        temp = vec[swapIndex]; // read and write
        vec[swapIndex] = vec[minIndex]; // read and write
        vec[minIndex] = temp; // read and write
        reads += 3;
        writes += 3;

        // adding reads and writes to total reads and total writes, to accumulate
        totalReads += reads;
        totalWrites += writes;
        //printVec(vec);
    }
}

#endif
