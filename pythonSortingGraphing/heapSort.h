#ifndef SORTING_HEAPSORT_H
#define SORTING_HEAPSORT_H

#include "printVec.h"
#include <vector>
using std::vector;

// Helper function for heapSort
inline int leftChild(int i) {
    return 2 * i + 1;
}

// Helper function for heapSort
// i is the index of the value being percolated down
// n is the number of items in the heap
template <typename Comparable>
void percolateDown(vector<Comparable> &items, int& i, unsigned long& n, int& child, Comparable& tmp, long &totalReads, long &totalWrites) {
    int reads = 0;
    int writes = 0;
    for(tmp = items[i]; leftChild(i) < n; i = child) { // read and write
        reads += 1;
        writes += 1;
        child = leftChild(i);
        // choose the child with the larger value
        if (child != n - 1 && items[child] < items[child + 1]) {
            ++child;
        }
        // if the parent is less than the child, swap them
        if (tmp < items[child]) { // 2 reads
            reads += 2;

            items[i] = items[child]; // read and write
            reads += 1;
            writes += 1;

        } else {
            // parent is >= both children. nothing more to do.
            break;
        }
    }
    items[i] = tmp; // read and write
    reads += 1;
    writes += 1;

    totalReads += reads;
    totalWrites += writes;
}

template <typename Comparable>
vector<Comparable> heapSort(vector<Comparable> items, long &totalReads, long &totalWrites) {
    int reads, writes = 0;
    int i, child;
    Comparable temp, tmp;
    unsigned long j, n;
    // build the heap (with max value at root)
    for (i = items.size() / 2 - 1; i >= 0; --i) {
        n = items.size();
        percolateDown(items, i, n, child, tmp, totalReads, totalWrites);
    }
    //printVec(items);
    // keep deleting the max
    for (j = items.size() - 1; j > 0; --j) {
        // swap the maximum out
        temp = items[0]; // read and write
        reads += 1;
        writes += 1;

        items[0] = items[j]; // read and write
        reads += 1;
        writes += 1;

        items[j] = temp; // read and write
        reads += 1;
        writes += 1;

        // make it into a heap again
        i = 0;
        percolateDown(items, i, j, child, tmp, totalReads, totalWrites);

        // printVec(items);
        totalReads += reads;
        totalWrites += writes;
    }
    return items;
}

#endif
