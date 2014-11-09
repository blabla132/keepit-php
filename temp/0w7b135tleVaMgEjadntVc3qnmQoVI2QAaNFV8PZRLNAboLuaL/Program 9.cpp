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
	int num, counter = 1;
	
	while (counter <= 5) {
		num = counter * 2;
		cout << counter << " doubled is " << num << endl;
		counter ++;
	}
	
	// ********************* PROBLEM 2 *********************
	cout << "You will input two numbers. This program will determine if the numbers are equal, or if one is larger than the other." << endl;
	cout << endl;
	
	double A, B;
	cout << "A = ";
	cin >> A;
	cout << "B = ";
	cin >> B;
	
	cout << endl;
	
	if (A>B) {
		cout << A << " > " << B << endl;
		cout << "Larger";
	} else if (A<B) {
		cout << A << " < " << B << endl;
		cout << "Smaller";
	} else {
		cout << A << " = " << B << endl;
		cout << "Equal";
	}
    
    return 0;
}


