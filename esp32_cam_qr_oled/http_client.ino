void get_info(String id){
  if ((wifiMulti.run() == WL_CONNECTED)) {
    HTTPClient http;
    http.begin(addrs+"get.php?type=itemname&id="+id);
    int httpCode = http.GET();
    if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK) {
        itemname = http.getString();
      }
    }
    http.end();
  }
  if ((wifiMulti.run() == WL_CONNECTED)) {
    HTTPClient http;
    http.begin(addrs+"get.php?type=price&id="+id);
    int httpCode = http.GET();
    if (httpCode > 0) {
      if (httpCode == HTTP_CODE_OK) {
        price = http.getString();
      }
    }
    http.end();
  }
  else{
    print_oled("Ошибка подключения к WiFi", 0, 30);
    itemname="ошибка";
    price="ошибка";
    }
  }
