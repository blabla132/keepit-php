package pFusion.tmp;

import java.awt.Color;

public class Entity {
	int x, y;
	int map;
	Color color;

	public Entity() {
		x = -1;
		y = -1;
		map = 0;
		color = Color.black;
	}

	public void setX(int x) {
		this.x = x;
	}

	public void setY(int y) {
		this.y = y;
	}

	public void setMap(int map) {
		this.map = map;
	}

	public void setColor(Color color) {
		this.color = color;
	}

	public int getX() {
		return x;
	}

	public int getY() {
		return y;
	}

	public int getMap() {
		return map;
	}

	public Color getColor() {
		return color;
	}
}
