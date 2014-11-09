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
	// ********************* CONSTANTS *********************
	const double PI = 3.1415926535897932384626433832795028841971693993;
	
	// ********************* PROBLEM 1 *********************
	double F = -35;
	double C;
	
	cout << "C\tF" << endl;
	do {
		C = 5*(F-32)/9;
		cout << F << "^F\t" << C << "^C" << endl;
		F += 5;
	} while (F <= 125);
	
	cout << endl;
	
	// ********************* PROBLEM 2 *********************
	double radius = 2;
	double area, circumference;
	
	cout << "Radius\tCircumference\tArea" << endl;
	do {
		circumference = 2 * radius * PI;
		area = radius * radius * PI;
		cout << radius << "\t" << circumference << "\t\t" << area << endl;
		radius += 5;
	} while (radius <= 47);
	
    cout << endl << endl << "done" << endl;
    
    return 0;
}


