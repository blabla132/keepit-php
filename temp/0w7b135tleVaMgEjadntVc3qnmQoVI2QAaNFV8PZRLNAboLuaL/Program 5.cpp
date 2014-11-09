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
	cout << "Input the mortgage amount requested and press <enter>:\n > ";
	
	double mortgage;
	cin >> mortgage;
	
	double DP;
	
	if (mortgage < 0 || mortgage >100000) {
		cout << "Please input a reasonable mortgage amount (less than 100000)";
		return 0;
	} else {
		if (mortgage <= 50000) {
			DP += 0.02 * mortgage;
		} else {
			DP += 0.02 * 50000;
			mortgage -= 50000;
			if (mortgage <= 25000) {
				DP += 0.2 * mortgage;
				}else {
					DP += 0.2 * 25000;
					mortgage -= 25000;
					DP += 0.25 * mortgage;
				}
			
		}
	}
	
	cout << "Your mortgage of $" << mortgage << " requires a down payment of $" << DP << "." << endl;
	
	// ********************* PROBLEM 2 *********************
	double T1, T2, T3, T4;
	cout << "Enter T1: ";
	cin >> T1;
	cout << "Enter T2: ";
	cin >> T2;
	cout << "Enter T3: ";
	cin >> T3;
	cout << "Enter T4: ";
	cin >> T4;
	
	double sum = T1 + T2 + T3 + T4;
	string pass = "pass";
	if (sum <= 260) {
		pass = "fail";
	}
	
	cout << "\tT1\tT2\tT3\tT4\tSum\tFinal Grade" << endl;
	cout << "\t" << T1 << "\t" << T2 << "\t" << T3 << "\t" << T4 << "\t" << sum << "\t" << pass << endl;
	
	// ********************* PROBLEM 3 *********************
	double sales, commission;
	cout << "Enter the sales\n > ";
	cin >> sales;
	
	if (sales >= 15000) 
		commission = 0.15 * sales;
	else 
		commission = 0.0725 * sales;
		
	cout << "\tSales\tCommission" << endl;
	cout << "\t" << sales << "\t" << commission << endl;
	
    cout << endl << endl << "done" << endl;
    
    return 0;
}


