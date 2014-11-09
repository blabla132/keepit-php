//
//  main.cpp
//  Program 2
//
//  Created by Liyang Zhang 2016 on 6/10/13.
//  Copyright (c) 2013 Liyang Zhang 2016. All rights reserved.
//

//precompiler directives:
#include <iostream>
#include <iomanip>
#include <fstream>
#include <cmath>

using namespace std;

int main(  )
{
    
    // ********************* PROBLEM 1 *********************
    double C = 30;
    double F = 9*C/5 + 32;
    cout << "CELSIUS\tFAHRENHEIT" << endl << C << "\t\t" << F << endl << endl;
    
    // ********************* PROBLEM 2 *********************
    double A = 78000;
    double R = 6.45;
    double T = A * R / 100;
    
    cout << "The tax on a house with an assessed value of $" << A << " and a tax rate of $" << R << "per $100 is $" << T << "." << endl << endl;
    
    // ********************* PROBLEM 3 *********************
    double T1 = 89;
    double T2 = 72;
    double T3 = 86;
    
    double average = (T1 + T2 + T3) / 3;
    cout << "test1\ttest2\ttest3\taverage" << endl << T1 << "\t\t" << T2 << "\t\t" << T3 << "\t\t" << average << endl << endl;
    
    // ********************* PROBLEM 4 *********************
    double H = 38;
    R = 4.75;
    
    double P = H * R;
    cout << "Todd worked " << H << " hours at a rate of $" << R << " and earned $" << P << "." << endl;
    
    cout << endl << endl << "done" << endl;
    
    return 0;
}

