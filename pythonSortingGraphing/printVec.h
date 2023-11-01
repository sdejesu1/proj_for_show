#ifndef SORTING_PRINTVEC_H
#define SORTING_PRINTVEC_H

#include <ctime>
#include <iostream>
#include <vector>
#include "Review.h"
using std::cout, std::endl, std::vector;


// edited this file to print vector by the two attributes I am sorting by:


//template<typename Comparable>
void printVec(const vector<Review> &v) {
    for (int i = 0; i < v.size(); ++i) {
        if (i != 0) {
            cout << "------------";
        }
    }
    cout << endl;

    cout << "Vector attribute 1: Time" << endl;
    for (int i = 0; i < v.size(); ++i) {
        if (i != 0) {
            cout << ", ";
        }
        //edited to display vector by two attributes
        cout << v[i].getTimes();
    }
    cout << endl;
    cout << "Vector attribute 2: Score" << endl;
    for (int i = 0; i < v.size(); ++i) {
        if (i != 0) {
            cout << ", ";
        }
        //edited to display vector by two attributes
        cout << setw(10) << v[i].getScore();
    }
    cout << endl;

    for (int i = 0; i < v.size(); ++i) {
        if (i != 0) {
            cout << "------------";
        }
    }

}

#endif
