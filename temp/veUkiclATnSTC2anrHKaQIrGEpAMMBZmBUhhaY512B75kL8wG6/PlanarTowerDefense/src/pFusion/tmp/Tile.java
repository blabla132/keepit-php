package pFusion.tmp;

import java.awt.Color;

public class Tile {
	private int x, y, c;

	/*
	 * 
	 * KEY:
	 * 
	 * 0 = AVAILABLE TILE; 1 = ROAD TILE; 2 = ENTER TILE; 3 = EXIT TILE;
	 */

	public Tile(int x, int y, int c) {
		this.x = x;
		this.y = y;
		this.c = c;
	}

	public void setX(int x) {
		this.x = x;
	}

	public void setY(int y) {
		this.y = y;
	}

	public void setC(int c) {
		this.c = c;
	}

	public int getX() {
		return this.x;
	}

	public int getY() {
		return this.y;
	}

	public int getC() {
		return this.c;
	}

	public Color getHoverColor(int theme) {
		Color tmp = getColor(theme);
		int k = 30;
		int r = tmp.getRed() + k, b = tmp.getBlue() + k, g = tmp.getGreen() + k;
		if (r > 255)
			r = 255;
		if (g > 255)
			g = 255;
		if (b > 255)
			b = 255;
		return new Color(r, g, b, tmp.getAlpha());
	}

	public Color getPressColor(int theme) {
		Color tmp = getColor(theme);
		int k = 30;
		int r = tmp.getRed() - k, b = tmp.getBlue() - k, g = tmp.getGreen() - k;
		if (r < 0)
			r = 0;
		if (g < 0)
			g = 0;
		if (b < 0)
			b = 0;
		return new Color(r, g, b, tmp.getAlpha());
	}

	public Color getColor(int theme) {
		switch (c) {
		case 0:
			return new Color(225, 225, 225, 85);
		case 1:
			switch (theme) {
			case 0:
				return new Color(200, 64, 64, 85);
			case 1:
				return new Color(64, 200, 64, 85);
			case 2:
				return new Color(64, 64, 200, 85);
			}
		case 2:
			switch (theme) {
			case 0:
				return new Color(175, 32, 32, 85);
			case 1:
				return new Color(32, 175, 32, 85);
			case 2:
				return new Color(32, 32, 175, 85);
			}
		case 3:
			switch (theme) {
			case 0:
				return new Color(175, 32, 32, 85);
			case 1:
				return new Color(32, 175, 32, 85);
			case 2:
				return new Color(32, 32, 175, 85);
			}
		default:
			return new Color(0, 0, 0, 85);
		}
	}
}
