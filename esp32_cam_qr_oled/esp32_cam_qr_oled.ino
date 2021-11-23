#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <ESP32QRCodeReader.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <WiFiMulti.h>

#define OLED_RESET 7
#define BIP_PIN 4
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define USE_SERIAL Serial

Adafruit_SSD1306 display(OLED_RESET);
ESP32QRCodeReader reader(CAMERA_MODEL_AI_THINKER);
WiFiMulti wifiMulti;

struct QRCodeData qrCodeData;
bool isConnected = false;
int Human_Counter_New;
int bip1 = 0;
char buffer[128];
String itemname, price;
String addrs = "http://192.168.0.5/";

void setup()
{
  Serial.begin(115200);
  pinMode(14, INPUT_PULLUP);
  pinMode(15, INPUT_PULLUP);
  pinMode(BIP_PIN, OUTPUT);
  Wire.begin(14, 15);
  display = Adafruit_SSD1306(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  // инициализация дисплея по интерфейсу I2C, адрес 0x3C
  reader.setup();
  reader.begin();
  print_oled("Запуск пристрою", 20, 30);
  delay(3000);
  print_oled("Пiдключення до WiFi", 5, 30);
  wifiMulti.addAP("NeedSpeed", "ineedforspeed2018");
  while (wifiMulti.run() != WL_CONNECTED) {
    print_oled("Нема WiFi пiдключення", 0, 30);
    delay(500);
  }
  bipone();
  print_oled("Вiдсканируйте код", 10, 30);

}

void loop()
{
  bip();
  if (reader.receiveQrCode(&qrCodeData, 100))
  {
    Serial.println("Найден QR Код");
    if (qrCodeData.valid)
    {
      bipone();
      get_info((const char *)qrCodeData.payload);
      print_item((const char *)qrCodeData.payload, itemname, price);
    }
  }
}
