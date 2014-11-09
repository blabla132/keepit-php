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
	cout << std::scientific;
	
	// ********************* PROBLEM 3 *********************
	double a = 1.922e+14;
	int b = 75;
	
	cout << "The product of " << a << " and " << b << " is " << (a*b) << "." << endl;
	
	// ********************* PROBLEM 4 *********************
	a = 6.22e-8;
	double c = 3.511e-7;
	
	cout << "The sum of " << a << " and " << c << " is " << (a+c) << "." << endl;
	
	// ********************* PROBLEM 5 *********************
	double LS = 186000;
	double YS = 365 * 24 * 60 * 60;
	
	cout << "The distance light can travel in one year is " << (LS * YS) << " miles." << endl;
	
	// ********************* PROBLEM 6 *********************
	double MILE = 5280;
	double W = 62.4;
	
	cout << "The weight of 1000 cubic miles is " << 1000*pow(MILE,3)*W << " pounds." << endl;
	
	// ********************* PROBLEM 7 *********************
	double L = 5000, H = 9140, R = 516;
	W = 199;
	
	cout << "The total number of sheets of paper in a warehouse that have been stacked " << L << " reams long by " << W << " reams wide by " << H << " reams high is " << (L*W*H*R) << " sheets." << endl;
    
    cout << endl << endl << "done" << endl;
    
    return 0;
}


