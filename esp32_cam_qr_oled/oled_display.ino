void print_oled(String text , int x, int y) {
  display.clearDisplay(); // очистка дисплея
  display.setTextSize(1); // установка размера шрифта
  display.setTextColor(WHITE); // установка цвета текста
  display.setCursor(x, y); // установка курсора в позицию
  display.print(utf8rus(text)); // записываем в буфер дисплея нашу фразу
  display.display(); // и её выводим на экран
}

void print_item(String id, String itemname, String price) {
  display.clearDisplay(); 
  display.setTextSize(1); 
  display.setTextColor(WHITE); 
  display.setCursor(0, 0); 
  display.print(utf8rus("Код товару:"));
  display.setCursor(68, 0);
  display.print(id); 
  display.setCursor(0, 10); 
  display.print(utf8rus("Назва товару:")); 
  display.setCursor(80, 10); 
  display.print(utf8rus(itemname)); 
  display.setCursor(0, 40); 
  display.print(utf8rus("Цiна:")); 
  display.setCursor(32, 40); 
  display.print(price + utf8rus(" грн.")); 
  display.display();
}
