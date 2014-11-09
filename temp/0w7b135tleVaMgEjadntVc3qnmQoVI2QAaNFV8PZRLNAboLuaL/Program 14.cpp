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
	double a,b;
	ifstream f1;
	f1.open("p14_1.dat");
	
	while (f1 >> a >> b) {
		if (a<0) {
			cout << a*b << endl;
		} else {
			cout << a+b << endl;
		}
	}
	
	cout << endl;
	// ********************* PROBLEM 2 *********************
	ifstream f2;
	f2.open("p14_2.dat");
	
	while (f2 >> a >> b) {
		if (a>0) {
			if (b<0) {
				cout << a << endl;
			} else {
				cout << b << endl;
			}
		} else {
			cout << a+b << endl;
		}
	}
	
	cout << endl;
	// ********************* PROBLEM 3 *********************
	
	string c;
	ifstream f3;
	f3.open("p14_3.dat");
	
	cout << fixed;
	
	cout << "EMPLOYEE\tREGULAR HOURLY RATE\tNUMBER OF HOURS WORKED\tPAY" << endl;
	while (f3 >> c >> a >> b) {
		string q = "";
		if (c.length() < 8) q = "\t\t"; else q = "\t";
		
		double pay = 0;
		if (b<=40) {
			pay = a*b;
		} else {
			pay = a*40;
			b -= 40;
			pay += 1.5*a*b;
		}
		
		cout << setprecision(2) << c << q << a << "\t\t\t" << b << "\t\t\t" << pay << endl;
	}
	
    return 0;
}


