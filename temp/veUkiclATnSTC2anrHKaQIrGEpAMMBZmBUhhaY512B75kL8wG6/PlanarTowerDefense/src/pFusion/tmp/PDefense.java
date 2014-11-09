package pFusion.tmp;

import java.awt.Color;
import java.awt.FontMetrics;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.MouseInfo;
import java.awt.Point;
import java.awt.RenderingHints;
import java.awt.Toolkit;
import java.awt.event.FocusEvent;
import java.awt.event.FocusListener;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;
import java.awt.event.WindowEvent;
import java.awt.event.WindowListener;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.util.ArrayList;

import javax.imageio.ImageIO;
import javax.swing.JFrame;

public class PDefense extends JFrame implements MouseMotionListener,
		MouseListener, KeyListener, FocusListener {
	public static final long serialVersionUID = 1L;

	public static boolean leftMouse = false;
	private FontMetrics metrics;

	public static Point location;
	private int button1W = 400, button1H = 60, button1X = 200, button1Y = 260;
	private boolean button1O = false;
	private int button2W = 400, button2H = 60, button2X = 200, button2Y = 330;
	private boolean button2O = false;
	private int button3W = 400, button3H = 60, button3X = 200, button3Y = 400;
	private boolean button3O = false;

	private int logowait = 80;
	BufferedImage splash;
	public static int optionsReferrer = 0;

	private String version = "0.2.1";

	Camera c;
	MenuPause mp;
	MenuOptions mo;

	static int xmouse, ymouse;
	static int width, height;
	long oldTime, time;
	static boolean paused = false;

	boolean shiftPressed = false, tabPressed = false;

	public static String appdata = System.getenv("APPDATA");
	public static ArrayList<String> options;

	static boolean autopause;

	boolean ee = false;
	JFrame eeTmp;

	int switchMapDelay = 8;

	/**
	 * 
	 * @author Michael Zhang Copyright 2013 by pFusion
	 * 
	 */

	public static enum state {
		NULL, MENU, OPTIONS, GAME
	}

	public static state PState = state.NULL;

	public static enum gstate {
		PLAYING, PAUSED
	}

	public static gstate GState = gstate.PLAYING;

	public PDefense() {
		try {
			// SEE IF DIRECTORY EXISTS
			File mainDir = new File(appdata + File.separator + ".planar");
			if (!(mainDir.exists() && mainDir.isDirectory())) {
				mainDir.mkdir();
			}

			// SEE IF OPTIONS FILE EXISTS
			boolean updated = false;
			File optionsFile = new File(appdata + File.separator + ".planar"
					+ File.separator + "options.dat");
			if (!optionsFile.exists()) {
				copyOptionsFile();
			} else {
				ArrayList<String> optionsTmp = new ArrayList<String>();
				BufferedReader in = new BufferedReader(new FileReader(appdata
						+ File.separator + ".planar" + File.separator
						+ "options.dat"));
				String line;

				while ((line = in.readLine()) != null) {
					optionsTmp.add(line);
				}
				in.close();

				for (String option : optionsTmp) {
					if (option.split("=")[0] == "version"
							&& option.split("=")[1] == version) {
						updated = true;
					}
				}
			}
			if (!updated) {
				copyOptionsFile();
			}

			// LOAD OPTIONS
			options = new ArrayList<String>();
			BufferedReader in = new BufferedReader(new FileReader(appdata
					+ File.separator + ".planar" + File.separator
					+ "options.dat"));
			String line;

			while ((line = in.readLine()) != null) {
				options.add(line);
			}
			in.close();
			for (String option : options) {
				if (option.split("=")[0].equals("autopause")) {
					autopause = option.split("=")[1].toLowerCase().trim() == "true";
				}
			}

			splash = ImageIO.read(PDefense.class.getResource("Splash.png"));

			c = new Camera();
			mp = new MenuPause();
			mo = new MenuOptions();

			setSize(800, 600);
			setTitle("Planar Tower Defense");
			setFont(PFont.getFont(30f));
			setResizable(false);
			setIconImage(ImageIO.read(PDefense.class.getResource("Icon.png")));

			setLocation(Toolkit.getDefaultToolkit().getScreenSize().width / 2
					- getWidth() / 2, Toolkit.getDefaultToolkit()
					.getScreenSize().height / 2 - getHeight() / 2);
			setDefaultCloseOperation(EXIT_ON_CLOSE);
			setVisible(true);
			setFocusable(true);
			requestFocus();
			addMouseMotionListener(this);
			addMouseListener(this);
			addKeyListener(this);
			addFocusListener(this);
			setFocusTraversalKeysEnabled(false);

			width = getWidth();
			height = getHeight();

			addMouseListener(new MouseListener() {
				public void mouseClicked(MouseEvent e) {
				}

				public void mouseEntered(MouseEvent e) {
				}

				public void mouseExited(MouseEvent e) {
				}

				public void mousePressed(MouseEvent e) {
					leftMouse = true;
				}

				public void mouseReleased(MouseEvent e) {
					leftMouse = false;
				}
			});

			Thread th = new Thread() {
				public void run() {
					try {
						while (true) {
							location = MouseInfo.getPointerInfo().getLocation();
							location.setLocation(location.x - getLocation().x,
									location.y - getLocation().y);

							if (PState == state.MENU) {
								button1O = location.x >= button1X
										&& location.x <= button1X + button1W
										&& location.y >= button1Y
										&& location.y <= button1Y + button1H;
								button2O = location.x >= button2X
										&& location.x <= button2X + button2W
										&& location.y >= button2Y
										&& location.y <= button2Y + button2H;
								button3O = location.x >= button3X
										&& location.x <= button3X + button3W
										&& location.y >= button3Y
										&& location.y <= button3Y + button3H;
							}

							if (leftMouse && button1O) {
								PState = state.GAME;
								PDefense.leftMouse = false;
							}
							if (leftMouse && button2O) {
								options(0);
								PDefense.leftMouse = false;
							}
							if (leftMouse && button3O) {
								System.out.println("Exiting the application!");
								System.exit(0);
							}

							repaint();

							Thread.sleep(50);
						}
					} catch (Exception e) {
						System.err
								.println("***** AN ERROR OCCURRED AT PDefense.java *****");
						e.printStackTrace();
						System.exit(0);
					}
				}
			};
			th.start();
		} catch (Exception e) {
			System.err
					.println("***** AN ERROR OCCURRED AT PDefense.java *****");
			e.printStackTrace();
			System.exit(0);
		}
	}

	public void paint(Graphics g) {
		try {
			Image buffer = createImage(getWidth(), getHeight());
			Graphics2D g2 = (Graphics2D) buffer.getGraphics();
			draw(g2);
			g.drawImage(buffer, 0, 0, null);
			g2.dispose();
		} catch (Exception e) {
			System.err
					.println("***** AN ERROR OCCURRED AT PDefense.java *****");
			e.printStackTrace();
			System.exit(0);
		}
	}

	public void draw(Graphics2D g) {
		g.setRenderingHints(new RenderingHints(
				RenderingHints.KEY_TEXT_ANTIALIASING,
				RenderingHints.VALUE_TEXT_ANTIALIAS_GASP));

		if (logowait > 0) {
			logowait -= 1;
			g.drawImage(splash, 0, 0, null);
			g.setColor(Color.black);
			g.setFont(PFont.getFont(12));
			// g.drawString("Menu in " + logowait + "u", 20, 40);
		} else if (logowait == 0) {
			logowait = -1;
			PState = state.MENU;
		} else {

			if (PState == state.MENU) {
				String t = "";

				g.setColor(new Color(204, 102, 204));
				g.fillRect(0, 0, getWidth(), getHeight());

				g.setColor(new Color(255, 255, 255));
				g.setFont(PFont.getFont(40));
				metrics = getFontMetrics(g.getFont());
				t = "Planar Defense";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						180);

				// PLAY BUTTON
				g.setColor(button1O ? new Color(140, 70, 140) : new Color(102,
						51, 102));
				g.fillRect(button1X, button1Y, button1W, button1H);

				g.setColor(new Color(255, 255, 255));
				g.setFont(PFont.getFont(25));
				metrics = getFontMetrics(g.getFont());
				t = "Play";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						button1Y + button1H / 2);

				// OPTION BUTTON
				g.setColor(button2O ? new Color(140, 70, 140) : new Color(102,
						51, 102));
				g.fillRect(button2X, button2Y, button2W, button2H);

				g.setColor(new Color(255, 255, 255));
				g.setFont(PFont.getFont(25));
				metrics = getFontMetrics(g.getFont());
				t = "Options";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						button2Y + button2H / 2);

				// QUIT BUTTON
				g.setColor(button3O ? new Color(140, 70, 140) : new Color(102,
						51, 102));
				g.fillRect(button3X, button3Y, button3W, button3H);

				g.setColor(new Color(255, 255, 255));
				g.setFont(PFont.getFont(25));
				metrics = getFontMetrics(g.getFont());
				t = "Exit";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						button3Y + button3H / 2);

				// MADE BY
				g.setColor(new Color(255, 255, 255));
				g.setFont(PFont.getFont(15));
				metrics = getFontMetrics(g.getFont());
				t = "Made by Michael Zhang.";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						570);
				t = "© 2013 by pFusion";
				g.drawString(t, getWidth() / 2 - metrics.stringWidth(t) / 2,
						585);
			} else if (PState == state.OPTIONS) {
				mo.draw(g);
			} else if (PState == state.GAME) {
				time = System.currentTimeMillis() - oldTime;
				oldTime += time;

				g.setRenderingHint(RenderingHints.KEY_ANTIALIASING,
						RenderingHints.VALUE_ANTIALIAS_ON);
				g.setRenderingHint(RenderingHints.KEY_RENDERING,
						RenderingHints.VALUE_RENDER_QUALITY);
				g.setRenderingHints(new RenderingHints(
						RenderingHints.KEY_TEXT_ANTIALIASING,
						RenderingHints.VALUE_TEXT_ANTIALIAS_GASP));
				update();
				draw2(g);
			}
		}
	}

	public void update() {
		if (!paused) {
			switchMapDelay -= 1;
			if (switchMapDelay <= 0)
				switchMapDelay = 0;
			if (tabPressed && switchMapDelay == 0) {
				if (shiftPressed) {
					c.prevMap();
				} else {
					c.nextMap();
				}
				tabPressed = false;
				switchMapDelay = 8;
			}
			c.update(time);
		}
	}

	public void menuUpdate() {

	}

	public void draw2(Graphics2D g) {
		if (GState == gstate.PLAYING) {
			gameDraw(g);
		} else if (GState == gstate.PAUSED) {
		}
	}

	public void gameDraw(Graphics2D g) {
		c.draw(g);
		if (paused) {
			menuDraw(g);
		}
	}

	public void menuDraw(Graphics2D g) {
		mp.draw(g);
	}

	public static void options(int referrer) {
		// REFERRER ID
		//
		// 0: MENU
		// 1: GAME
		optionsReferrer = referrer;
		PState = state.OPTIONS;
	}

	public void copyOptionsFile() throws Exception {
		File optionsFile = new File(appdata + File.separator + ".planar"
				+ File.separator + "options.dat");
		BufferedReader in = new BufferedReader(new InputStreamReader(
				PDefense.class.getResourceAsStream("defaultOptions.dat")));
		PrintWriter out = new PrintWriter(optionsFile);
		String line;

		while ((line = in.readLine()) != null) {
			out.println(line);
		}
		in.close();
		out.flush();
		out.close();
	}

	public void focusGained(FocusEvent e) {
	}

	public void focusLost(FocusEvent e) {
		if (GState == gstate.PLAYING && autopause) {
			paused = true;
		}
	}

	public void keyPressed(KeyEvent e) {
		switch (e.getKeyCode()) {
		case KeyEvent.VK_TAB:
			tabPressed = true;
			break;
		case KeyEvent.VK_SHIFT:
			shiftPressed = true;
			break;
		case KeyEvent.VK_ESCAPE:
			if (GState == gstate.PLAYING) {
				paused = !paused;
			}
			break;

		// E
		case KeyEvent.VK_Q:
			eeTmp = new JFrame();
			eeTmp.setUndecorated(true);
			eeTmp.setSize(Toolkit.getDefaultToolkit().getScreenSize());
			eeTmp.setAlwaysOnTop(true);
			eeTmp.addWindowListener(new WindowListener() {
				public void windowActivated(WindowEvent e) {
				}

				public void windowClosed(WindowEvent e) {
				}

				public void windowClosing(WindowEvent e) {
					ee = false;
				}

				public void windowDeactivated(WindowEvent e) {
				}

				public void windowDeiconified(WindowEvent e) {
				}

				public void windowIconified(WindowEvent e) {
				}

				public void windowOpened(WindowEvent e) {
				}
			});
			ee = true;
			eeTmp.setVisible(true);
			break;
		}
	}

	public void keyReleased(KeyEvent e) {
		switch (e.getKeyCode()) {
		case KeyEvent.VK_TAB:
			tabPressed = false;
			break;
		case KeyEvent.VK_SHIFT:
			shiftPressed = false;
			break;
		}
	}

	public void keyTyped(KeyEvent e) {
	}

	public void mouseClicked(MouseEvent e) {
	}

	public void mouseEntered(MouseEvent e) {
	}

	public void mouseExited(MouseEvent e) {
	}

	public void mousePressed(MouseEvent e) {
		leftMouse = true;
	}

	public void mouseReleased(MouseEvent e) {
		leftMouse = false;
	}

	public void mouseDragged(MouseEvent e) {
	}

	public void mouseMoved(MouseEvent e) {
	}

	public static void main(String[] args) {
		new PDefense();
	}
}
