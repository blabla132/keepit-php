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
	
	// ********************* PROBLEM 3 *********************
	int i = 1;
	double s = 1, c = 1;
	
	cout << "Integer\tSquare Root\tCube Root" << endl;
	do {
		cout << i << "\t" << s << "\t\t" << c << endl;
		i += 1;
		s = pow(i,0.5);
		c = pow(i,1./3);
	} while (c < 2.5);
	
	cout << endl;
	
	// ********************* PROBLEM 4 *********************
	double cost = 1.95;
	int year = 2013;
	
	cout << "Year\tCost" << endl;
	
	cout << fixed;
	
	do {
		cout << year << "\t" << setprecision(2) << cost << endl;
		year += 1;
		cost *= 1.05;
	} while (cost <= 10);
	
	cout << year << "\t" << cost << endl;
	
	// ********************* PROBLEM 5 *********************
	int x;
	int x1;
	
	cout << "What is the value of x?\n > ";
	cin >> x1;
	
	if (abs(x1) != x1) {
		cout << "Can't be negative." << endl;
		return 0;
	} else {
		x = x1;
		int c = 0;
		do {
			if (x % 2 == 0) {
				x /= 2;
			} else {
				x = 3*x+1;
			}
			c += 1;
			cout << x << " ";
		} while (x != 1);
		
		cout << "It took " << c << " replacements." << endl;
	}
    
    return 0;
}


