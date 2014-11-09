//
//  main.cpp
//  Program 1
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
	double a[5];
	
	for (int i=0;i<5;i++) {
		cout << "Please enter a number: ";
		cin >> a[i];
	}
	
	cout << endl << "The average of your numbers is " << (a[0]+a[1]+a[2]+a[3]+a[4])/5 << "." << endl;
    
    cout << endl;
    
    // ********************* PROBLEM 2 *********************
	for (int i=0;i<5;i++) {
		cout << "Please enter a number: ";
		cin >> a[i];
	}
	double product = a[0]*a[1]*a[2]*a[3]*a[4];
	
	cout << endl << "The product of your numbers is " << product << "." << endl;
    
    // ********************* PROBLEM 3 *********************
	double sum = 0;
	
	for (int i=25;i<=50;i++) {
		sum += i;
	}
	
	cout << endl << "The sum of the consecutive integers from 25 to 50 is " << sum << "." << endl;
	
    // ********************* PROBLEM 3 *********************
	product = 1;
	
	for (int i=3;i<=11;i+=2) {
		product *= i;
	}
	
	cout << endl << "The product of the odd integers from 3 to 11 is " << product << "." << endl;
    
    // ********************* PROBLEM 4 *********************
	double frac = 1, decimal = 1;
	
	for (int i=2;i<=6;i++) {
		frac *= i;
		decimal /= i;
	}
	
	cout << endl << "The product of 1/2, 1/3, 1/4, 1/5, and 1/6 is 1/" << frac << ", or " << decimal << "." << endl;
    
    return 0;
}


