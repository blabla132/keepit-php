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
	ifstream f1;
	f1.open("nbrs1.dat");
	
	double data;
	while (f1 >> data) {
		if (data > 25) {
			cout << data << endl;
		}
	}
	
	cout << endl;
	
	// ********************* PROBLEM 2 *********************
	double S = 25, R, D, T;
	
	cout << fixed;
	
	cout << "Speed (MPH)\tReaction Dist\tBraking Dist\tTotal Dist" << endl;
	do {
		R = S*5200/7200;
		D = 0.06*S*S;
		T = R+D;
		cout << setprecision(1) << S << "\t\t" << R << "\t\t" << D << "\t\t" << T << endl;
		S += 5;
	} while (S <= 90);
	
	// ********************* PROBLEM 3 *********************
	int Y = 1;
	double amount = 500;
	
	cout << "Year\tAmount" << endl;	
	do {
		amount *= 1.05;
		cout << setprecision(2) << Y << "\t$" << amount << endl;
		Y += 1;
	} while (Y <= 10);
	
    return 0;
}


