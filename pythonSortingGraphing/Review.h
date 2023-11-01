/**
 * Steven De Jesus
 * CS124
 * Section B
 * 09/14/2022
 */

#ifndef PROJECT1_REVIEW_H
#define PROJECT1_REVIEW_H

#include <iomanip>
#include <ostream>
#include <fstream>
#include <iostream>
#include <string>
#include <vector>
#include <cstring>
#include <sstream>

using namespace std;
using std::cout, std::endl, std::ifstream, std::left, std::right, std::setw, std::ostream, std::string, std::vector;


/**
 * Class representing food reviews on Amazon. There are five attributes: Product ID, UserID, Profile Name, Score, and Summary
 *
 * Fields (naming follows abbreviations used in CSV file):
 *     @param string productId: a unique product ID for which there are multiple reviews for, so it repeats often in the dataset.
 *     @param string userId: unique user ID which does not repeat in the dataset
 *     @param string profileName: unique string of multiple types of chars which makes up the profile name of the user
 *     @param string helpfulness: a string variable which takes in the value of helpfulness, which is a column in the dataset.
 *                  Here, it will just be a placeholder since it isn't important and takes up extra space.
 *                  It's a placeholder so the program can assign the upcoming string to a variable and move onto the
 *                  the next line, which is the next attribute.
 *     @param float score: float variable which takes the given score, out of 5.0
 *     @param long times: long variable which takes in the value of times, which is another column in the dataset
 *     @param string summary: string variable which takes the summary of the review, which is the last attribute.
 *     @param string text: string variable which takes the value of the entire text section, which is too much to display, as it
 *                  is very long and has characters such as <br>. I would much rather have just the summary, since it keeps
 *                  everything clean. text variable is placeholder so program keeps running smoothly.
 *
 */


class Review {
private:
    string productId;
    string userId;
    string profileName;
    string helpfulness;
    float score;
    long times;
    string summary;
    string text;

public:
    // Constructors
    Review();

    Review(string productId, string userId, string profileName, string helpfulness, float score, long times, string summary,
           string text);

    // Getters
    string getProductId() const;

    string getUserId() const;

    string getProfileName() const;

    //commented out because unnecessary (for now)
    //string getHelpfulness() const {
    //return helpfulness;
    //}

    float getScore() const;

    long getTimes() const;

    string getSummary() const ;
    //commented out because unnecessary (for now)
    //string getText() const {
    //return text;
    //}


    // Setters
    void setProductId(string productId) ;

    void setUserId(string userId) ;

    void setProfileName(string profileName) ;

    void setHelpfulness(string helpfulness);

    void setScore(float score) ;

    void setTimes(long times) ;

    void setSummary(string summary) ;

    void setText(string text) ;


    // overloaded operators
    // overloaded out operator to be able to print out entire vector (went over in class)
    friend ostream &operator<<(ostream &outs, const Review &rev) ;

    // overloaded comparisons
    // since data set has only one unique attribute, only need to check that field, which is time
    friend bool operator==(const Review &lhs, const Review &rhs) ;

    friend bool operator<(const Review &lhs, const Review &rhs) ;

    friend bool operator>(const Review &lhs, const Review &rhs) ;

    friend bool operator>=(const Review &lhs, const Review &rhs) ;

    friend bool operator<=(const Review &lhs, const Review &rhs);
};

// global function which counts number of products under 1 product ID, and counts the average score of the product ID
/**
 *
 * @param reviews - vector parameter which takes the entire vector, where I can pull the product ID, and score
 * @param productID - string variable which takes productId value from vector (only used in testing to see if desired outcome is true)
 * @param numId - int variable which is used to count how many products of one ID
 * @param totalRev - float variable which takes the score of each individual review (of a product ID) and adds it to itself each iteration, to be divided by
 *                  the number of products under the product ID to get the average
 * @param avgRev - float variable which takes totalRev and numId to calculate the average review score of all products of 1 product ID
 */
void getNumReviews(vector<Review> &reviews) ;

//use ampersand to pass vector by reference
/**
 *
 * @param reviews - vector parameter which takes the entire vector, where I can pull the product ID, and score
 * @param filename - string variable which gives name of file
 * @param inFile - ifstream variable which represents the file stream
 * @param junk - string variable which placeholds for certain characters or lines that get in the way of my desired outcomes
 * @param splitString - string variable which takes the first half of a split line, for the class variables to take the second half,
 *                      which contains the actual values I seek for my variables
 * @param lineString - string variable which takes the entire line I want, to then put it in stringstream for splitString to take the first half
 * @param stringstream x() - sstream object that takes lineString, so that I can split up lineString and essentially give the first half to
 *                           splitString
 */
void getDataFromFile(string filename, vector<Review> &reviews) ;

#endif //PROJECT1_REVIEW_H