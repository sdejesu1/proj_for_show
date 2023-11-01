#include "Review.h"
#include "insertionSort.h"
#include "selectionSort.h"
#include "quickSort.h"
#include "heapSort.h"
#include "mergeSort.h"
#include "bubbleSort.h"
#include <filesystem> // For working with directories and files
#include <cstdlib> // For system() function

using namespace std;

int main() {
    // long variables for total reads and writes
    long totalReads = 0;
    long totalWrites = 0;

    // Create the 'data' directory if it doesn't exist,
    // wrote "../" to go back one director since the program automatically creates it in cmake-build-debug folder.
    filesystem::create_directory("../data/insertionSort");
    filesystem::create_directory("../data/bubbleSort");
    filesystem::create_directory("../data/heapSort");
    filesystem::create_directory("../data/mergeSort");
    filesystem::create_directory("../data/quickSortUnstable");
    filesystem::create_directory("../data/quickSortStable");
    filesystem::create_directory("../data/selectionSort");

    // creating custom vector below using csv file
    // vector object for Reviews
    vector<Review> reviews;

    /**
     * checking the current directory, to know where to output results
     * filesystem::path currentPath = filesystem::current_path();
     * cout << "Current working directory: " << currentPath.string() << endl;
     */

    // Declaring the variable by which we're sorting
    cout << "\n\n\nWE ARE SORTING BY THE OBJECT'S TIME OF REVIEW, IN UNIX, IN MICROSECONDS" << endl;
    cout << "-----------------------------------------------------------------------\n" << endl;

    // INSERTION SORT
    cout << "\n\n\nINSERTION SORT" << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with insertion sort
        insertionSort(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
        << " || Total writes: " << totalWrites << endl;

        string filename = "../data/insertionSort/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // BUBBLE SORT
    cout << "\n\n\nBUBBLE SORT" << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with bubble sort
        bubbleSort(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/bubbleSort/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // HEAP SORT
    cout << "\n\n\nHEAP SORT" << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with heap sort
        heapSort(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/heapSort/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // MERGE SORT
    cout << "\n\n\nMERGE SORT" << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with merge sort
        mergeSort(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/mergeSort/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // QUICK SORT (UNSTABLE)
    cout << "\n\n\nQUICK SORT (UNSTABLE) " << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with quick sort
        quickSortUnstable(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/quickSortUnstable/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // QUICK SORT (STABLE)
    cout << "\n\n\nQUICK SORT (STABLE) " << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with quick sort
        quickSortStable(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/quickSortStable/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }

    // SELECTION SORT
    cout << "\n\n\nSELECTION SORT" << endl;
    cout << "--------------\n" << endl;

    for (int i = 100; i <= 1000; i += 100){
        getDataFromFile("../smallFoods.csv", reviews);
        // resizing vector to i elements
        reviews.resize(i);

        // sorting with selection sort
        selectionSort(reviews, totalReads, totalWrites);
        // displaying total reads and writes
        cout << "\nFor a vector of " << i << " objects:\nTotal reads: " << totalReads
             << " || Total writes: " << totalWrites << endl;

        string filename = "../data/selectionSort/output_" + to_string(i) + ".txt";

        // Writing the output to files in the 'data' folder
        ofstream outputFile(filename);
        if (outputFile.is_open()) {
            outputFile << "Reads, Writes " << endl;
            outputFile << totalReads << " " << totalWrites;
            outputFile.close();
        } else {
            cerr << "Unable to open file: " << filename << endl;
        }
        // resetting reads and writes
        totalReads = 0;
        totalWrites = 0;
        // to reset reviews
        reviews.resize(0);
    }


    // Call the Python script from the parent directory
    system("python3 ../Graph.py");

    return 0;
}