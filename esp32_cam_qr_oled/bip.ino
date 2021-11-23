unsigned long bipstart;
unsigned long bipbipstart;

void bip() {
  if (bip1 == 1) {
    bipstart = millis();
    digitalWrite(BIP_PIN, HIGH);
    bip1 = 2;
  }
  if ((millis() - bipstart) > 100 && bip1 == 2) {
    digitalWrite(BIP_PIN, LOW);
    bip1 = 0;
  }
}

void bipone(){
  bip1 = 1;
  }
