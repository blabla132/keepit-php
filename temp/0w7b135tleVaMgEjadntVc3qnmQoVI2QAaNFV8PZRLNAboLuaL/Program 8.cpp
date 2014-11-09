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
	
	cout << fixed;
	
	double amount, rate, payment;
	cout << "Amount? ";
	cin >> amount;
	cout << "Rate? ";
	cin >> rate;
	cout << "Payment? ";
	cin >> payment;
	
	int month = 1;
	
	double interest, principal;
	
	cout << "MONTH\tAMOUNT\tINTEREST\tTO PRINCIPAL" << endl;
	do {
		interest = rate*amount/1200;
		principal = payment - interest;
		if (principal > amount) principal = amount;
		cout << month << "\t" << setprecision(2) << amount << "\t" << interest << "\t\t" << principal << endl;
		amount -= principal;
		month++;
	} while (amount > 0);
    
    return 0;
}


