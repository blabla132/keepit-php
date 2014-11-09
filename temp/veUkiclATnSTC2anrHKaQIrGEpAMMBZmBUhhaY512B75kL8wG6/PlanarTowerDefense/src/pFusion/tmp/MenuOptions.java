package pFusion.tmp;

import java.awt.Color;
import java.awt.FontMetrics;
import java.awt.Graphics2D;
import java.io.File;
import java.io.PrintWriter;
import java.util.ArrayList;

import javax.swing.JFrame;

public class MenuOptions {

	FontMetrics metrics;
	JFrame frame;

	int countdown = 6;

	private int button1W = 300, button1H = 60, button1X = 20, button1Y = 520;
	private boolean button1O = false;
	private int button2W = 300, button2H, button2X, button2Y = 180;
	private boolean button2O = false;

	public MenuOptions() {
		frame = new JFrame();
	}

	public void draw(Graphics2D g) {
		String t = "";

		g.setColor(new Color(102, 204, 204));
		g.fillRect(0, 0, PDefense.width, PDefense.height);

		g.setColor(new Color(0, 0, 0));
		g.setFont(PFont.getFont(35));
		metrics = frame.getFontMetrics(g.getFont());
		t = "Options";
		g.drawString(t, PDefense.width / 2 - metrics.stringWidth(t) / 2, 100);

		// AUTO-PAUSE
		g.setFont(PFont.getFont(16));
		metrics = frame.getFontMetrics(g.getFont());
		t = "Auto-Pause (focusLost)";
		g.drawString(t, 40, 180);

		button2X = 55 + metrics.stringWidth(t);
		button2H = metrics.getHeight() + 10;

		g.setFont(PFont.getFont(15));
		metrics = frame.getFontMetrics(g.getFont());
		t = String.valueOf(PDefense.autopause);

		g.setColor(button2O ? new Color(140, 70, 140) : new Color(102, 51, 102));
		g.fillRect(button2X, button2Y + metrics.getHeight() / 2 - button2H / 2,
				button2W, button2H);
		g.setColor(new Color(255, 255, 255));
		g.drawString(t, button2X + button2W / 2 - metrics.stringWidth(t) / 2,
				button2Y);

		// BACK BUTTON
		g.setColor(button1O ? new Color(70, 140, 140) : new Color(51, 102, 102));
		g.fillRect(button1X, button1Y, button1W, button1H);

		g.setColor(new Color(255, 255, 255));
		g.setFont(PFont.getFont(25));
		metrics = frame.getFontMetrics(g.getFont());
		t = "Back";
		g.drawString(t, button1X + button1W / 2 - metrics.stringWidth(t) / 2,
				button1Y + button1H / 2);

		// MOUSE LOCATION ETC.

		button1O = PDefense.location.x >= button1X
				&& PDefense.location.x <= button1X + button1W
				&& PDefense.location.y >= button1Y
				&& PDefense.location.y <= button1Y + button1H;
		button2O = PDefense.location.x >= button2X
				&& PDefense.location.x <= button2X + button2W
				&& PDefense.location.y >= button2Y
				&& PDefense.location.y <= button2Y + button2H;

		if (PDefense.leftMouse && button1O) {
			writeOptions();
			PDefense.PState = PDefense.state.MENU;
			PDefense.leftMouse = false;
		}
		if (PDefense.leftMouse && button2O) {
			PDefense.autopause = !PDefense.autopause;
			ArrayList<String> oTmp = new ArrayList<String>();
			for (String option : PDefense.options) {
				if (option.split("=")[0].equals("autopause")) {
					oTmp.add("autopause=" + !PDefense.autopause);
				} else {
					oTmp.add(option);
				}
			}
			PDefense.leftMouse = false;
		}

		if (countdown > 0) {
			countdown -= 1;
		} else {
			countdown = 6;
			writeOptions();
		}
	}

	public void writeOptions() {
		try {
			PrintWriter out = new PrintWriter(new File(PDefense.appdata
					+ File.separator + ".planar" + File.separator
					+ "options.dat"));
			for (String option : PDefense.options) {
				out.println(option);
			}
			out.flush();
			out.close();
		} catch (Exception e) {
			System.err
					.println("***** AN ERROR OCCURRED AT MenuOptions.java *****");
			e.printStackTrace();
			System.exit(0);
		}
	}
}
