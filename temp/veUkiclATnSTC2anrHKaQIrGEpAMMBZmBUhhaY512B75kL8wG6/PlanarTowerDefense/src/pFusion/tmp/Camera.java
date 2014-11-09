package pFusion.tmp;

import java.awt.Color;
import java.awt.FontMetrics;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.InputStreamReader;

import javax.imageio.ImageIO;
import javax.swing.JFrame;

public class Camera {
	BufferedImage back;
	static Tile[][][] maps;
	static Enemy[] enemies = new Enemy[3];
	int map = 0;
	int w = 5, h = 5;

	int money = 1000;

	FontMetrics metrics;

	int R = (int) (Math.random() * 255), G = (int) (Math.random() * 255),
			B = (int) (Math.random() * 255);
	boolean R1 = (Math.random() > 0.5) ? false : true,
			G1 = (Math.random() > 0.5) ? false : true,
			B1 = (Math.random() > 0.5) ? false : true;

	public Camera() throws Exception {
		back = ImageIO.read(Camera.class.getResource("Back1.jpg"));
		loadMap();
	}

	public void nextMap() {
		map += 1;
		if (map > 2)
			map = 0;
	}

	public void prevMap() {
		map -= 1;
		if (map < 0)
			map = 2;
	}

	public void loadMap() throws Exception {
		maps = new Tile[3][w][h];
		for (int i = 0; i < 3; i++) {
			BufferedReader in = new BufferedReader(
					new InputStreamReader(
							Camera.class.getResourceAsStream("defaultMap" + i
									+ ".dat")));
			String t = in.readLine();

			for (int j = 0; j < w; j++) {
				t = in.readLine();
				for (int k = 0; k < h; k++) {
					maps[i][j][k] = new Tile(j, k, Integer.parseInt(t
							.split(",")[k]));
				}
			}
		}
		for (int i = 0; i < enemies.length; i++) {
			enemies[i] = new Enemy();
			enemies[i].setMap(i);
			enemies[i].setX(0);
			enemies[i].setY(0);
		}
	}

	public void update(long time) {
		for (int i = 0; i < enemies.length; i++) {
			enemies[i].update(time);
		}
	}

	public void draw(Graphics2D g) {
		String t = "";
		g.drawImage(back, 0, 0, PDefense.width, PDefense.height, null);
		g.setColor(new Color(R, G, B, 50));
		g.fillRect(0, 0, PDefense.width, PDefense.height);
		if (!PDefense.paused) {
			if (R1)
				R += 1;
			else
				R -= 1;
			if (G1)
				G += 1;
			else
				G -= 1;
			if (B1)
				B += 1;
			else
				B -= 1;
			if (R >= 255) {
				R = 255;
				R1 = false;
			}
			if (R <= 0) {
				R = 0;
				R1 = true;
			}
			if (G >= 255) {
				G = 255;
				G1 = false;
			}
			if (G <= 0) {
				G = 0;
				G1 = true;
			}
			if (B >= 255) {
				B = 255;
				B1 = false;
			}
			if (B <= 0) {
				B = 0;
				B1 = true;
			}
		}

		g.setFont(PFont.getFont(15));
		g.setColor(new Color(255, 255, 255));
		metrics = new JFrame().getFontMetrics(g.getFont());
		// t = "[Current map: Map " + (map + 1) +
		// "] Keyboard shortcuts: Escape to pause, Tab for next map, Shift+Tab for previous map";
		t = "[Current map: Map " + (map + 1) + "]";
		g.drawString(t, 20, 20);

		for (int i = 0; i < maps[map].length; i++) {
			for (int j = 0; j < maps[map][0].length; j++) {
				int l = 150 + (100 * i), q = 50 + (100 * j);
				if (maps[map][i][j].getC() == 0 && !PDefense.paused) {
					if (PDefense.location.x >= l
							&& PDefense.location.x <= (l + 100)
							&& PDefense.location.y >= q
							&& PDefense.location.y <= q + 100) {
						if (PDefense.leftMouse) {
							g.setColor(maps[map][i][j].getPressColor(map % 3));
						} else {
							g.setColor(maps[map][i][j].getHoverColor(map % 3));
						}
					} else {
						g.setColor(maps[map][i][j].getColor(map % 3));
					}
				} else {
					g.setColor(maps[map][i][j].getColor(map % 3));
				}
				g.fillRect(l, q, 100, 100);
			}
		}
		for (int i = 0; i < enemies.length; i++) {
			if (enemies[i].map == map) {
				enemies[i].draw(g, 150, 50, 100, 100);
			}
		}
	}
}
