package pFusion.tmp;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Point;
import java.util.ArrayList;
import java.util.LinkedHashSet;
import java.util.Set;

public class Enemy extends Entity {
	ArrayList<Point> travelled;
	int moveCountdown = 50;
	int health = 100;

	public Enemy() {
		travelled = new ArrayList<Point>();
		travelled.add(new Point(0, 0));
		color = new Color(200, 50, 50);
	}

	public void update(long time) {
		Set<Point> setItems = new LinkedHashSet<Point>(travelled);
		travelled.clear();
		travelled.addAll(setItems);
		moveCountdown -= 1;
		if (moveCountdown == 0) {
			moveCountdown = 50;
			move();
		}
	}

	public void move() {
		boolean moved = false;
		for (int i = 0; i < Camera.maps[map].length; i++) {
			for (int j = 0; j < Camera.maps[map][0].length; j++) {
				if (!moved) {
					Tile tmpTile = Camera.maps[map][i][j];
					if (tmpTile.getC() == 1) {
						int dx = (int) (Math.abs(x - tmpTile.getX())), dy = (int) (Math
								.abs(y - tmpTile.getY()));
						if ((dx == 0 && dy == 1) || (dy == 0 && dx == 1)) {
							boolean b = true;
							for (Point p : travelled) {
								if (tmpTile.getX() == p.x
										&& tmpTile.getY() == p.y) {
									b = false;
								}
							}
							if (b) {
								for (Enemy e : Camera.enemies) {
									if (map == e.map && tmpTile.getX() == e.x
											&& tmpTile.getY() == e.y) {
										b = false;
									}
								}
							}
							if (b) {
								travelled.add(new Point(x, y));
								x = tmpTile.getX();
								y = tmpTile.getY();
								moved = true;
							}
						}
					}
				}
			}
		}
	}

	public void draw(Graphics2D g, int sx, int sy, int bw, int bh) {
		int eX = sx + (x * bw) + (bw - (bw / 4 * 3)) / 2, eY = sy + (y * bh)
				+ (bh - (bh / 4 * 3)) / 2;
		g.setColor(new Color(200, 50, 50, 100));
		g.fillOval(eX, eY, bw / 4 * 3, bh / 4 * 3);
		g.setColor(color);
		g.fillArc(eX, eY, bw / 4 * 3, bh / 4 * 3, 90, 90 + (health * 360 / 100));
	}
}
