#ifndef SORTING_INSERTIONSORT_H
#define SORTING_INSERTIONSORT_H

#include "printVec.h"

template<typename Comparable>
void insertionSort(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    int unsortedStartIndex, insertIndex;
    Comparable toBeInserted;
    for (unsortedStartIndex = 1; unsortedStartIndex < vec.size(); ++unsortedStartIndex) {
        toBeInserted = vec[unsortedStartIndex]; // read and write
        reads += 1;
        writes += 1;

        // Loop to shift over the larger elements
        insertIndex = unsortedStartIndex - 1;
        while (insertIndex >= 0 && vec[insertIndex] > toBeInserted) { // two reads
            reads += 2;

            vec[insertIndex + 1] = vec[insertIndex]; // read and write
            reads += 1;
            writes += 1;

            --insertIndex;
        }
        // Put toBeInserted back into vec
        vec[insertIndex + 1] = toBeInserted; // read and write
        reads += 1;
        writes += 1;

        totalReads += reads;
        totalWrites += writes;
        //printVec(vec);
    }
}

#endif
