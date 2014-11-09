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
	double population = 1700;
	for (int i=0;i<8;i++) {
		population *= 1.04;
	}
	cout << "At Malcolm Community College, there will be " << (int) population << " students in 8 years." << endl;
	
	cout << endl;
	// ********************* PROBLEM 2 *********************
	
	ifstream f1;
	f1.open("jobs.dat");
	
	cout << fixed;
	
	double a,b;
	while (f1 >> a >> b) {
		cout << "When Ann Sparks worked " << setprecision(0) << a << " hours at $" << setprecision(2) << b << " per hour she earned $" << a*b << "." << endl;
	}
	
	cout << endl;
	// ********************* PROBLEM 3 *********************
	
	ifstream f2;
	f2.open("rooms.dat");
	
	double sum;
	
	while (f2 >> a >> b) {
		sum += a*b;
	}
	
	cout << "Mr. Thomas' building has " << setprecision(0) << sum << " square feet of floor space." << endl;
	
	cout << endl;
	// ********************* PROBLEM 5 *********************
	
	double value = 37000;
	for (int i=0;i<5;i++) {
		value *= 0.75;
	}
	
	cout << "Hook-U's truck is worth $" << setprecision(2) << value << " in 5 years." << endl;
	
    return 0;
}


