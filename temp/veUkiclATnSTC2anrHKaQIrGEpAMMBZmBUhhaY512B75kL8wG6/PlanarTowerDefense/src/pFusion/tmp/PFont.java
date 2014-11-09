package pFusion.tmp;

import java.awt.Font;

public class PFont extends Font {
	public static final long serialVersionUID = 1L;

	protected PFont(Font f) {
		super(f);
	}

	public static Font getFont(float size) {
		try {
			return Font.createFont(Font.TRUETYPE_FONT,
					PFont.class.getResourceAsStream("Nexa.ttf")).deriveFont(
					size);
		} catch (Exception e) {
			return new Font("sans", Font.PLAIN, (int) size);
		}
	}
}
