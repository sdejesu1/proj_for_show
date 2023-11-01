#ifndef SORTING_BUBBLESORT_H
#define SORTING_BUBBLESORT_H
#include "Review.h"

#include "printVec.h"

template<typename Comparable>
void bubbleSort(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    int numPasses = 0, i;
    Comparable temp;
    bool haveSwapped = true;
    while (haveSwapped) {
        haveSwapped = false;
        for (i = 0; i+1 < vec.size()-numPasses; ++i) {
            // Compare items at indices i and i+1 and swap if necessary
            reads += 1;
            if (vec[i] > vec[i+1]) { // 2 reads
                reads += 1;

                temp = vec[i]; // read and write
                writes += 1;

                vec[i] = vec[i+1]; // read and write
                writes += 1;

                vec[i+1] = temp; // read and write
                writes += 1;
                // Update haveSwapped
                haveSwapped = true;
            }
        }
        // Update numPasses
        ++numPasses;
        totalReads += reads;
        totalWrites += writes;
    }

}

#endif
