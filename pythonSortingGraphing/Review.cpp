#include "Review.h"

Review::Review() {
    productId = "1";
    userId = "stevendj3344";
    profileName = "steven";
    helpfulness = "5/5";
    score = 5;
    times = 100;
    summary = "Great food!";
    text = "The food was amazing!";
}

Review::Review(string productId, string userId, string profileName, string helpfulness, float score, long times,
               string summary, string text) {
    this->productId = productId;
    this->userId = userId;
    this->profileName = profileName;
    this->helpfulness = helpfulness;
    this->score = score;
    this->times = times;
    this->summary = summary;
    this->text = text;
}

// Implement Getters
string Review::getProductId() const {
    return productId;
}

string Review::getUserId() const {
    return userId;
}

string Review::getProfileName() const {
    return profileName;
}

float Review::getScore() const {
    return score;
}

long Review::getTimes() const {
    return times;
}

string Review::getSummary() const {
    return summary;
}

// Implement Setters
void Review::setProductId(string productId) {
    this->productId = productId;
}

void Review::setUserId(string userId) {
    this->userId = userId;
}

void Review::setProfileName(string profileName) {
    this->profileName = profileName;
}

void Review::setHelpfulness(string helpfulness) {
    this->helpfulness = helpfulness;
}

void Review::setScore(float score) {
    this->score = score;
}

void Review::setTimes(long times) {
    this->times = times;
}

void Review::setSummary(string summary) {
    this->summary = summary;
}

void Review::setText(string text) {
    this->text = text;
}

// Implement Overloaded Operators
ostream &operator<<(ostream &outs, const Review &rev) {
    //outs << left << setw(25) << rev.getProductId();
    //outs << setw(25) << rev.getUserId();
    //outs << setw(50) << rev.getProfileName();
    //outs << rev.getTimes();
    //outs << setw(1) << rev.getScore();
    //outs << setw(60) << rev.getSummary();
    return outs;
}

bool operator==(const Review &lhs, const Review &rhs) {
    return lhs.times == rhs.times;
}

bool operator<(const Review &lhs, const Review &rhs) {
    return lhs.times < rhs.times;
}

bool operator>(const Review &lhs, const Review &rhs) {
    return lhs.times > rhs.times;
}

bool operator>=(const Review &lhs, const Review &rhs) {
    return lhs.times >= rhs.times;
}

bool operator<=(const Review &lhs, const Review &rhs) {
    return lhs.times <= rhs.times;
}

// Implementation of getNumReviews
void getNumReviews(vector<Review> &reviews) {
    // ... Implementation of getNumReviews function
    string productId;
    int numId = 0;
    float totalRev = 0;
    float avgRev;

    for (int i = 1; i < reviews.size(); ++i) {
        //productId = reviews[i].getProductId(); // only used for testing / debugging to verify intended value
        if (reviews[i].getProductId() == reviews[i - 1].getProductId()) {
            numId++;
            totalRev += reviews[i - 1].getScore();

        } else {
            totalRev += reviews[i - 1].getScore();
            avgRev = totalRev / numId;

            cout << "Amount of reviews for Product " << reviews[i - 1].getProductId() << ": ";
            cout << numId << endl;

            cout << "Average review score for Product " << reviews[i - 1].getProductId() << ": ";
            cout << setprecision(3) << avgRev << "\n" << endl;

            totalRev = 0;
            avgRev = 0;
            numId = 1;
        }
    }
}

// Implementation of getDataFromFile
void getDataFromFile(string filename, vector<Review> &reviews) {
    // ... Implementation of getDataFromFile function
    ifstream inFile;
    inFile.open(filename);

    // Declare variables needed for Review object
    string productId = "", userId = "", profileName = "", helpfulness = "", summary = "", text = "", junk;
    float score = 0;
    long times = 0;

    string splitString;
    string lineString;
    while (inFile && inFile.peek() != EOF) {
        getline(inFile, lineString);
        stringstream x(lineString);
        getline(x, splitString, ' ');

        if (splitString == "" && inFile.peek() != EOF) {
            getline(inFile, lineString);
            stringstream x(lineString);
            getline(x, splitString, ' ');
            getline(x, productId, ' ');
            getline(inFile, splitString, ' ');
        }
        if (splitString == "product/productId:") {
            getline(x, productId, ' ');
            getline(inFile, splitString, ' ');

        }

        if (splitString == "review/userId:") {
            getline(inFile, userId, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/profileName:") {
            getline(inFile, profileName, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/helpfulness:") {
            getline(inFile, helpfulness, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/score:") {
            inFile >> score;
            getline(inFile, junk, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/time:") {
            inFile >> times;
            getline(inFile, junk, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/summary:") {
            getline(inFile, summary, '\n');
            getline(inFile, splitString, ' ');
        }

        if (splitString == "review/text:") {
            getline(inFile, text, '\n');

        }


        // store information in a lecturer object and add it to vector
        reviews.push_back(Review(productId, userId, profileName, helpfulness, score, times, summary, text));

    }
    inFile.close();
}