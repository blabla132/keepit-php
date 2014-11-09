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
    const double PI = 3.141592653589793238462643383279502884197;
    // ********************* PROBLEM 1 *********************
    double L = 6;
    double r = 5;
    double TA = PI*r*L + PI*r*r;
    
    cout << "Total Area = " << TA << " Units squared" << endl;
    
    // ********************* PROBLEM 2 *********************
    double a = 7;
    double b = 8.4;
    
    double c = sqrt(a*a + b*b);
    cout << "c = " << c << endl;
    
    // ********************* PROBLEM 3 *********************
    double h = 0.6;
    double b1 = 1.3;
    double b2 = 3.5;
    
    double A = 0.5 * h * (b1 + b2);
    cout << "Area = " << A << " Units squared" << endl;
    
    // ********************* PROBLEM 4 *********************
    h = 12;
    r = 3;
    
    double volume = PI * r * r * h;
    cout << "Volume = " << volume << " Units cubed" << endl;
    
    // ********************* PROBLEM 5 *********************
    double d1 = 3;
    double d2 = 5;
    double d3 = 7;
    
    double s = (d1 + d2 + d3) /2;
    A = sqrt(s*(s-d1)*(s-d2)*(s-d3));
    
    cout << "Area = " << A << " Units squared" << endl;
    
    // ********************* PROBLEM 6 *********************
    double diameter = 10;
    
    double SA = pow(diameter,2) - PI*pow(diameter/2,2);
    cout << "Shaded Area = " << SA << " Units squared" << endl;
    
    cout << endl << endl << "done" << endl;
    
    return 0;
}

