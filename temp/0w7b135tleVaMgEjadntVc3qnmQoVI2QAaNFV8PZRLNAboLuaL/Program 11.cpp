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
	for (int i=0;i<4;i++) {
		for (int j=7;j<=10;j++) {
			cout << j << " ";
		}
		cout << endl;
	}
	
	cout << endl;
	for (int i=0;i<4;i++) {
		cout << "* ";
		for (int j=2;j<=10;j+=2) {
			cout << j << " ";
		}
		cout << endl;
	}
	
	cout << endl;
	for (int i=0;i<4;i++) {
		for (int j=1;j<=4;j++) {
			cout << j << " ";
		}
		cout << "0 ";
		for (int j=6;j<=9;j++) {
			cout << j << " ";
		}
		cout << endl;
	}
	
	cout << endl;
	
	// ********************* PROBLEM 2 *********************
	for (int i=0;i<3;i++) {
		for (int j=0;j<3;j++) {
			cout << "A " << (j+1) << " ";
		}
		cout << endl;
	}
	
	cout << endl;
	for (int i=0;i<4;i++) {
		cout << "<";
		for (int j=0;j<10;j++) {
			cout << "*";
		}
		cout << ">" << endl;
	}
	
	cout << endl;
	for (int i=0;i<6;i++) {
		for (int j=1;j<=4;j++) {
			if (i%2==0)
				cout << j << " ";
			else 
				cout << 5-j << " ";
		}
		cout << endl;
	}
	
	cout << endl;
	
	// ********************* PROBLEM 3 *********************
	for (int i=0;i<3;i++) {
		cout << "$ ";
		for (int j=0;j<3;j++) {
			if (j > 0) cout << "# ";
			for (int k=1;k<=5;k++) {
				cout << k << " ";
			}
		}
		cout << "$" << endl;
	}
	
    return 0;
}


