#include <iostream>
#include <string>
#include <fstream>
#include <vector>
#include <bits/stdc++.h>
#include <chrono>

using namespace std;




bool compareStr (string str1, string str2) { return (str1.compare(str2) < 0); }

void bruteForce(string target, string s, int maxLen, int maxTime, bool &done, chrono::steady_clock::time_point begin) {
    std::chrono::steady_clock::time_point end = std::chrono::steady_clock::now();
    int ms = std::chrono::duration_cast<std::chrono::milliseconds>(end - begin).count();
    if (target.compare(s) == 0) {
        done = true;
        cout << "Password found in " << ms << " milliseconds." << endl;
        return;
    }
    //cout << s << endl;
    
    if (done == true) {
        return;
    }
    if (ms >= maxTime) {
        done = true;
        cout << "Passowrd not found in timeframe! Safe!" << endl;
        return;
    }
    if (s.length() > maxLen) {
        return;
    }

    for (char i = '0'; i <= 'z'; i++) {
        string a = i + s;
        bruteForce(target, a, maxLen, maxTime, done, begin);
    }
    return;
}

bool binSearch (vector<string> &vec, string target) {
    int mid;
    int start = 0;
    int stop = vec.size();

    while (start < stop) {
        mid = (start + stop) / 2;
        if (vec[mid].compare(target) > 0) {
            stop = mid;
        }
        else if (vec[mid].compare(target) < 0) {
            start = mid+1;
        }
        else {
            return true;
        }
    }
    return false;
}

int main() {
    ifstream rockyou ("rockyou.txt");
    vector<string> rockyouVec;
    string line;
    string input;
    bool keepGoing = true;

    //int count = 0;

    printf("Loading, please wait.\n");

    if (rockyou.is_open()) {
        while (getline(rockyou, line)) {
            rockyouVec.push_back(line);
            //count++;
        }

        sort(rockyouVec.begin(), rockyouVec.end(), compareStr);

        /*
        for (int i = 0; i < 100; i++) {
            cout << rockyouVec[i] << endl;
        }
        */
        
    }

    while (keepGoing) {
        cout << "Enter password to test: ";
        cin >> input;

        if (binSearch(rockyouVec, input)) {
            cout << "Password found in rockyou.txt! Unsafe!" << endl;
        }
        else {
            cout << "Password not found in rockyou.txt! Safe!" << endl;
        }

        bool done = false;
        chrono::steady_clock::time_point begin = chrono::steady_clock::now();
        cout << "Brute-forcing password." << endl;
        bruteForce(input, "", 5, 100000, done, begin);

        cout << "Would you like to continue? [Y/N]" << endl;
        cin >> input;

        if (!(input.compare("Y") == 0) && !(input.compare("YES") == 0)) {
            keepGoing = false;
        }
    }

    rockyou.close();
    return 0;
}