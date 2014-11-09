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
	
	cout << "This program will determine the appropriate letter grade and message for a certain percentage.\n\nInput the percentage of the grade here and press <enter>\n > ";
	int percent;
	
	cin >> percent;
	
	string letter, message;
	
	if (percent > 100) {
		letter = "A+";
		message = "Excellent";		
	} else if (percent <= 100 && percent >= 90) {
		letter = "A";
		message = "Solid work";
	} else if (percent < 90 && percent >= 80) {
		letter = "B";
		message = "Doing fine";
	} else if (percent < 80 && percent >= 70) {
		letter = "C";
		message = "Need to work harder";
	} else if (percent < 70 && percent >= 60) {
		letter = "D";
		message = "On probation";
	} else if (percent < 60 && percent >= 0) {
		letter = "F";
		message = "You are failing";
	} else {
		letter = "N/A";
		message = "Can't have negative score";
	}
	
	cout << "\tGrade\t\tLetter Grade\t\tMessage" << endl << "\t" << percent << "\t\t" << letter << "\t\t\t" << message << endl;
    
    cout << endl << endl << "done" << endl;
    
    return 0;
}


