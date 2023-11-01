#ifndef QUICKSORT_H
#define QUICKSORT_H

#include "printVec.h"

template<typename Comparable>
void quickSortUnstableRec(vector<Comparable> &vec, int startIndex, int endIndex, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    // Recursive base case
    if (startIndex >= endIndex) {
        return;
    }

    // Choose a partition element
    Comparable partition = vec[startIndex]; // read and write
    reads += 1;
    writes += 1;

    // Loop through vec from startIndex to endIndex
    // Keep track of where the > partition elements start
    int i;
    int largerElementIndex = startIndex+1;
    Comparable temp;
    for (i = startIndex+1; i <= endIndex; ++i) {
        if (vec[i] <= partition) { // 2 reads
            reads += 2;

            // Swap the smaller/equal item to the left of the larger items
            temp = vec[i]; // read and write
            reads += 1;
            writes += 1;

            vec[i] = vec[largerElementIndex]; // read and write
            reads += 1;
            writes += 1;

            vec[largerElementIndex] = temp; // read and write
            reads += 1;
            writes += 1;

            // Update largerElementIndex
            ++largerElementIndex;
        }
    }
    // Swap the partition element into place
    temp = vec[startIndex]; // read and write
    reads += 1;
    writes += 1;

    vec[startIndex] = vec[largerElementIndex-1]; // read and write
    reads += 1;
    writes += 1;

    vec[largerElementIndex-1] = temp; // read and write
    reads += 1;
    writes += 1;

    totalReads += reads;
    totalWrites += writes;

    //printVec(vec);

    // Recursive calls for two halves
    quickSortUnstableRec(vec, startIndex, largerElementIndex-2, totalReads, totalWrites);
    quickSortUnstableRec(vec, largerElementIndex, endIndex, totalReads, totalWrites);
}

template<typename Comparable>
void quickSortUnstable(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    quickSortUnstableRec(vec, 0, vec.size() - 1, totalReads, totalWrites);
}

template<typename Comparable>
void quickSortStableRec(vector<Comparable> &vec, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    // Recursive base case
    if (vec.size() <= 1) {
        return;
    }

    // Choose a partition element
    Comparable partition = vec[0]; // read and write
    reads += 1;
    writes += 1;


    vector<Comparable> smaller, equal, larger;
    // Loop through vec and populate smaller, equal, larger
    int i;
    for (i = 0; i < vec.size(); ++i) {
        if (vec[i] < partition) { // 2 reads
            reads += 2;

            smaller.push_back(vec[i]); // read and write
            reads += 1;
            writes += 1;

        } else if (vec[i] > partition) { // 2 reads
            reads += 2;

            larger.push_back(vec[i]); // read and write
            reads += 1;
            writes += 1;

        } else {
            equal.push_back(vec[i]); // read and write
            reads += 1;
            writes += 1;
        }
    }

    // Recursive calls
    quickSortStableRec(smaller, totalReads, totalWrites);
    quickSortStableRec(larger, totalReads, totalWrites);

    // Copy elements from smaller, equal, and larger back into vec
    for (i = 0; i < vec.size(); ++i) {
        if (i < smaller.size()) {
            vec[i] = smaller[i]; // read and write
            reads += 1;
            writes += 1;

        } else if (i < smaller.size() + equal.size()) {
            vec[i] = equal[i - smaller.size()]; // read and write
            reads += 1;
            writes += 1;

        } else {
            vec[i] = larger[i - smaller.size() - equal.size()]; // read and write
            reads += 1;
            writes += 1;

        }
    }

    totalReads += reads;
    totalWrites += writes;
    //printVec(vec);
}

template<typename Comparable>
void quickSortStable(vector<Comparable> vec, long &totalReads, long &totalWrites) {
    quickSortStableRec(vec, totalReads, totalWrites);
}


#endif
