package pFusion.tmp;

import java.awt.Color;
import java.awt.FontMetrics;
import java.awt.Graphics2D;

import javax.swing.JFrame;

public class MenuPause {

	FontMetrics metrics;

	int button1W = 400, button1H = 60, button1X = 200, button1Y = 320;
	private boolean button1O = false;
	int button3W = 400, button3H = 60, button3X = 200, button3Y = 390;
	private boolean button3O = false;

	public MenuPause() {

	}

	public void draw(Graphics2D g) {
		String t = "";

		g.setFont(PFont.getFont(100));
		g.setColor(new Color(0, 0, 0, 50));
		g.fillRect(0, 0, PDefense.width, PDefense.height);

		g.setColor(new Color(255, 255, 255));
		metrics = new JFrame().getFontMetrics(g.getFont());
		t = "PAUSED";
		g.drawString(t, PDefense.width / 2 - metrics.stringWidth(t) / 2,
				PDefense.height / 2 - metrics.getHeight() / 2);

		// RESUME BUTTON
		g.setColor(button1O ? new Color(140, 70, 140) : new Color(102, 51, 102));
		g.fillRect(button1X, button1Y, button1W, button1H);

		g.setColor(new Color(255, 255, 255));
		g.setFont(PFont.getFont(25));
		metrics = new JFrame().getFontMetrics(g.getFont());
		t = "Resume";
		g.drawString(t, PDefense.width / 2 - metrics.stringWidth(t) / 2,
				button1Y + button1H / 2);

		// MENU BUTTON
		g.setColor(button3O ? new Color(140, 70, 140) : new Color(102, 51, 102));
		g.fillRect(button3X, button3Y, button3W, button3H);

		g.setColor(new Color(255, 255, 255));
		g.setFont(PFont.getFont(25));
		metrics = new JFrame().getFontMetrics(g.getFont());
		t = "Menu";
		g.drawString(t, PDefense.width / 2 - metrics.stringWidth(t) / 2,
				button3Y + button3H / 2);

		// MOUSE LOCATION ETC.

		button1O = PDefense.location.x >= button1X
				&& PDefense.location.x <= button1X + button1W
				&& PDefense.location.y >= button1Y
				&& PDefense.location.y <= button1Y + button1H;
		button3O = PDefense.location.x >= button3X
				&& PDefense.location.x <= button3X + button3W
				&& PDefense.location.y >= button3Y
				&& PDefense.location.y <= button3Y + button3H;

		if (PDefense.leftMouse && button1O) {
			PDefense.paused = false;
			PDefense.leftMouse = false;
		}
		if (PDefense.leftMouse && button3O) {
			PDefense.PState = PDefense.state.MENU;
			PDefense.leftMouse = false;
		}
	}
}
